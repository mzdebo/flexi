<?php
//Loop file for gallery
echo "<img src='" . esc_url(flexi_image_src('thumbnail', $post)) . "'><br>";
echo get_the_title();
echo "<br>";
