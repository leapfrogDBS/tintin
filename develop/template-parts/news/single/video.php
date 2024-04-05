<section>
    <div class="container">
    <?php
        // Retrieve custom field values
        $youtube_url = get_sub_field('video_url');
        $line_one = get_sub_field('line_one');
        $line_two = get_sub_field('line_two');

        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $youtube_url, $matches);
        $video_id = $matches[0] ?? '';

        // List of thumbnail resolutions to try, in order of preference
        $thumbnail_resolutions = ['maxresdefault.jpg', 'hqdefault.jpg', 'mqdefault.jpg', 'sddefault.jpg', 'default.jpg'];

        $thumbnail_url = '';
        foreach ($thumbnail_resolutions as $resolution) {
            $test_url = 'https://img.youtube.com/vi/' . $video_id . '/' . $resolution;
            if (thumbnail_exists($test_url)) {
                $thumbnail_url = $test_url;
                break;
            }
        }

        // Fallback if no thumbnail is available
        if (empty($thumbnail_url)) {
            $thumbnail_url = get_template_directory_uri() . '/assets/img/default-thumbnail.jpg'; // Replace with your default thumbnail path
        }

        echo '<div class="youtube-thumbnail-wrapper relative cursor-pointer w-full" data-videoid="' . esc_attr($video_id) . '">
                <img src="' . esc_url($thumbnail_url) . '" alt="YouTube Video Thumbnail" class="w-full h-auto yt-thumbnail">
                <div class="play-icon absolute top-1/2 left-0 transform  -translate-y-1/2 z-40 flex flex-col items-center w-full">
                    '. file_get_contents(locate_template('assets/img/video/play-button.svg')) .'
                    <h3 class="heading-three text-white mt-6">' . esc_html($line_one) . '</h3>
                    <h3 class="heading-three text-white">' . esc_html($line_two) . '</h3>
                </div>
                <div class="absolute inset-0 bg-shop-front-blue opacity-80 z-30 mix-blend-normal">            
                </div>
            </div>';

        function thumbnail_exists($url) {
            $headers = get_headers($url);
            return strpos($headers[0], '200 OK') ? true : false;
        }
    ?>
    </div>
</section>
