<?php
//[flexi-gallery] shortcode
class Flexi_Public_Gallery
{
    public function __construct()
    {

        add_shortcode('flexi-gallery', array($this, 'flexi_gallery'));
    }


    public function flexi_gallery()
    {
        global $post;
        global $wp_query;
        $args = array(
            'post_type' => 'flexi',
            'order'   => 'DESC',
        );
        if (!empty($args)) {
            //wp_reset_query();
            $query = new WP_Query($args);
            $count = 0;
            $put = "";
            ob_start();
            require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/attach_header.php';
            while ($query->have_posts()) : $query->the_post();
                require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/attach_loop.php';
                $count++;
            endwhile;
            require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/attach_footer.php';
            $put = ob_get_clean();
            wp_reset_query();
            return $put;
        }
    }
}
