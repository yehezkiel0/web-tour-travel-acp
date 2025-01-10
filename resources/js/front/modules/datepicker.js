import "bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js";
import "bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css";
export const initDatePicker = ($) => {
    const $datepicker = $("#datepicker");
    const $datepickerText = $("#datepicker-text");
    const $datepickerContainer = $("#datepicker-container");
    let $isDatePickerOpen = false;

    // Initialize datepicker
    $datepicker.datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        container: "#datepicker-container",
        orientation: "bottom",
        zIndexOffset: 1000,
    });

    $datepickerContainer.on("click", () => {
        if (!$isDatePickerOpen) {
            $datepicker.datepicker("show");
            $isDatePickerOpen = true;
        } else {
            $datepicker.datepicker("hide");
            $isDatePickerOpen = false;
        }
    });

    // Update text when date is selected
    $datepicker.on("changeDate", (e) => {
        $isDatePickerOpen = false;
    });
};
