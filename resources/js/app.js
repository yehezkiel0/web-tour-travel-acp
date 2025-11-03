/**
 * Main Application Entry Point
 * Load order is critical: bootstrap (jQuery, Axios) must load before modules
 */

// Import CSS first
import "../css/app.css";

// 1. Load bootstrap first (sets up jQuery and Axios globally)
import "./bootstrap";

// 2. Import front and admin modules (these depend on jQuery being available)
import "./front/index";
import "./admin/index";
import "./admin/upload-handler";
import "./admin/itinerary-handle";

// 3. Import Swiper initialization
import { initializeSwipers } from "./front/swiper/index";

// 4. Initialize after DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    initializeSwipers();
});
