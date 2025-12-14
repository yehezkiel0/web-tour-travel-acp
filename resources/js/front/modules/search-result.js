import { debounce } from "../utils/eventUtils";

export const initSearchResult = ($) => {
    // Selectors
    const $container = $("#search-results-grid");
    const $loading = $("#loading-state");
    const $count = $("#result-count");

    // Inputs (mapped to the new ID structure in blade)
    const $inputs = {
        q: $("#filter-q"),
        location: $("#filter-location"),
        date: $("#filter-date"),
        minPrice: $("#filter-min-price"),
        maxPrice: $("#filter-max-price"),
        duration: $('input[name="duration"]'),
        tripType: $('input[name="trip_type[]"]'),
        sort: $("#sort-select"),
    };

    // Mobile Toggle Logic
    const initMobileToggle = () => {
        const $sidebar = $("#filter-sidebar");
        const $backdrop = $("#filter-backdrop");
        const $toggleBtn = $("#mobile-filter-toggle");
        const $closeBtn = $("#close-filter-sidebar");

        const open = () => {
            $sidebar.removeClass("translate-x-full");
            $backdrop.removeClass("hidden");
            $("body").addClass("overflow-hidden");
        };

        const close = () => {
            $sidebar.addClass("translate-x-full");
            $backdrop.addClass("hidden");
            $("body").removeClass("overflow-hidden");
        };

        $toggleBtn.on("click", open);
        $closeBtn.on("click", close);
        $backdrop.on("click", close);
    };

    // Collect current filter state
    const getFilters = () => {
        const filters = {};

        // Text & Selects
        if ($inputs.q.val()) filters.q = $inputs.q.val();
        if ($inputs.location.val()) filters.location = $inputs.location.val();
        if ($inputs.date.val()) filters.date = $inputs.date.val();
        if ($inputs.sort.val()) filters.sort = $inputs.sort.val();

        // Numbers
        if ($inputs.minPrice.val()) filters.min_price = $inputs.minPrice.val();
        if ($inputs.maxPrice.val()) filters.max_price = $inputs.maxPrice.val();

        // Radios (Duration)
        const duration = $('input[name="duration"]:checked').val();
        if (duration) filters.duration = duration;

        // Checkboxes (Trip Type)
        const types = [];
        $('input[name="trip_type[]"]:checked').each(function () {
            types.push($(this).val());
        });
        if (types.length) filters.trip_type = types;

        return filters;
    };

    // Main Fetch Function
    const fetchResults = (url = null) => {
        let fetchUrl = url;
        let data = {};

        // If no URL provided (normal filter change), build it from filters
        if (!fetchUrl) {
            const filters = getFilters();
            // Reset to page 1 by not including page param (default)
            // unless we want to keep it? No, changing filters usually resets page.
            data = filters;
            fetchUrl = window.searchConfig?.url || "/search-result";
        }

        // 1. Update URL (without reload)
        // If we have a direct URL (pagination), use it.
        // If we have data (filters), build query string.
        let pushUrl = fetchUrl;
        if (!url) {
            const queryString = $.param(data);
            pushUrl = `${window.location.pathname}?${queryString}`;
        }
        window.history.pushState({ path: pushUrl }, "", pushUrl);

        // 2. UI Loading State
        $container.addClass("opacity-50 pointer-events-none");
        $loading.removeClass("hidden");

        // 3. Ajax Request
        $.ajax({
            url: fetchUrl,
            method: "GET",
            data: data, // Only sent if building from filters
            cache: false,
            success: (html) => {
                $container.html(html);
                $container.removeClass("opacity-50 pointer-events-none");
                $loading.addClass("hidden");

                // Scroll to top of results on pagination
                if (url) {
                    $("html, body").animate(
                        {
                            scrollTop: $container.offset().top - 100,
                        },
                        500
                    );
                }

                // Update count (Approximate based on DOM elements returned)
                // Note: Pagination introduces complex counting client-side.
                // Ideally backend returns JSON metadata.
                // For now, we won't strictly update count from partials as it only shows current page count.
                // Leaving count update disabled or simple check.
            },
            error: (err) => {
                console.error("Search Failed", err);
                $container.removeClass("opacity-50 pointer-events-none");
                $loading.addClass("hidden");
            },
        });
    };

    // Initialize Event Listeners
    const initListeners = () => {
        // Debounced inputs (Text/Number)
        // Only debounce fetch if NOT on mobile (or if mobile sidebar is closed)
        const debouncedFetch = debounce(() => {
            if (isMobileAndOpen()) return;
            fetchResults();
        }, 500);

        $inputs.q.on("input", debouncedFetch);
        $inputs.minPrice.on("input", debouncedFetch);
        $inputs.maxPrice.on("input", debouncedFetch);

        // Instant inputs (Select, Date, Radio, Checkbox)
        const instantFetch = () => {
            if (isMobileAndOpen()) return;
            fetchResults();
        };

        $inputs.location.on("change", instantFetch);
        $inputs.date.on("change", instantFetch);
        $inputs.sort.on("change", instantFetch);
        $inputs.duration.on("change", instantFetch);
        $inputs.tripType.on("change", instantFetch);

        // Helper to check if mobile sidebar is active
        const isMobileAndOpen = () => {
            const $sidebar = $("#filter-sidebar");
            const isMobile = $(window).width() < 768; // Tailwind md breakpoint
            const isOpen = !$sidebar.hasClass("translate-x-full");
            return isMobile && isOpen;
        };

        // Price Presets
        $(".price-preset").on("click", function () {
            const max = $(this).data("max");
            $inputs.maxPrice.val(max).trigger("input");
        });

        // Reset (Desktop)
        $("#reset-filters").on("click", () => {
            resetInputs();
            fetchResults();
        });

        // Reset (Mobile)
        $("#mobile-reset-filters").on("click", () => {
            resetInputs();
            // Do not fetch immediately, let user click Apply
        });

        // Apply Filters (Mobile)
        $("#apply-filters").on("click", () => {
            fetchResults();
            // Close sidebar
            $("#filter-sidebar").addClass("translate-x-full");
            $("#filter-backdrop").addClass("hidden");
            $("body").removeClass("overflow-hidden");
        });

        function resetInputs() {
            $inputs.q.val("");
            $inputs.location.val("");
            $inputs.date.val("");
            $inputs.minPrice.val("");
            $inputs.maxPrice.val("");
            $inputs.sort.val(""); // Keep sort? Usually reset doesn't reset sort, but code says yes.
            $('input[name="duration"]').prop("checked", false);
            $('input[name="trip_type[]"]').prop("checked", false);
        }

        // Pagination Click Handler
        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            const url = $(this).attr("href");
            if (url) {
                fetchResults(url);
            }
        });
    };

    // Run on Init
    $(() => {
        initMobileToggle();
        initListeners();
    });
};
