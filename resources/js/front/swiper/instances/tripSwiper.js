import { createSwiper } from "../../utils/swiperFactory";
import { tripBreakpoints } from "../config/breakpoints";

export function initializeTripSwiper() {
    return createSwiper(
        ".swiper-open-trip",
        tripBreakpoints,
        ".swiper-open-trip-button-next",
        ".swiper-open-trip-button-prev"
    );
}
