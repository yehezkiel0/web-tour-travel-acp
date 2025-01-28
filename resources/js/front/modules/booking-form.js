import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
export const initBookingForm = ($) => {
    const dateInput = flatpickr(".date-input", {
        dateFormat: "Y-m-d",
        defaultDate: "today",
    });

    $(".calender-icon").click(function () {
        dateInput.open();
    });
};
