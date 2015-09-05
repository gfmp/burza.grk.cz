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

    // Google Events
    $('a[data-ga]').on('click', function (e) {
        var event = $(this).data('ga-event');
        var category = $(this).data('ga-category');
        var action = $(this).data('ga-action');
        ga('send', 'event', event, category, action);
    });
});
