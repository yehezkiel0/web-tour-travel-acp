import { createSwiper } from "../../utils/swiperFactory";
import { commonBreakpoints } from "../config/breakpoints";

export function initializeMainSwiper() {
    const swiper = createSwiper(
        ".swiper-container",
        commonBreakpoints,
        ".swiper-button-next",
        ".swiper-button-prev"
    );

    const prevButton = document.querySelector(".swiper-button-prev");
    if (prevButton) {
        prevButton.style.display = swiper.activeIndex === 0 ? "none" : "block";
    }

    return swiper;
}
