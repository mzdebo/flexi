<div class="wrap about-wrap">
<h1><?php _e('Welcome to Flexi');?></h1>
<div class="about-text">
 <?php _e('Let visitors to post images from frontend with full controls.');?>
 </div>
<hr>
<h3>Configuration based on settings</h3>
<b>Flexi Main Page</b>:
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'main_page', 'flexi_image_layout_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-gallery]</code> shortcode and it cannot be WordPress's front or homepage.<br><br>
<b>My Gallery Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-gallery user="show_mine"]</code> shortcode <br><br>
<b>Submission form Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-form]</code> shortcode enclosed with <code>[flexi-form-tag]</code><br><br>
<b>Edit Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-form edit="true"]</code> shortcode enclosed with <code>[flexi-form-tag edit="true"]</code>


<hr>
<b>Flexi Version: </b> <?php echo FLEXI_VERSION; ?> (Beta Version)<br>
<b>Flexi PRO:</b> <?php if (is_flexi_pro()) {echo "Enabled";} else {echo "Disabled";}?>

<h4>Flexi-PRO is not available. Till June 2020, you can use UPG-PRO</h4>
For any suggestion and issues mail at navneet@odude.com
</div>