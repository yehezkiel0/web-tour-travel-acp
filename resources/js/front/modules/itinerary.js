export const initItinerary = ($) => {
    // 1. Share Link Functionality
    const $shareBtn = $("#share-btn");

    if ($shareBtn.length) {
        $shareBtn.on("click", function () {
            const url = $(this).data("share-url");
            const $btnText = $(this).find("#share-btn-text");
            const originalText = $btnText.text();

            if (!url) {
                console.error("Share URL not found");
                return;
            }

            if (navigator.clipboard) {
                navigator.clipboard
                    .writeText(url)
                    .then(() => {
                        $btnText.text("Copied!");
                        setTimeout(() => {
                            $btnText.text(originalText);
                        }, 2000);
                    })
                    .catch((err) => {
                        console.error("Failed to copy: ", err);
                        alert(
                            "Failed to copy link. Please copy it manually: " +
                                url
                        );
                    });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand("copy");
                    $btnText.text("Copied!");
                    setTimeout(() => {
                        $btnText.text(originalText);
                    }, 2000);
                } catch (err) {
                    console.error("Fallback: Oops, unable to copy", err);
                    alert(
                        "Failed to copy link. Please copy it manually: " + url
                    );
                }
                document.body.removeChild(textArea);
            }
        });
    }

    // 2. Remove Item Functionality
    $(document).on("click", ".btn-remove-item", function () {
        const itemId = $(this).data("id");

        if (!confirm("Remove this destination from itinerary?")) return;

        // Visual feedback immediately? Or wait for server?
        // Let's disable the button to prevent double clicks
        $(this).prop("disabled", true);

        $.ajax({
            url: `/itinerary/remove-item/${itemId}`,
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json",
            },
            success: (data) => {
                if (data.status === "success") {
                    window.location.reload();
                } else {
                    alert("Failed to remove item");
                    $(this).prop("disabled", false);
                }
            },
            error: (err) => {
                console.error("Error removing item:", err);
                alert("An error occurred while removing the item.");
                $(this).prop("disabled", false);
            },
        });
    });
};
