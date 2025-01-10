import { initializeMainSwiper } from "./instances/mainSwiper";
import { initializeTripSwiper } from "./instances/tripSwiper";

export function initializeSwipers() {
    const mainSwiper = initializeMainSwiper();
    const tripSwiper = initializeTripSwiper();

    return {
        mainSwiper,
        tripSwiper,
    };
}
