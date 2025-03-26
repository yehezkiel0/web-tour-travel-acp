export const initGallery = ($) => {
    const $gallery = $("#gallery");
    if (!$gallery.length) {
        return;
    }

    const photos = $gallery.data("photos");
    if (!photos || photos.length === 0) {
        console.warn("No photos found in gallery");
        return;
    }

    let currentIndex = 0;

    $("#openGalleryModal").on("click", function () {
        currentIndex = 1;
        $("#currentPhoto").attr(
            "src",
            window.location.origin + "/storage/" + photos[currentIndex]
        );
        $("#galleryModal").removeClass("hidden");
        $("#galleryModal").addClass("flex");
    });

    $("#closeGalleryModal").on("click", function () {
        $("#galleryModal").addClass("hidden");
        $("#galleryModal").removeClass("flex");
    });

    $("#prevPhoto").on("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            $("#currentPhoto").attr(
                "src",
                window.location.origin + "/storage/" + photos[currentIndex]
            );
        }
    });

    $("#nextPhoto").on("click", function () {
        if (currentIndex < photos.length - 1) {
            currentIndex++;
            $("#currentPhoto").attr(
                "src",
                window.location.origin + "/storage/" + photos[currentIndex]
            );
        }
    });
};
