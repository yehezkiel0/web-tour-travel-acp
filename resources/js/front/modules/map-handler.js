/**
 * Google Maps Error Handler
 * Handle CSP errors and provide fallback
 */

// Suppress Google Maps CSP test errors in console
const originalConsoleError = console.error;
console.error = function (...args) {
    // Filter out Google Maps internal CSP test errors
    const errorString = args.join(" ");
    if (
        errorString.includes("gen_204?csp_test=true") ||
        errorString.includes("ERR_BLOCKED_BY_CLIENT")
    ) {
        // Silently ignore these expected errors
        return;
    }
    originalConsoleError.apply(console, args);
};

export const initMapErrorHandler = () => {
    // Wait for DOM to be ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", handleMapErrors);
    } else {
        handleMapErrors();
    }
};

function handleMapErrors() {
    const mapContainer = document.querySelector(".location-map");

    if (!mapContainer) return;

    const iframe = mapContainer.querySelector("iframe");

    if (!iframe) return;

    // Handle iframe load error
    iframe.addEventListener("error", function (e) {
        console.warn("Google Maps iframe failed to load:", e);
        showMapFallback(mapContainer);
    });

    // Check for CSP errors after load
    iframe.addEventListener("load", function () {
        // Remove loading animation
        mapContainer.classList.add("loaded");

        // Cross-origin access is expected and normal for Google Maps iframes
        // We don't need to check iframe content as CSP blocking is browser's security feature
        // The map will either load successfully or the error event will fire
    });

    // Add responsive attributes to iframe
    iframe.setAttribute("loading", "lazy");
    iframe.setAttribute("allowfullscreen", "");
    iframe.setAttribute("referrerpolicy", "no-referrer-when-downgrade");
}

function showMapFallback(container) {
    const iframe = container.querySelector("iframe");
    const mapUrl = iframe ? iframe.getAttribute("src") : "";

    // Create fallback content
    const fallback = document.createElement("div");
    fallback.className =
        "absolute inset-0 flex flex-col items-center justify-center bg-gray-50 text-gray-600 p-6 text-center";
    fallback.innerHTML = `
        <i class="fa-solid fa-map-location-dot text-5xl mb-4 text-primary"></i>
        <h3 class="text-lg font-semibold mb-2">Map Temporarily Unavailable</h3>
        <p class="text-sm mb-4">The map couldn't be loaded. This might be due to:</p>
        <ul class="text-xs text-left mb-4 space-y-1">
            <li>• Ad blocker or browser extension blocking Google Maps</li>
            <li>• Network connection issues</li>
            <li>• Browser privacy settings</li>
        </ul>
        ${
            mapUrl
                ? `
            <a href="${mapUrl}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-400 transition-colors">
                <i class="fa-solid fa-external-link-alt"></i>
                <span>Open in Google Maps</span>
            </a>
        `
                : ""
        }
    `;

    // Hide iframe and show fallback
    if (iframe) {
        iframe.style.display = "none";
    }
    container.appendChild(fallback);
}

// Auto-initialize
initMapErrorHandler();
