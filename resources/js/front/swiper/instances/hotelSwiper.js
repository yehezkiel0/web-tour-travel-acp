import { createSwiper } from "../../utils/swiperFactory";
import { commonBreakpoints } from "../config/breakpoints";

export function initializeHotelSwiper() {
    return createSwiper(".swiper-hotel-list", commonBreakpoints, null, null);
}
