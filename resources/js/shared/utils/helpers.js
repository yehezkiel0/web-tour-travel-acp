/**
 * Common helper functions
 */

/**
 * Format currency
 */
export const formatCurrency = (amount, locale = "id-ID", currency = "IDR") => {
    return new Intl.NumberFormat(locale, {
        style: "currency",
        currency: currency,
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
};

/**
 * Format date
 */
export const formatDate = (date, locale = "id-ID", options = {}) => {
    const defaultOptions = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };

    return new Intl.DateTimeFormat(locale, {
        ...defaultOptions,
        ...options,
    }).format(new Date(date));
};

/**
 * Format datetime
 */
export const formatDateTime = (date, locale = "id-ID") => {
    return new Intl.DateTimeFormat(locale, {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    }).format(new Date(date));
};

/**
 * Debounce function
 */
export const debounce = (func, wait = 300) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

/**
 * Throttle function
 */
export const throttle = (func, limit = 300) => {
    let inThrottle;
    return function (...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => (inThrottle = false), limit);
        }
    };
};

/**
 * Generate slug from string
 */
export const slugify = (text) => {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-");
};

/**
 * Truncate text
 */
export const truncate = (text, length = 100, suffix = "...") => {
    if (text.length <= length) {
        return text;
    }
    return text.substring(0, length).trim() + suffix;
};

/**
 * Check if element is in viewport
 */
export const isInViewport = (element) => {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
            (window.innerWidth || document.documentElement.clientWidth)
    );
};

/**
 * Copy to clipboard
 */
export const copyToClipboard = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
        return true;
    } catch (err) {
        console.error("Failed to copy:", err);
        return false;
    }
};

/**
 * Get query parameter
 */
export const getQueryParam = (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
};

/**
 * Set query parameter
 */
export const setQueryParam = (param, value) => {
    const url = new URL(window.location);
    url.searchParams.set(param, value);
    window.history.pushState({}, "", url);
};

/**
 * Remove query parameter
 */
export const removeQueryParam = (param) => {
    const url = new URL(window.location);
    url.searchParams.delete(param);
    window.history.pushState({}, "", url);
};

/**
 * Validate email
 */
export const isValidEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
};

/**
 * Validate phone number (Indonesian format)
 */
export const isValidPhone = (phone) => {
    const re = /^(\+62|62|0)[0-9]{9,12}$/;
    return re.test(phone);
};

/**
 * Format phone number
 */
export const formatPhone = (phone) => {
    // Remove all non-digit characters
    phone = phone.replace(/\D/g, "");

    // Format based on length
    if (phone.startsWith("62")) {
        return "+" + phone;
    } else if (phone.startsWith("0")) {
        return "+62" + phone.substring(1);
    }
    return phone;
};

/**
 * Local storage helper
 */
export const storage = {
    set: (key, value) => {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error("Storage error:", e);
            return false;
        }
    },
    get: (key, defaultValue = null) => {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (e) {
            console.error("Storage error:", e);
            return defaultValue;
        }
    },
    remove: (key) => {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (e) {
            console.error("Storage error:", e);
            return false;
        }
    },
    clear: () => {
        try {
            localStorage.clear();
            return true;
        } catch (e) {
            console.error("Storage error:", e);
            return false;
        }
    },
};
