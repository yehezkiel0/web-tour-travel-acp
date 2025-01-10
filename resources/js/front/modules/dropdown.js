export const initDropdown = ($) => {
    const setupDropdown = (triggerSelector, dropdownSelector) => {
        $(triggerSelector).on("click", function (e) {
            e.preventDefault();
            $(this).next(dropdownSelector).stop(true, true).slideToggle(300);
        });

        $(document).on("click", function (e) {
            if (!$(e.target).closest(triggerSelector).length) {
                $(dropdownSelector).slideUp(300);
            }
        });
    };
    setupDropdown('[data-dropdown="travel"]', "#dropdown-travel");
    setupDropdown('[data-dropdown="services"]', "#dropdown-services");
    setupDropdown('[data-dropdown="profile-user"]', "#dropdown-user-profile");
};
