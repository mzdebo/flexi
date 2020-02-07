<?php
/*
<a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
<?php echo __('Edit Post', 'flexi'); ?>
</a>
 */
?>
<div class="pure-g">
	<div class="pure-u-1-1">

		<div class="flexi_margin-box" style='text-align: right;'>
		<?php
echo "<div class='flexi_frame_1' style='text-align: center;'><img src='" . flexi_image_src('flexi-large') . "' ></div>";
?>
<?php echo flexi_show_icon_grid(); ?>
		</div>
		<div class="pure-u-1">
				<div class="flexi_margin-box">

					<div class="flex-desp"> <?php echo $post->post_content; ?></div>

				</div>
		</div>
	</div>
	<div class="pure-u-1">

		<?php flexi_list_tags($post);?>

	</div>

</div>