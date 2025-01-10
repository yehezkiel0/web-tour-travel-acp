import Swiper from "swiper/bundle";
import "swiper/swiper-bundle.css";

export function createSwiper(container, breakpoints, nextEl, prevEl) {
    return new Swiper(container, {
        slidesPerView: 1,
        spaceBetween: 10,
        lazy: true,
        navigation: {
            nextEl: nextEl,
            prevEl: prevEl,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: breakpoints,
        on: {
            slideChange: function () {
                const prevButton = document.querySelector(prevEl);
                if (prevButton) {
                    prevButton.style.display =
                        this.activeIndex === 0 ? "none" : "block";
                }
            },
        },
    });
}
