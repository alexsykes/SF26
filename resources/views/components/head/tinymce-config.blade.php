<script src="https://cdn.tiny.cloud/1/{{config('app.TINY_CLOUD_API')}}/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists emoticons',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | emoticons code | table'
    });
</script>