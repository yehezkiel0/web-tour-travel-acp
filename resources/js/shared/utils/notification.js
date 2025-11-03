/**
 * Notification Helper
 * Unified notification system using iziToast
 */
export const Notification = {
    /**
     * Show success notification
     */
    success(message, title = "Success") {
        if (typeof iziToast !== "undefined") {
            iziToast.success({
                title: title,
                message: message,
                position: "topRight",
                timeout: 3000,
            });
        }
    },

    /**
     * Show error notification
     */
    error(message, title = "Error") {
        if (typeof iziToast !== "undefined") {
            iziToast.error({
                title: title,
                message: message,
                position: "topRight",
                timeout: 5000,
            });
        }
    },

    /**
     * Show warning notification
     */
    warning(message, title = "Warning") {
        if (typeof iziToast !== "undefined") {
            iziToast.warning({
                title: title,
                message: message,
                position: "topRight",
                timeout: 4000,
            });
        }
    },

    /**
     * Show info notification
     */
    info(message, title = "Info") {
        if (typeof iziToast !== "undefined") {
            iziToast.info({
                title: title,
                message: message,
                position: "topRight",
                timeout: 3000,
            });
        }
    },

    /**
     * Show loading notification
     */
    loading(message = "Loading...") {
        if (typeof iziToast !== "undefined") {
            return iziToast.show({
                message: message,
                position: "topRight",
                timeout: false,
                close: false,
                overlay: true,
                displayMode: "once",
                id: "loading",
                zindex: 99999,
            });
        }
    },

    /**
     * Hide loading notification
     */
    hideLoading() {
        if (typeof iziToast !== "undefined") {
            iziToast.hide({}, document.querySelector(".iziToast#loading"));
        }
    },

    /**
     * Show confirmation dialog
     */
    confirm(message, onConfirm, onCancel = null, title = "Confirm") {
        if (typeof iziToast !== "undefined") {
            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: "once",
                id: "question",
                zindex: 99999,
                title: title,
                message: message,
                position: "center",
                buttons: [
                    [
                        "<button><b>YES</b></button>",
                        function (instance, toast) {
                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                            if (typeof onConfirm === "function") {
                                onConfirm();
                            }
                        },
                        true,
                    ],
                    [
                        "<button>NO</button>",
                        function (instance, toast) {
                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                            if (typeof onCancel === "function") {
                                onCancel();
                            }
                        },
                    ],
                ],
            });
        }
    },
};

export default Notification;
