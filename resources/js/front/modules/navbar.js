export const initNavbar = ($) => {
    const $navbar = $("#navbar-home");
    const $hamburger = $(".hamburger");
    const $sidebar = $(".sidebar-home");
    const $navHome = $(".nav-home");
    const $body = $("body");
    let ticking = false;

    const setNavbarHeight = () => {
        if ($navbar.length) {
            try {
                // Check if the element exists
                const height = $navbar.outerHeight();
                document.documentElement.style.setProperty(
                    "--navbar-height",
                    `${height}px`
                );
            } catch (error) {
                console.error("Error setting navbar height:", error);
            }
        } else {
            console.error("Navbar element not found!");
        }
    };

    const handleScroll = () => {
        if (!ticking && $navbar.length) {
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
        setNavbarHeight();
    };

    // Only attach event handlers if elements exist
    if ($(".nav-menu a").length) {
        $(".nav-menu a").on("click", function (e) {
            $(".nav-menu a").removeClass("is-active");
            $(this).addClass("is-active");
            localStorage.setItem("activeMenu", $(this).attr("href"));
        });
    }

    $(document).ready(() => {
        const activeMenu = localStorage.getItem("activeMenu");
        const currentPath = window.location.pathname;

        const $menuLinks = $(".nav-menu a");
        if ($menuLinks.length) {
            if (activeMenu && activeMenu === currentPath) {
                $menuLinks.removeClass("is-active");
                $(`.nav-menu a[href="${activeMenu}"]`).addClass("is-active");
            } else {
                $menuLinks.removeClass("is-active");
            }
        }

        setNavbarHeight();
        handleScroll();
    });

    // Only add event listeners if required elements exist
    if ($navbar.length) {
        window.addEventListener("scroll", handleScroll, { passive: true });
        window.addEventListener("resize", setNavbarHeight, { passive: true });
        window.addEventListener("resize", handleResize, { passive: true });
    }

    if ($hamburger.length) {
        $hamburger.on("click", handleHamburgerClick);
    }
};
