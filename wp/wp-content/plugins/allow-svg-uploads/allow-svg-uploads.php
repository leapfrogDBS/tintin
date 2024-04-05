<?php
/*
Plugin Name: Allow SVG Uploads
Description: Adds SVG file type support to WordPress uploads.
Version: 1.0
Author: Greenwich Design
*/

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');
?>