<?php
$data = flexi_image_data('medium', $post);
?>

<li class="flexi_list_cards__item flexi_gallery_child" id="flexi_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
	<div class="flexi_list_card">

	<?php

echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"><div class="flexi_list_card__image" style="background-image: url(' . esc_url(flexi_image_src('flexi-thumb', $post)) . ');"></div></a>';

?>

		<div class="flexi_list_card__content">
			<div class="flexi_list_card__title"><?php echo $data['title']; ?></div>

		</div>
	</div>
</li>