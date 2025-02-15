export const initBookingDetail = ($) => {
    if ($("body").data("page") === "booking_details") {
        const $withVisaCheckboxes = $(".with-visa");
        const individualVisaRate = window.bookingData.individualVisaRate;
        const groupVisaRate = window.bookingData.groupVisaRate;
        const taxPercentage = window.bookingData.taxPercentage;

        const formatIDR = (price) => {
            if (!price) return "";
            return `IDR ${price
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        };

        function updateBillDetails() {
            const totalTravelers = $withVisaCheckboxes.length;
            const checkedVisas = $(".with-visa:checked").length;

            let visaTotal = 0;

            if (checkedVisas === totalTravelers && totalTravelers > 1) {
                visaTotal = groupVisaRate;
                $(".group-visa").removeClass("hidden").addClass("grid");
                $(".individual-visa").addClass("hidden").removeClass("grid");

                $("#group-visa-count").text(checkedVisas);
                $("#group-visa-amount").text(formatIDR(visaTotal));
                $('input[name="group_visa"]').val(visaTotal);
            } else {
                visaTotal = checkedVisas * individualVisaRate;
                $(".individual-visa").removeClass("hidden").addClass("grid");
                $(".group-visa").addClass("hidden").removeClass("grid");

                $("#individual-visa-count").text(checkedVisas);
                $("#individual-visa-amount").text(formatIDR(visaTotal));
                $('input[name="individual_visa"]').val(visaTotal);
            }

            const subtotal =
                window.bookingData.adultPrice +
                window.bookingData.childPrice +
                visaTotal;

            const tax = subtotal * (taxPercentage / 100);
            const total = subtotal + tax;

            $("#sub-total").text(formatIDR(subtotal));
            $("#tax-amount").text(formatIDR(tax));
            $("#total-amount").text(formatIDR(total));

            $('input[name="total_price"]').val(total);
            $('input[name="sub_total"]').val(subtotal);
        }

        $withVisaCheckboxes.on("change", updateBillDetails);
        updateBillDetails();
    }
};
