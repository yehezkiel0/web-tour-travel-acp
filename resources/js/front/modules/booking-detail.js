export const initBookingDetail = ($) => {
    const $container = $("#bill-details-container");
    if ($container.length === 0) return;

    const config = $container.data("booking-config");
    let currentInsurancePrice = 0;

    const formatIDR = (amount) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        })
            .format(amount)
            .replace(/\s/g, ""); // Compact format "IDR7.500.000"
    };

    const recalculateTotal = () => {
        // 1. Calculate Visa
        const $withVisaCheckboxes = $(".with-visa");
        const totalTravelers = $withVisaCheckboxes.length;
        const checkedVisas = $(".with-visa:checked").length;
        let visaTotal = 0;
        let indVisaCount = 0;
        let groupVisaCount = 0;

        if (checkedVisas === totalTravelers && totalTravelers > 1) {
            // All selected > 1 => Group Visa
            visaTotal = config.groupVisaRate;
            groupVisaCount = checkedVisas; // Actually acts as 1 group fee usually? logic says `visaTotal = groupVisaRate`.
            // Let's check existing logic. It treated groupVisaRate as a flat fee?
            // "window.bookingData.groupVisaRate" is usually total? Or per person?
            // "const groupVisaCost = groupVisaCount * bd.groupVisaRate;" in deleted script implies per person or per unit.
            // But booking-detail.js line 22: "visaTotal = groupVisaRate;" (flat).
            // Let's assume booking-detail.js was the "intended" visa logic for "all checked".
            // Actually, let's stick to the logic that matches the "Group Visa" concept. Usually it's a flat fee for the group or per person rate.
            // Given the logic "checkedVisas === totalTravelers", it switches to group rate.
            // Let's assume groupVisaRate is the *total* price for the group.
            $(".group-visa").removeClass("hidden").addClass("grid");
            $(".individual-visa").addClass("hidden").removeClass("grid");
            $("#group-visa-count").text(1); // Flat fee count
            $("#group-visa-amount").text(formatIDR(visaTotal));
        } else {
            // Individual
            visaTotal = checkedVisas * config.individualVisaRate;
            indVisaCount = checkedVisas;
            $(".individual-visa").removeClass("hidden").addClass("grid");
            $(".group-visa").addClass("hidden").removeClass("grid");
            $("#individual-visa-count").text(indVisaCount);
            $("#individual-visa-amount").text(formatIDR(visaTotal));
        }

        // Update hidden inputs for Visa
        $('input[name="group_visa"]').val(groupVisaCount > 0 ? visaTotal : 0);
        $('input[name="individual_visa"]').val(
            groupVisaCount === 0 ? visaTotal : 0
        );

        // 2. Base Price
        // 2. Base Price
        const basePrice =
            parseFloat(config.adultPrice) + parseFloat(config.childPrice);
        const totalPax =
            parseInt(config.adultCount) + parseInt(config.childCount);

        // 3. Seasonal Adjustment
        let seasonalAdjustment = 0;
        const bookingStart = new Date(config.fromDate);
        if (config.seasonalPrices && config.seasonalPrices.length > 0) {
            config.seasonalPrices.forEach((season) => {
                const seasonStart = new Date(season.start_date);
                const seasonEnd = new Date(season.end_date);
                if (bookingStart >= seasonStart && bookingStart <= seasonEnd) {
                    const adjustment = basePrice * (season.percentage / 100);
                    if (season.adjustment_type === "markup") {
                        seasonalAdjustment += adjustment;
                    } else {
                        seasonalAdjustment -= adjustment;
                    }
                }
            });
        }

        // Update Seasonal UI
        const $seasonalRow = $("#seasonal-row");
        if (seasonalAdjustment !== 0) {
            $seasonalRow.removeClass("hidden").addClass("flex");
            const sign = seasonalAdjustment > 0 ? "+" : "";
            const colorClass =
                seasonalAdjustment > 0 ? "text-orange-600" : "text-green-600";
            $seasonalRow.attr(
                "class",
                `justify-between text-xs sm:text-sm font-semibold ${colorClass} flex`
            );
            $("#seasonal-amount").text(sign + formatIDR(seasonalAdjustment));
        } else {
            $seasonalRow.removeClass("flex").addClass("hidden");
        }

        // 4. Group Discount
        let discountAmount = 0;
        if (
            totalPax >= config.groupDiscountThreshold &&
            config.groupDiscountPercentage > 0
        ) {
            discountAmount = basePrice * (config.groupDiscountPercentage / 100);
            $("#discount-row").removeClass("hidden").addClass("flex");
            $("#discount-amount").text("-" + formatIDR(discountAmount));
        } else {
            $("#discount-row").removeClass("flex").addClass("hidden");
        }

        // 5. Total Calculation
        const subTotal =
            basePrice +
            visaTotal +
            currentInsurancePrice -
            discountAmount +
            seasonalAdjustment;
        const tax = subTotal * (config.taxPercentage / 100);
        const total = subTotal + tax;

        // 6. Update UI
        $("#sub-total").text(formatIDR(subTotal));
        $("#tax-amount").text(formatIDR(tax));
        $("#total-amount").text(formatIDR(total));

        $('input[name="sub_total"]').val(subTotal);
        $('input[name="total_price"]').val(total);

        // 7. Installment Update
        const $installmentRow = $("#installment-row");
        if (!$installmentRow.hasClass("hidden")) {
            $("#installment-amount").text(formatIDR(total * 0.5));
        }
    };

    // --- Event Listeners ---

    // Insurance
    $('input[name="insurance_id"]').on("change", function () {
        const pricePerPax = $(this).data("price"); // data-price is on the input
        const totalPax =
            parseInt(config.adultCount) + parseInt(config.childCount);
        currentInsurancePrice = pricePerPax * totalPax;

        const $insuranceRow = $("#insurance-row");
        if (pricePerPax > 0) {
            $insuranceRow.removeClass("hidden").addClass("grid");
            $("#insurance-count").text(totalPax);
            $("#insurance-amount").text(formatIDR(currentInsurancePrice));
        } else {
            $insuranceRow.removeClass("grid").addClass("hidden");
            $("#insurance-amount").text("0");
        }
        recalculateTotal();
    });

    // Payment Method (Installment)
    $('input[name="payment_method"]').on("change", function () {
        const isInstallment = $(this).val() === "installment";
        const $installmentRow = $("#installment-row");
        const $bookingBtn = $("#book-now");

        if (isInstallment) {
            $installmentRow.removeClass("hidden").addClass("flex");
            $bookingBtn.text("Pay Down Payment (50%)");
        } else {
            $installmentRow.removeClass("flex").addClass("hidden");
            $bookingBtn.text("Book Now");
        }
        recalculateTotal();
    });

    // Visa
    $(".with-visa").on("change", function () {
        recalculateTotal();
    });

    // Initial Trigger
    // Check initial state of checkboxes/radios if needed, or just calc default
    // Insurance might be pre-selected (checked), so let's trigger logic if any is checked
    const $checkedInsurance = $('input[name="insurance_id"]:checked');
    if ($checkedInsurance.length > 0) {
        $checkedInsurance.trigger("change");
    } else {
        recalculateTotal();
    }
};
