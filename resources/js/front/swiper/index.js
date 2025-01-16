import { initializePopularDestinationSwiper } from "./instances/popularDestinationSwiper";
import { initializeTripSwiper } from "./instances/tripSwiper";
import { initializeServicesSwiper } from "./instances/servicesSwiper";

export function initializeSwipers() {
    const popularDestinationSwiper = initializePopularDestinationSwiper();
    const tripSwiper = initializeTripSwiper();
    const serviceSwiper = initializeServicesSwiper();

    return {
        popularDestinationSwiper,
        tripSwiper,
        serviceSwiper,
    };
}
