export default () => {
    const $locationSelect = $(".location-select");
    const $starRatingCheckbox = $(".star-rating-checkbox");
    const $priceRange = $(".price-range");
    const $minPriceInput = $(".min-price");
    const $maxPriceInput = $(".max-price");
    const $hotelResults = $("#hotel-results");
    const $loadingOverlay = $("#loading-overlay");
    const $clearAllBtn = $(".clear-all-btn");
    const $clearLocationBtn = $(".clear-location-btn");
    const $clearRatingBtn = $(".clear-rating-btn");

    // Get initial max price from data attribute
    const dynamicMax = parseInt($priceRange.attr("max"));
    let currentMin = 0;
    let currentMax = dynamicMax;

    // Initialize price range
    $priceRange.val(dynamicMax);
    $minPriceInput.val(0);
    $maxPriceInput.val(dynamicMax);

    // Price range change handler
    $priceRange.on("input", function () {
        currentMax = parseInt($(this).val());
        $maxPriceInput.val(currentMax);
        updateResults();
    });

    // Location select change handler
    $locationSelect.on("change", () => updateResults());

    // Star rating checkbox change handler
    $starRatingCheckbox.on("change", () => updateResults());

    // Clear All Filters
    $clearAllBtn.on("click", function (e) {
        e.preventDefault();
        $locationSelect.val("");
        $starRatingCheckbox.prop("checked", false);
        $priceRange.val(dynamicMax);
        currentMin = 0;
        currentMax = dynamicMax;
        $minPriceInput.val(0);
        $maxPriceInput.val(dynamicMax);
        updateResults(true);
    });

    // Clear Location
    $clearLocationBtn.on("click", function (e) {
        e.preventDefault();
        $locationSelect.val("");
        updateResults();
    });

    // Clear Rating
    $clearRatingBtn.on("click", function (e) {
        e.preventDefault();
        $starRatingCheckbox.prop("checked", false);
        updateResults();
    });

    // Debounce timer
    let debounceTimer;

    function updateResults(isClear = false) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            let filters = {};

            if (!isClear) {
                // Location filter
                if ($locationSelect.val()) {
                    filters.city = $locationSelect.val();
                }

                // Star rating filter (multiple)
                const selectedRatings = $starRatingCheckbox
                    .filter(":checked")
                    .map(function () {
                        return $(this).val();
                    })
                    .get();

                if (selectedRatings.length > 0) {
                    filters.star_rating = selectedRatings;
                }

                // Price range filter
                if (currentMax < dynamicMax) {
                    filters.max_price = currentMax;
                }
                if (currentMin > 0) {
                    filters.min_price = currentMin;
                }
            }

            // Show loading
            $loadingOverlay.removeClass("hidden");

            // AJAX request
            $.ajax({
                url: "/hotel/filter",
                method: "GET",
                data: filters,
                success: function (response) {
                    setTimeout(() => {
                        $loadingOverlay.addClass("hidden");
                        $("#hotels-container").html(response);
                    }, 500); // Simulate loading for smooth UX
                },
                error: function (xhr, status, error) {
                    $loadingOverlay.addClass("hidden");
                    console.error("Filter error:", error);
                    alert("Failed to load hotels. Please try again.");
                },
            });
        }, 300);
    }

    // Mobile filter toggle
    $(document).ready(function () {
        $(".filter-toggle-btn").on("click", function () {
            $(".mobile-filter-overlay")
                .removeClass("translate-x-full")
                .addClass("translate-x-0");
        });

        $(".close-filter-btn").on("click", function () {
            $(".mobile-filter-overlay")
                .removeClass("translate-x-0")
                .addClass("translate-x-full");
        });
    });
};
