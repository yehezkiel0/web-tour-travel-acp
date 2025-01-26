export const initTabPane = ($) => {
    $(".tab-btn").click(function () {
        const tab = $(this).data("tab");

        $(".tab-pane").hide();

        $(`#${tab}`).show();
    });

    const toggleText = $("#toggleText");
    const toggleButtonText = $("#toggleButtonText");

    toggleButtonText.click(function () {
        if (toggleText.hasClass("line-clamp-3")) {
            toggleText.removeClass("line-clamp-3");
            $(this).find("span").text("View Less");
            $(this).find("i").addClass("rotate-180");
        } else {
            toggleText.addClass("line-clamp-3");
            $(this).find("span").text("View More");
            $(this).find("i").removeClass("rotate-180");
        }
    });

    function toggleTab(tabId) {
        $(".tab-btn")
            .removeClass("is-active")
            .filter(`[data-tab="${tabId}"]`)
            .addClass("is-active");
    }

    $(document).ready(function () {
        $(".tab-btn").click(function () {
            toggleTab($(this).data("tab"));
        });

        toggleTab("overview");
    });
};
