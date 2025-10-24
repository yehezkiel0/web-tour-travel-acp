import $ from "jquery";

// Lazy load TinyMCE only when textarea exists
if (document.querySelector("#textarea")) {
    import("./tinymce-config");
}

window.$ = window.jQuery = $;
$(function () {
    $("#sidebar a").on("click", function (e) {
        $("#sidebar a").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest("#sidebar").length) {
            $("#sidebar a").removeClass("active");
        }
    });

    $('[data-dropdown="items"]').on("click", function (e) {
        e.preventDefault();
        $(this).next("#dropdown-items").slideToggle(300);
    });

    $('[data-dropdown="admin"]').on("click", function (e) {
        e.preventDefault();
        $("#dropdown-profile").slideToggle(300);
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest("[data-dropdown]").length) {
            $("#dropdown-items").slideUp(300);
            $("#dropdown-profile").slideUp(300);
        }
    });

    $("#toggle-sidebar").on("click", function () {
        $("#sidebar").toggleClass("sidebar-hidden");
        $("#navbar-admin").toggleClass("navbar-slide");
        $(".content-wrapper").toggleClass("collapsed");
    });

    if ($(window).width() <= 1024) {
        $("#sidebar").addClass("sidebar-hidden");
        $(".content-wrapper").addClass("collapsed");
        $("#navbar-admin").addClass("navbar-slide");
        $("#toggle-sidebar").addClass("click disabled");
    }

    $(window).on("resize", function () {
        if ($(window).width() <= 1024) {
            $("#sidebar").addClass("sidebar-hidden");
            $(".content-wrapper").addClass("collapsed");
            $("#navbar-admin").addClass("navbar-slide");
            $("#toggle-sidebar").addClass("click disabled");
        } else {
            $("#sidebar").removeClass("sidebar-hidden");
            $(".content-wrapper").removeClass("collapsed");
            $("#toggle-sidebar").removeClass("click disabled");
            $("#navbar-admin").removeClass("navbar-slide");
        }
    });
});
