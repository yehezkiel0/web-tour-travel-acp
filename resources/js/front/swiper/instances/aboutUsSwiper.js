import { createSwiper } from "../../utils/swiperFactory";
import { aboutBreakpoints } from "../config/breakpoints";

export function initializeAboutUsSwiper() {
    const swiper = createSwiper(
        ".swiper-about-us",
        aboutBreakpoints,
        ".swiper-button-next",
        ".swiper-button-prev"
    );

    const prevButton = document.querySelector(".swiper-button-prev");
    if (prevButton) {
        prevButton.style.display = swiper.activeIndex === 0 ? "none" : "block";
    }

    return swiper;
}
