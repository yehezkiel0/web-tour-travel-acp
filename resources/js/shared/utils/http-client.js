/**
 * HTTP Client for API requests
 * Handles all API communication with proper headers and error handling
 */
class HttpClient {
    constructor(baseURL = "") {
        this.baseURL = baseURL;
        this.headers = {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        };

        // Get CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            this.headers["X-CSRF-TOKEN"] = token.content;
        }
    }

    /**
     * Make HTTP request
     */
    async request(url, options = {}) {
        const config = {
            ...options,
            headers: {
                ...this.headers,
                ...options.headers,
            },
        };

        try {
            const response = await fetch(this.baseURL + url, config);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Request failed");
            }

            return data;
        } catch (error) {
            console.error("HTTP Error:", error);
            throw error;
        }
    }

    /**
     * GET request
     */
    async get(url, options = {}) {
        return this.request(url, { ...options, method: "GET" });
    }

    /**
     * POST request
     */
    async post(url, body, options = {}) {
        return this.request(url, {
            ...options,
            method: "POST",
            body: JSON.stringify(body),
        });
    }

    /**
     * PUT request
     */
    async put(url, body, options = {}) {
        return this.request(url, {
            ...options,
            method: "PUT",
            body: JSON.stringify(body),
        });
    }

    /**
     * DELETE request
     */
    async delete(url, options = {}) {
        return this.request(url, { ...options, method: "DELETE" });
    }

    /**
     * Upload file(s)
     */
    async upload(url, formData, options = {}) {
        // Remove Content-Type header to let browser set it with boundary
        const headers = { ...this.headers };
        delete headers["Content-Type"];

        return this.request(url, {
            ...options,
            method: "POST",
            headers,
            body: formData,
        });
    }
}

// Create instance with API base URL
const apiClient = new HttpClient("/api");

// Export for use in other modules
export default apiClient;
