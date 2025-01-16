import { createSwiper } from "../../utils/swiperFactory";
import { servicesBreakpoints } from "../config/breakpoints";

export function initializeServicesSwiper() {
    return createSwiper(
        ".swiper-services",
        servicesBreakpoints,
        ".swiper-service-button-next",
        ".swiper-service-button-prev",
        true
    );
}
