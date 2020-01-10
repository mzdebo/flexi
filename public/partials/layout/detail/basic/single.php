<?php
echo "<img src='" . flexi_image_src('flexi-large') . "' >";
echo "<br>am liking it";
?>
 <a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
                <?php echo __('Edit Post', 'flexi'); ?>
            </a> |
