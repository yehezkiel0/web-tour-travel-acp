export const initTinyMCE = () => {
    const checkTinyMCE = setInterval(() => {
        if (window.tinymce && document.querySelector("#textarea")) {
            clearInterval(checkTinyMCE);

            window.tinymce.init({
                selector: "#textarea",
                height: 400,
                plugins: "lists link image table code help wordcount",
                toolbar:
                    "undo redo | styles | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent | link image | code",
                menubar: false,
                branding: false,
                promotion: false,
            });
        }
    }, 100);

    setTimeout(() => clearInterval(checkTinyMCE), 5000);
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initTinyMCE);
} else {
    initTinyMCE();
}
