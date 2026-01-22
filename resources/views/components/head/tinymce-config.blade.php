<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE

        license_key: 'gpl',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | image media table | align lineheight | link numlist bullist indent outdent | emoticons charmap | removeformat',
        link_assume_external_targets: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        mobile: {
            menubar: true
        },
    });
</script>