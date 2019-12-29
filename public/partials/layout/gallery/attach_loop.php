<?php
    //If classic page navigation selected
    if($navigation=='pagenavi')
		{
            //Attach loop gallery based based on layout selection
            require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/masonry/loop.php';
        }
        else
        {
            //WP_QUERY & loop is executed at includes\flexi_load_more.php
        }
		
?>