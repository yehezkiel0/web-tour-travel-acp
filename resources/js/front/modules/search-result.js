export const initSearchResult = ($) => {
    const formatIDR = (number) => {
        if (!number) return "";
        return `IDR ${number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    };

    const parseIDR = (str) => {
        if (!str) return "";
        return parseInt(str.replace(/[^\d]/g, ""));
    };

    const $priceRange = $(".price-range");
    const $minPrice = $(".min-price");
    const $maxPrice = $(".max-price");
    const $locationSelect = $(".location-select");
    const $dateInput = $(".date-input");
    const $tripType = $(".trip-type");
    const $searchResults = $("#search-results");

    const defaultMin = 0;
    let dynamicMax = $maxPrice.val();
    let currentMax = dynamicMax;
    let currentMin = defaultMin;

    $minPrice.val(formatIDR(defaultMin));
    $maxPrice.val(formatIDR(dynamicMax));
    $priceRange.attr({
        min: defaultMin,
        max: dynamicMax,
        value: defaultMin,
    });

    $minPrice.on("input", function () {
        let value = parseIDR($(this).val());

        if (isNaN(value) || value < defaultMin) value = defaultMin;
        if (value > currentMax) value = currentMax;

        currentMin = value;
        $(this).val(formatIDR(value));
        $priceRange.val(value);
        updateResults();
    });

    $maxPrice.on("input", function () {
        let value = parseIDR($(this).val());
        const maxPriceLimit = parseInt($(this).data("max-price"));

        if (isNaN(value) || value < currentMin) value = currentMin;
        if (value > maxPriceLimit) value = maxPriceLimit;

        currentMax = value;

        $(this).val(formatIDR(value));
        $priceRange.attr("max", value);
        updateResults();
    });

    $priceRange.on("input", function () {
        const value = parseInt($(this).val());
        currentMin = value;
        $minPrice.val(formatIDR(value));

        if (value > currentMax) {
            currentMax = value;
            $maxPrice.val(formatIDR(value));
        }
        updateResults();
    });

    $(".clear-all-btn").click(function () {
        $locationSelect.val("");
        $dateInput.val("");
        $tripType.prop("checked", false);

        currentMin = defaultMin;
        currentMax = dynamicMax;
        $priceRange.val(defaultMin).attr("max", dynamicMax);
        $minPrice.val(formatIDR(defaultMin));
        $maxPrice.val(formatIDR(dynamicMax));

        updateResults(true);
    });

    $(".clear-location-btn").click(function () {
        $locationSelect.val("");
        updateResults(true);
    });

    $(".clear-date-btn").click(function () {
        $dateInput.val("");
        updateResults(true);
    });

    $(".clear-type-btn").click(function () {
        $tripType.prop("checked", false);
        updateResults(true);
    });

    $locationSelect.on("change", () => updateResults(false));
    $tripType.on("change", () => updateResults(false));
    $dateInput.on("change", () => updateResults(false));

    let debounceTimer;
    function updateResults(isClear = false) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            let filters = {};

            if (!isClear) {
                if (currentMin > defaultMin) filters.min_price = currentMin;
                if (currentMax < dynamicMax) filters.max_price = currentMax;
                if ($locationSelect.val())
                    filters.location = $locationSelect.val();
                if ($dateInput.val()) filters.date = $dateInput.val();
                if ($priceRange.val() > 0)
                    filters.price_range = $priceRange.val();

                const selectedTypes = $tripType
                    .filter(":checked")
                    .map(function () {
                        return $(this).val();
                    })
                    .get();

                if (selectedTypes.length > 0) {
                    filters.trip_type = selectedTypes;
                }
            }
            $searchResults.addClass("loading");

            $.ajax({
                url: "/search-result",
                method: "GET",
                data: filters,
                success: function (response) {
                    setTimeout(() => {
                        $searchResults.removeClass("loading");
                        $("#search-results").html(response);
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    $searchResults.removeClass("loading");
                    console.error("Filter error:", error);
                },
            });
        }, 300);
    }
};
