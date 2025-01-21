export const initNavbar = ($) => {
    const $navbar = $("#navbar-home");
    const $hamburger = $(".hamburger");
    const $sidebar = $(".sidebar-home");
    const $navHome = $(".nav-home");
    const $body = $("body");
    let ticking = false;

    const setNavbarHeight = () => {
        const height = $navbar.outerHeight();
        document.documentElement.style.setProperty(
            "--navbar-height",
            `${height}px`
        );
    };

    const handleScroll = () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const currentScroll = window.scrollY;
                const shouldFix = currentScroll > 0;
                $navbar.toggleClass("navbar-fixed", shouldFix);
                ticking = false;
            });
            ticking = true;
        }
    };

    const handleHamburgerClick = (e) => {
        e.preventDefault();
        $hamburger.toggleClass("is-active");

        const isActive = $hamburger.hasClass("is-active");
        $sidebar
            .toggleClass("active", isActive)
            .toggleClass("hidden", !isActive);
        $navHome.toggleClass("sidebar-fixed", isActive);
        $body.toggleClass("body-lock", isActive);
    };

    const handleResize = () => {
        if (window.innerWidth > 1280) {
            $hamburger.removeClass("is-active");
            $sidebar.removeClass("active").addClass("hidden");
            $navHome.removeClass("sidebar-fixed");
            $body.removeClass("body-lock");
        }
    };

    $(".nav-menu a").on("click", function (e) {
        $(".nav-menu a").removeClass("is-active");
        $(this).addClass("is-active");
        localStorage.setItem("activeMenu", $(this).attr("href"));
    });

    $(document).ready(() => {
        const activeMenu = localStorage.getItem("activeMenu");
        if (activeMenu) {
            $(".nav-menu a").removeClass("is-active");
            $(`.nav-menu a[href="${activeMenu}"]`).addClass("is-active");
        }

        setNavbarHeight();
        handleScroll();
    });

    window.addEventListener("scroll", handleScroll, { passive: true });
    window.addEventListener("resize", setNavbarHeight, { passive: true });
    window.addEventListener("resize", handleResize, { passive: true });
    $hamburger.on("click", handleHamburgerClick);
};
