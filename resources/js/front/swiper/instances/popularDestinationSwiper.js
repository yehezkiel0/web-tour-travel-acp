import { createSwiper } from "../../utils/swiperFactory";
import { commonBreakpoints } from "../config/breakpoints";

export function initializePopularDestinationSwiper() {
    const swiper = createSwiper(
        ".swiper-popular-destination",
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
