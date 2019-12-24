<div class="flexi_masonry-item" data-tags="">
    <?php
    echo '<a href="'.flexi_image_link('medium', $post).'" data-caption="' . get_the_title() . '" border="0"><img src="' . esc_url(flexi_image_src('medium', $post)) . '"  class="flexi_masonry-content"></a>';
    ?>
</div>