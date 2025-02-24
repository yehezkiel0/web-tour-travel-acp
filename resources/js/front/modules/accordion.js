export const initAccordion = ($) => {
    const accordions = $(".accordion");
    const firstAccordion = accordions.first();

    // Set initial state
    firstAccordion.addClass("active");
    updateTagBackground();

    // Use event delegation for better performance
    $(".wrapper-accordion").on("mouseenter", ".accordion", function (e) {
        const clickedAccordion = $(this);

        if (clickedAccordion.hasClass("active")) {
            return;
        }

        // Remove active state from all accordions
        accordions.removeClass("active");

        // Add active state to clicked accordion
        clickedAccordion.addClass("active");

        // Update tag backgrounds
        updateTagBackground();
    });

    function updateTagBackground() {
        // Use CSS classes instead of inline styles for better performance
        accordions.each(function () {
            const isActive = $(this).hasClass("active");
            $(this).find(".tag, .tag-arrow").toggleClass("inactive", !isActive);
        });
    }
};
