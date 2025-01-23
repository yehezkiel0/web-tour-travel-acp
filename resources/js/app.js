import "./front/index";
import "./admin/index";
import "./admin/upload-handler";
import "./admin/itinerary-handle";
import "./bootstrap";
import { initializeSwipers } from "./front/swiper/index";

document.addEventListener("DOMContentLoaded", () => {
    initializeSwipers();
});
