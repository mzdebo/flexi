<?php
/*
<a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
<?php echo __('Edit Post', 'flexi'); ?>
</a>
 */
?>
<div class="pure-g">
	<div class="pure-u-1-1">
		<div class="flexi_margin-box" style='text-align: center;'>
		<?php if (get_post_status() == 'draft' || get_post_status() == "pending") {?><Small><div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div></small><?php }?>
		<?php
echo "<div class='flexi_frame_1' ><img src='" . flexi_image_src('flexi-large') . "' ></div>";
?>
<?php echo flexi_show_icon_grid(); ?>

		</div>
		<div class="pure-u-1">
				<div class="flexi_margin-box">

					<div class="flex-desp"> <?php echo wpautop(stripslashes($post->post_content)); ?></div>

				</div>
		</div>
	</div>
	<div class="pure-u-1">

		<?php flexi_list_tags($post);?>
		<hr>
<?php
function flexi_custom_field_loop($post, $page = 'detail')
{
    $group = '';
    for ($x = 1; $x <= 10; $x++) {
        $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
        $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
        $value   = get_post_meta($post->ID, 'flexi_field_' . $x, '');

        if (!$value) {
            $value[0] = '';
        }
        if (is_array($display)) {
            if (in_array($page, $display)) {
                $group .= $label . ':' . $value[0] . '<br>';
            }
        }
    }

    return $group;
}

echo flexi_custom_field_loop($post, 'detail');
?>

	</div>

</div>