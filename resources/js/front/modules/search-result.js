export const initSearchResult = ($) => {
    const formatIDR = (number) => {
        return `IDR ${number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    };
    const parseIDR = (str) => {
        return parseInt(str.replace(/[^\d]/g, ""));
    };

    const $priceRange = $(".price-range");
    const $minPrice = $(".min-price");
    const $maxPrice = $(".max-price");
    const $locationSelect = $(".location-select");
    const $dateInput = $(".date-input");
    const $tripType = $(".trip-type");

    const defaultMin = 0;
    let dynamicMax = $maxPrice.val();
    const defaultMax = dynamicMax;

    $minPrice.val(formatIDR(defaultMin));
    $maxPrice.val(formatIDR(dynamicMax));
    $priceRange.attr("max", dynamicMax).val(defaultMin);

    $minPrice.on("input", function () {
        let value = parseIDR($(this).val());
        if (isNaN(value) || value < defaultMin) value = defaultMin;
        if (value > dynamicMax) value = dynamicMax;
        $(this).val(formatIDR(value));
        $priceRange.val(value);
    });

    $maxPrice.on("input", function () {
        let value = parseIDR($(this).val());
        if (isNaN(value) || value < defaultMin) value = defaultMin;
        dynamicMax = value;
        $maxPrice.val(formatIDR(dynamicMax));
        $priceRange.attr("max", dynamicMax);
    });

    $priceRange.on("input", function () {
        const value = parseInt($(this).val());
        $minPrice.val(formatIDR(value));
    });

    $(".clear-all-btn").click(function () {
        $(".location-select").val("");
        clearDate(".date-input");
        $(".trip-type").prop("checked", false);
        $priceRange.val(defaultMin);
        $minPrice.val(formatIDR(defaultMin));
        $maxPrice.val(formatIDR(defaultMax));
        updateResults();
    });

    $(".clear-location-btn").click(function () {
        $(".location-select").val("");
    });

    $(".clear-date-btn").click(function () {
        clearDate(".date-input");
        updateResults();
    });

    $(".clear-type-btn").click(function () {
        $(".trip-type").prop("checked", false);
    });

    function clearDate(selectorInput) {
        $(selectorInput).val("");
    }

    $(".price-range").on("input", function () {
        updateResults();
    });

    $(".location-select").on("change", function () {
        updateResults();
    });

    $(".trip-type").on("change", function () {
        updateResults();
    });

    $(".date-input").on("change", function () {
        updateResults();
    });

    let debounceTimer;
    function updateResults() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const min_price = parseIDR($minPrice.val());
            const max_price = parseIDR($maxPrice.val());
            const location = $locationSelect.val();
            const date = $dateInput.val();
            const tripType = $tripType
                .filter(":checked")
                .map(function () {
                    return $(this).val();
                })
                .get();

            $.ajax({
                url: "/filter-search",
                method: "GET",
                data: {
                    min_price: min_price,
                    max_price: max_price,
                    location: location,
                    date: date,
                    trip_type: JSON.stringify(tripType),
                },
                success: function (response) {
                    $("#search-results").html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }, 300);
    }
};
