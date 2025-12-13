import { initializePopularDestinationSwiper } from "./instances/popularDestinationSwiper";
import { initializeTripSwiper } from "./instances/tripSwiper";
import { initializeServicesSwiper } from "./instances/servicesSwiper";
import { initializeAboutUsSwiper } from "./instances/aboutUsSwiper";
import { initializeHotelSwiper } from "./instances/hotelSwiper";

export function initializeSwipers() {
    const popularDestinationSwiper = initializePopularDestinationSwiper();
    const tripSwiper = initializeTripSwiper();
    const serviceSwiper = initializeServicesSwiper();
    const aboutUsSwiper = initializeAboutUsSwiper();
    const hotelSwiper = initializeHotelSwiper();

    return {
        popularDestinationSwiper,
        tripSwiper,
        serviceSwiper,
        aboutUsSwiper,
        hotelSwiper,
    };
}
