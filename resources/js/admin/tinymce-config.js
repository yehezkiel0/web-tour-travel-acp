import tinymce from "tinymce/tinymce";

// Import theme
import "tinymce/themes/silver";

// Import models
import "tinymce/models/dom";

// Import icons
import "tinymce/icons/default";

// Import plugins
import "tinymce/plugins/lists";
import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/table";
import "tinymce/plugins/code";
import "tinymce/plugins/help";
import "tinymce/plugins/wordcount";

export const initTinyMCE = () => {
    // Check if textarea exists
    if (document.querySelector("#textarea")) {
        tinymce.init({
            selector: "#textarea",
            height: 300,
            skin_url: "/tinymce/skins/ui/oxide",
            content_css: "/tinymce/skins/content/default/content.min.css",
            plugins: "lists link image table code help wordcount",
            toolbar:
                "undo redo | styles | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent | link image | code",
            menubar: false,
            branding: false,
            promotion: false,
            license_key: "gpl",
            setup: function (editor) {
                editor.on("init", function () {
                    console.log("TinyMCE initialized successfully");
                });
            },
        });
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initTinyMCE);
} else {
    initTinyMCE();
}
