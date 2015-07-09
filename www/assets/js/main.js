$(function () {

    // Lightbox
    $('.lightbox').colorbox({
        maxWidth: 1024,
        maxHeight: 768
    });

    // TinyMCE
    if (window.tinymce) {
        tinymce.init({
            selector: "textarea.wysiwyg",
            menubar: false,
            entity_encoding: 'raw',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
        });
    }

    // Animations
    //$('.thumbnail .price').hover(function () {
    //    $(this).addClass('animated flipInY');
    //});
});
