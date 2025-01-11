export const initSearchResult = ($) => {
    // Format number to IDR
    const formatIDR = (number) => {
        return `IDR ${number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    };

    // Parse IDR string to number
    const parseIDR = (str) => {
        return parseInt(str.replace(/[^\d]/g, ""));
    };

    const $priceRange = $(".price-range");
    const $minPrice = $(".min-price");
    const $maxPrice = $(".max-price");

    // Nilai default
    const defaultMin = 0;
    let dynamicMax = 16000000; // Menggunakan variabel dinamis

    // Set nilai awal pada input
    $minPrice.val(formatIDR(defaultMin));
    $maxPrice.val(formatIDR(dynamicMax));
    $priceRange.attr("max", dynamicMax).val(defaultMin);

    // Event untuk memperbarui slider saat min price berubah
    $minPrice.on("input", function () {
        let value = parseIDR($(this).val());
        if (isNaN(value) || value < defaultMin) value = defaultMin;
        if (value > dynamicMax) value = dynamicMax;
        $(this).val(formatIDR(value));
        $priceRange.val(value);
    });

    // Event untuk memperbarui nilai maksimum yang dinamis
    $maxPrice.on("input", function () {
        let value = parseIDR($(this).val());
        if (isNaN(value) || value < defaultMin) value = defaultMin;

        dynamicMax = value;
        $maxPrice.val(formatIDR(dynamicMax));
        $priceRange.attr("max", dynamicMax);
    });

    // Event pada slider
    $priceRange.on("input", function () {
        const value = parseInt($(this).val());
        $minPrice.val(formatIDR(value));
    });

    // Clear all functionality
    $(".clear-all-btn").click(function () {
        $(".location-select").val("");
        $(".date-input").val("2025-09-01");
        $priceRange.val(defaultCurrent);
        $minPrice.val(formatIDR(defaultMin));
        $maxPrice.val(formatIDR(defaultMax));
        $(".trip-type").prop("checked", false);
    });

    // Clear individual sections
    $(".clear-location-btn").click(function () {
        $(".location-select").val("");
    });

    $(".clear-date-btn").click(function () {
        $(".date-input").val("2025-09-01");
    });

    $(".clear-type-btn").click(function () {
        $(".trip-type").prop("checked", false);
    });
};
