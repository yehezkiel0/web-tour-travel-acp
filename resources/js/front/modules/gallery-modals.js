export const initGallery = ($) => {
    if (!$("#gallery")) {
        return;
    }
    let photos = $("#gallery").data("photos");
    let currentIndex = 0;

    $("#openGalleryModal").on("click", function () {
        currentIndex = 1;
        $("#currentPhoto").attr("src", `/uploads/${photos[currentIndex]}`);
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
            $("#currentPhoto").attr("src", `/uploads/${photos[currentIndex]}`);
        }
    });

    $("#nextPhoto").on("click", function () {
        if (currentIndex < photos.length - 1) {
            currentIndex++;
            $("#currentPhoto").attr("src", `/uploads/${photos[currentIndex]}`);
        }
    });
};
