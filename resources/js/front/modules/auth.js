export const initAuth = ($) => {
    const $passwordToggles = $(".show-password");
    const $registerTab = $("#overlay-btn-register");
    const $loginTab = $("#overlay-btn-login");
    const $containerSlide = $(".container-slide");

    // Password visibility toggle
    $passwordToggles.on("click", function () {
        const $passwordInput = $(this).prev();
        const type =
            $passwordInput.attr("type") === "password" ? "text" : "password";
        $passwordInput.attr("type", type);
        $(this).toggleClass("fa-eye");
    });

    // Auth panel switching
    const initAuthPanel = () => {
        const activeTab = localStorage.getItem("activeTab");
        $containerSlide.toggleClass(
            "right-panel-active",
            activeTab === "register"
        );
    };

    $registerTab.on("click", () => {
        $containerSlide.addClass("right-panel-active");
        localStorage.setItem("activeTab", "register");
    });

    $loginTab.on("click", () => {
        $containerSlide.removeClass("right-panel-active");
        localStorage.removeItem("activeTab");
    });

    initAuthPanel();
};
