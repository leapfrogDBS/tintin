<section>
    <?php
        $map_access_token = get_field('access_token');
        $map_zoom_level = get_field('zoom_level');
        $map_style = get_field('map_style');
        $map_center_coordinates = get_field('center_coordinates');
    ?>

    <section id="contact-map" class="p-0">
        <div id="map" class="w-full h-[580px]"></div>
    </section>

    <script>
        window.onload = function() {
            mapboxgl.accessToken = '<?php echo esc_js($map_access_token); ?>';
            const map = new mapboxgl.Map({
                container: 'map', 
                style: '<?php echo esc_js($map_style); ?>',
                center: [<?php echo esc_js($map_center_coordinates); ?>], 
                zoom: <?php echo esc_js($map_zoom_level); ?>, 
            });
            map.scrollZoom.disable();
            map.addControl(new mapboxgl.NavigationControl())
        }
    </script>
</section>
