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
Page should contain <code>[flexi-gallery]</code> shortcode. Main page cannot be WordPress's front or homepage.<br><br>



<b>Submission form Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-form]</code> shortcode enclosed with <code>[flexi-form-tag]</code>. Add into your menu.
<div id="sample_post_form" style="display:none;">
     <p>
     [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
		[flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]<br>
		[flexi-form-tag type="category" title="Select category" taxonomy="flexi_cate" filter="image"]<br>
		[flexi-form-tag type="tag" title="Insert tag"]<br>
		[flexi-form-tag type="article" title="Description"  placeholder="Content"]<br>
		[flexi-form-tag type="file" title="Select file"]<br>
		[flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
		[/flexi-form]<br>
     </p>
</div>

<a href="#TB_inline?width=600&height=200&inlineId=sample_post_form" title="Sample Code for Post Form" class="thickbox">View dummy content!</a>
<br><br>



<b>My Gallery Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-gallery user="show_mine"]</code> shortcode. Add into your menu. <br><br>



<b>Edit Page:</b>
<?php
echo "<code><a href='" . flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings') . "' target='_blank'>View Page</a></code><br>"
?>
Page should contain <code>[flexi-form edit="true"]</code> shortcode enclosed with <code>[flexi-form-tag edit="true"]</code>
<div id="sample_edit_form" style="display:none;">
     <p>
    [flexi-form class="pure-form pure-form-stacked" title="Update Flexi" name="my_form" ajax="true" edit="true"]<br>
    [flexi-form-tag type="post_title" title="Title" placeholder="main title" edit="true" ]<br>
    [flexi-form-tag type="category" title="Select category" edit="true"]<br>
    [flexi-form-tag type="tag" title="Insert tag" edit="true"]<br>
    [flexi-form-tag type="article" title="Description" placeholder="Content" edit="true"]<br>
    [flexi-form-tag type="submit" name="submit" value="Update Now"]<br>
    [/flexi-form]<br>
     </p>
</div>

<a href="#TB_inline?width=600&height=200&inlineId=sample_edit_form" title="Sample Code for Edit Form" class="thickbox">View dummy content!</a>
<hr>
<b>Flexi Version: </b> <?php echo FLEXI_VERSION; ?> (Beta Version)<br>
<b>Flexi PRO:</b> <?php if (is_flexi_pro()) {echo "Enabled";} else {echo "Disabled";}?>

<h4>Flexi-PRO is not available. Till June 2020, you can use UPG-PRO</h4>
For any suggestion and issues mail at navneet@odude.com
</div>