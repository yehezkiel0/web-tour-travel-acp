export const initBookingDetail = ($) => {
    if ($("body").data("page") === "booking_show_detail") {
        const $withVisaCheckboxes = $(".with-visa");
        const individualVisaRate = window.bookingData.individualVisaRate;
        const groupVisaRate = window.bookingData.groupVisaRate;
        const taxPercentage = window.bookingData.taxPercentage;

        let total;

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
            } else {
                visaTotal = checkedVisas * individualVisaRate;
                $(".individual-visa").removeClass("hidden").addClass("grid");
                $(".group-visa").addClass("hidden").removeClass("grid");

                $("#individual-visa-count").text(checkedVisas);
                $("#individual-visa-amount").text(formatIDR(visaTotal));
            }

            const subtotal =
                window.bookingData.adultPrice +
                window.bookingData.childPrice +
                visaTotal;

            const tax = (subtotal + visaTotal) * (taxPercentage / 100);
            total = subtotal + tax;

            $("#sub-total").text(formatIDR(subtotal));
            $("#tax-amount").text(formatIDR(tax));
            $("#total-amount").text(formatIDR(total));
        }

        $("#book-now").submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route("booking_store")}}',
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    total: total,
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error("Booking error:", error);
                },
            });
        });

        $withVisaCheckboxes.on("change", updateBillDetails);
    }
};
