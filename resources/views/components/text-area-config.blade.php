{{-- TinyMCE is now loaded via Vite/JS bundle --}}
{{-- Configuration is in resources/js/admin/tinymce-config.js --}}
<script>
    // Additional custom configuration can be added here if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for TinyMCE to be available
        const checkTinyMCE = setInterval(function() {
            if (typeof tinymce !== 'undefined') {
                clearInterval(checkTinyMCE);
                console.log('TinyMCE is ready');
            }
        }, 100);
    });
</script>
