import $ from "jquery";
$(function () {
    const dropZone = $("#image_input").parent();
    const progressContainer = $("#progress-container");
    const progressBar = $("#progress-bar");
    const progressText = $("#progress-text");
    const previewContainer = $("#preview-container");
    const previewImage = $("#preview-image");
    const fileInfo = $("#file-info");
    const removeButton = $("#remove-image");
    const fileInput = $("#image_input");

    // Prevent default drag behaviors
    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        dropZone.on(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Highlight drop zone when dragging over it
    dropZone.on("dragenter dragover", function () {
        $(this).addClass("border-blue-500 bg-blue-50");
    });

    dropZone.on("dragleave drop", function () {
        $(this).removeClass("border-blue-500 bg-blue-50");
    });

    // Handle dropped files
    dropZone.on("drop", function (e) {
        const file = e.originalEvent.dataTransfer.files[0];
        handleFile(file);
    });

    // Handle file input change
    fileInput.on("change", function () {
        const file = this.files[0];
        handleFile(file);
    });

    // Remove image
    removeButton.on("click", function () {
        fileInput.val("");
        previewContainer.addClass("hidden");
        dropZone.removeClass("hidden");
        progressContainer.addClass("hidden");
    });

    function handleFile(file) {
        if (!file) return;

        // Validate file type
        const validTypes = [
            "image/jpeg",
            "image/png",
            "image/gif",
            "image/svg+xml",
        ];
        if (!validTypes.includes(file.type)) {
            alert("Please upload an image file (SVG, PNG, JPG or GIF)");
            return;
        }

        // Validate file size (4MB)
        if (file.size > 4 * 1024 * 1024) {
            alert("File size must be less than 4MB");
            return;
        }

        // Show progress bar
        progressContainer.removeClass("hidden");
        dropZone.addClass("hidden");

        // Simulate upload progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressBar.css("width", `${progress}%`);
            progressText.text(`${progress}%`);

            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    progressContainer.addClass("hidden");
                    showPreview(file);
                }, 500);
            }
        }, 100);
    }

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.attr("src", e.target.result);
            previewContainer.removeClass("hidden");

            // Show file info
            const fileSize = (file.size / 1024).toFixed(2);
            fileInfo.text(`${file.name} (${fileSize} KB)`);
        };
        reader.readAsDataURL(file);
    }
});
