import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
export const initBookingForm = ($) => {
    const dateInput = flatpickr(".date-input", {
        dateFormat: "d/m/Y",
        defaultDate: "today",
    });

    $(".calender-icon").click(function () {
        dateInput.open();
    });

    const formatIDR = (price) => {
        if (!price) return "";
        return `IDR ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
    };

    const $totalPrice = $("#total-price").data("total-price");
    const $increaseAdult = $(".increase-adult");
    const $decreaseAdult = $(".decrease-adult");
    const $increaseChild = $(".increase-child");
    const $decreaseChild = $(".decrease-child");
    const $adultCount = $("#adult-count");
    const $childCount = $("#child-count");

    let currentVal;
    $("#total-price").text(formatIDR($totalPrice));

    function updatePrice() {
        const adultPrice = parseInt($adultCount.val());
        const childPrice = parseInt($childCount.val());

        const total = adultPrice * $totalPrice + (childPrice * $totalPrice) / 2;

        const formatPrice = formatIDR(total);
        $("#total-price").text(formatPrice);
    }

    $increaseAdult.click(function () {
        currentVal = parseInt($adultCount.val());
        $adultCount.val(currentVal + 1);
        updatePrice();
    });

    $decreaseAdult.click(function () {
        currentVal = parseInt($adultCount.val());
        if (currentVal > 1) {
            $adultCount.val(currentVal - 1);
            updatePrice();
        }
    });

    $increaseChild.click(function () {
        currentVal = parseInt($childCount.val());
        $childCount.val(currentVal + 1);
        updatePrice();
    });

    $decreaseChild.click(function () {
        currentVal = parseInt($childCount.val());
        if (currentVal > 0) {
            $childCount.val(currentVal - 1);
            updatePrice();
        }
    });
};
