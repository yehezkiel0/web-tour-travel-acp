import { initializePopularDestinationSwiper } from "./instances/popularDestinationSwiper";
import { initializeTripSwiper } from "./instances/tripSwiper";
import { initializeServicesSwiper } from "./instances/servicesSwiper";
import { initializeAboutUsSwiper } from "./instances/aboutUsSwiper";

export function initializeSwipers() {
    const popularDestinationSwiper = initializePopularDestinationSwiper();
    const tripSwiper = initializeTripSwiper();
    const serviceSwiper = initializeServicesSwiper();
    const aboutUsSwiper = initializeAboutUsSwiper();

    return {
        popularDestinationSwiper,
        tripSwiper,
        serviceSwiper,
        aboutUsSwiper,
    };
}
