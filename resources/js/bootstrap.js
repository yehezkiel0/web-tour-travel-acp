/**
 * Bootstrap - Setup global dependencies
 */

// Import and setup jQuery globally
import $ from "jquery";
window.$ = window.jQuery = $;

// Import and setup Axios
import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
