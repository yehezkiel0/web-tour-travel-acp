import $ from "jquery";
import { debounce } from "./utils/eventUtils";
import { initDropdown } from "./modules/dropdown";
import { initNavbar } from "./modules/navbar";
import { initAuth } from "./modules/auth";
import { initAccordion } from "./modules/accordion";
import { initInfiniteScroll } from "./modules/scroll";
import { initDatePicker } from "./modules/datepicker";
import { initSearchResult } from "./modules/search-result";
import { initTabPane } from "./modules/tab-pane";
import { initGallery } from "./modules/gallery-modals";

// Wait for DOM to be ready
$(() => {
    debounce(() => {}, 1000);
    initDropdown($);
    initNavbar($);
    initAuth($);
    initAccordion($);
    initInfiniteScroll();
    initDatePicker($);
    initSearchResult($);
    initTabPane($);
    initGallery($);
});
