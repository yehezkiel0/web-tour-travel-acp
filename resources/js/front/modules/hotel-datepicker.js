// Hotel Search Datepicker Handler
document.addEventListener("DOMContentLoaded", function () {
    initDatePickers();
});

function initDatePickers() {
    const dayNames = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];

    const checkInInput = document.getElementById("checkInDate");
    const checkOutInput = document.getElementById("checkOutDate");

    if (!checkInInput || !checkOutInput) return;

    // Initialize Flatpickr for check-in
    const checkInPicker = flatpickr("#checkInDate", {
        minDate: "today",
        dateFormat: "d M Y",
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const dayName = dayNames[selectedDates[0].getDay()];
                const dateInput = document.getElementById("checkInDate");
                dateInput.value = dateStr;

                const dayDisplay = dateInput.nextElementSibling;
                if (dayDisplay) {
                    dayDisplay.textContent = dayName;
                }

                // Update check-out min date
                if (checkOutPicker) {
                    checkOutPicker.set("minDate", selectedDates[0]);
                }
            }
        },
    });

    // Initialize Flatpickr for check-out
    const checkOutPicker = flatpickr("#checkOutDate", {
        minDate: "today",
        dateFormat: "d M Y",
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const dayName = dayNames[selectedDates[0].getDay()];
                const dateInput = document.getElementById("checkOutDate");
                dateInput.value = dateStr;

                const dayDisplay = dateInput.nextElementSibling;
                if (dayDisplay) {
                    dayDisplay.textContent = dayName;
                }
            }
        },
    });
}

// Export if needed
if (typeof module !== "undefined" && module.exports) {
    module.exports = {
        initDatePickers,
    };
}
