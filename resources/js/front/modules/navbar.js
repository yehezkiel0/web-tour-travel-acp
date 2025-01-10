export const initNavbar = ($) => {
    const $navbar = $("#navbar-home");
    const $hamburger = $(".hamburger");
    const $sidebar = $(".sidebar-home");
    const $navHome = $(".nav-home");
    const $body = $("body");
    let lastScrollTop = 0;
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

                lastScrollTop = currentScroll;
                ticking = false;
            });

            ticking = true;
        }
    };
    setNavbarHeight();
    handleScroll();

    window.addEventListener("scroll", handleScroll, { passive: true });
    window.addEventListener("resize", setNavbarHeight, { passive: true });

    const handleHamburgerClick = (e) => {
        e.preventDefault();
        $hamburger.toggleClass("is-active");

        const isActive = $hamburger.hasClass("is-active");
        $sidebar.toggleClass("active", isActive).toggleClass("hide", !isActive);
        $navHome.toggleClass("sidebar-fixed", isActive);
        $body.toggleClass("body-lock", isActive);
    };

    const handleResize = () => {
        if (window.innerWidth > 1024) {
            $hamburger.removeClass("is-active");
            $sidebar.removeClass("active").addClass("hidden");
            $navHome.removeClass("sidebar-fixed");
            $body.removeClass("body-lock");
        }
    };

    window.addEventListener("scroll", handleScroll, { passive: true });
    $hamburger.on("click", handleHamburgerClick);
    window.addEventListener("resize", handleResize, { passive: true });
};
