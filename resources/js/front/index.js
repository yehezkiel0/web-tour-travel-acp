// jQuery is already available globally from bootstrap.js
import { debounce } from "./utils/eventUtils";
import { initDropdown } from "./modules/dropdown";
import { initNavbar } from "./modules/navbar";
import { initAuth } from "./modules/auth";
import { initAccordion } from "./modules/accordion";
import { initDatePicker } from "./modules/datepicker";
import { initSearchResult } from "./modules/search-result";
import { initTabPane } from "./modules/tab-pane";
import { initGallery } from "./modules/gallery-modals";
import { initBookingForm } from "./modules/booking-form";
import { initStepper } from "./modules/stepper";
import { initBookingDetail } from "./modules/booking-detail";
import { initVideoPlayer } from "./modules/video-player";
import { initMapErrorHandler } from "./modules/map-handler";

// Wait for DOM to be ready - jQuery ($) is available globally
$(() => {
    debounce(() => {}, 1000);
    initDropdown($);
    initNavbar($);
    initAuth($);
    initAccordion($);
    initDatePicker($);
    initSearchResult($);
    initTabPane($);
    initGallery($);
    initBookingForm($);
    initStepper($);
    initBookingDetail($);
    initVideoPlayer($);
    initMapErrorHandler();
});
