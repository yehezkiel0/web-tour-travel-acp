{{-- TinyMCE Configuration Component --}}
{{-- Only load TinyMCE on pages that need it --}}
@once
    <script src="https://cdn.tiny.cloud/1/rvzuxw8ad6nq8y34fv4yof385m5nyzf1sqs4z6baybpxffmk/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for TinyMCE to be available
            const checkTinyMCE = setInterval(function() {
                if (typeof tinymce !== 'undefined') {
                    clearInterval(checkTinyMCE);

                    // Initialize all textareas with ID containing 'textarea'
                    tinymce.init({
                        selector: 'textarea[id*="textarea"]',
                        height: 300,
                        menubar: false,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                            'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'help', 'wordcount'
                        ],
                        toolbar: 'undo redo | blocks | ' +
                            'bold italic forecolor | alignleft aligncenter ' +
                            'alignright alignjustify | bullist numlist outdent indent | ' +
                            'removeformat | help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                    });

                    console.log('TinyMCE initialized');
                }
            }, 100);
        });
    </script>
@endonce
