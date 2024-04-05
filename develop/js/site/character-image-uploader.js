jQuery(document).ready(function($) {
    function open_media_uploader_image() {
        var media_uploader = wp.media({
            frame: "post",
            state: "insert",
            multiple: false
        });

        media_uploader.on("insert", function() {
            var json = media_uploader.state().get("selection").first().toJSON();
            var image_url = json.url;
            $('.character-image-field').val(image_url);
            $('#character-image-preview').html('<img src="' + image_url + '" style="max-width:100px;height:auto;">');
        });

        media_uploader.open();
    }

    $('.character-image-upload').click(function(e) {
        e.preventDefault();
        open_media_uploader_image();
    });
});
