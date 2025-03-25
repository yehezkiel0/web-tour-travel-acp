import { createSwiper } from "../../utils/swiperFactory";
import { aboutBreakpoints } from "../config/breakpoints";

export function initializeAboutUsSwiper() {
    const swiper = createSwiper(
        ".swiper-about-us",
        aboutBreakpoints,
        ".swiper-button-next",
        ".swiper-button-prev",
        false,
        {
            delay: 3000, // Delay antara slide (ms)
            pauseOnMouseEnter: true, // Jeda saat hover
            disableOnInteraction: false, // Tetap aktif setelah interaksi pengguna
        },
        true
    );

    const prevButton = document.querySelector(".swiper-button-prev");
    if (prevButton) {
        prevButton.style.display = swiper.activeIndex === 0 ? "none" : "block";
    }

    return swiper;
}
