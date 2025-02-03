export const initBookingDetail = ($) => {
    const $withVisaCheckboxes = $(".with-visa");
    const individualVisaRate = parseFloat(
        '{{ session("booking.individual_visa_rate") }}'
    );
    const groupVisaRate = parseFloat(
        '{{ session("booking.group_visa_rate") }}'
    );
    const taxPercentage = parseFloat('{{ session("booking.tax_percentage") }}');

    function updateBillDetails() {
        const totalTravelers = $withVisaCheckboxes.length;
        const checkedVisas = $(".with-visa:checked").length;

        let visaTotal = 0;

        // Jika semua traveler memilih visa, gunakan tarif group
        if (checkedVisas === totalTravelers && totalTravelers > 1) {
            visaTotal = groupVisaRate;
            $(".group-visa").removeClass("hidden").addClass("grid");
            $(".individual-visa").addClass("hidden");
        } else {
            // Jika tidak, gunakan tarif individual per traveler
            visaTotal = checkedVisas * individualVisaRate;
            $(".individual-visa").removeClass("hidden").addClass("grid");
            $(".group-visa").addClass("hidden");
        }

        const subtotal = parseFloat(
            '{{ session("booking.adult_price") + session("booking.child_price") }}'
        );
        const tax = (subtotal + visaTotal) * (taxPercentage / 100);
        const total = subtotal + visaTotal + tax;

        // Update tampilan detail tagihan
        $("#visa-amount").text(formatCurrency(visaTotal));
        $("#tax-amount").text(formatCurrency(tax));
        $("#total-amount").text(formatCurrency(total));
    }

    // Event listener untuk checkbox visa
    $withVisaCheckboxes.on("change", updateBillDetails);
};
