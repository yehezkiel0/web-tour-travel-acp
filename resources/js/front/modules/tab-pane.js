export const initTabPane = ($) => {
    $(".tab-btn").click(function () {
        const tab = $(this).data("tab");

        $(".tab-btn")
            .removeClass("active border-black")
            .addClass("border-transparent");
        $(this)
            .addClass("active border-black")
            .removeClass("border-transparent");

        $(".tab-pane").addClass("hidden");
        $(`#${tab}`).removeClass("hidden");
    });
};
