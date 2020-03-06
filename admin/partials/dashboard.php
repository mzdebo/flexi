<div class="wrap about-wrap">
<h1><?php _e('Welcome to Flexi');?></h1>
<div class="about-text">
 <?php echo __('Let visitors to post images from frontend with full controls.', 'flexi'); ?>
 </div>
<?php
//Get the active tab from the $_GET param
$default_tab = null;
$tab         = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>
 <nav class="nav-tab-wrapper">
      <a href="?page=flexi" class="nav-tab <?php if (null === $tab): ?>nav-tab-active<?php endif;?>">Flexi</a>
      <a href="?page=flexi&tab=setup" class="nav-tab <?php if ('setup' === $tab): ?>nav-tab-active<?php endif;?>">Shortcode</a>
      <a href="?page=flexi&tab=pro" class="nav-tab <?php if ('pro' === $tab): ?>nav-tab-active<?php endif;?>">Flexi Pro</a>
    </nav>

	<div class="tab-content">
    <?php switch ($tab):
case 'setup':
 echo flexi_dashboard_pages();
 break;
case 'pro':
 echo flexi_dashboard_pro();
 break;
default:
 echo flexi_dashboard_tree();
 break;
 endswitch;?>
    </div>
  </div>

<?php
function flexi_dashboard_tree()
{
   ob_start();
   ?>
   <h3>Below is the flow chart as Flexi works</h3>

 <div class="flexi_tree" style="text-align: right;">
	<ul>
		<li>
          <a href='<?php echo flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings'); ?>' target='_blank'><div class="tooltip-container">Submission Form<span class="tooltip"><b>Let's user to submit</b><br>[flexi-form]<br> Add it into menu bar</span></div></a>
			<ul>
				<li>
                    <a href='<?php echo flexi_get_button_url('', false, 'my_login', 'flexi_general_settings'); ?>' target='_blank'><div class="tooltip-container">Login Page<span class="tooltip"><b>Member Login Page</b><br>Where user enters username & password<br> Use it only if you want members to manage submitted post or want only member to submit.</span></div></a>
					<ul>
							<li> <a href='<?php echo flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings'); ?>' target='_blank'><div class="tooltip-container">My Gallery<span class="tooltip"><b>Gallery submitted by current user</b><br>[flexi-gallery user="show_mine"]<br> Add it into menu bar.</span></div></a>

						<ul>
							<li><a href='<?php echo flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings'); ?>' target='_blank'><div class="tooltip-container">Edit Page<span class="tooltip"><b>Edit/Modify Page</b><br>Submission form page with edit option which let's user to modify own submitted post.</span></div></a></li>
						</ul>
						</li>
						</ul>
				</li>
				<li>
                    <a href='<?php echo flexi_get_button_url('', false, 'main_page', 'flexi_image_layout_settings'); ?>' target='_blank'><div class="tooltip-container">Main Gallery Page<span class="tooltip"><b>Base of Flexi Gallery</b><br>[flexi-gallery]<br>Do not add additional filter parameters.<br>Permalinks refers to this page.</span></div></a>
					<ul>
						<li><a href="#"><div class="tooltip-container">Filters by URL<span class="tooltip"><b>Filters by URL Parameter</b><br>Search Keyword, Album, Username, Tags</span></div></a>
							<ul>
							<li>
							<a href="#"><div class="tooltip-container">Detail page<span class="tooltip"><b>Auto generated page</b><br>No shortcode required<br>2 types of detail page as below</span></div></a>
										<ul>
										<li><div class="tooltip-container"><a href="#">Single Page</a><span class="tooltip"><b>Full Detail Page</b><br>Visible directly when lightbox is turned off or view icon is clicked.  </span></div></li>
										<li><div class="tooltip-container"><a href="#">Lightbox Popup</a><span class="tooltip"><b>Popup Modal Preview</b><br>Popup quick visible without any page redirection.</span></div></li>

										</ul>
							</li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="#"><div class="tooltip-container">Standalone Gallery<span class="tooltip">[flexi-gallery]<br> Not linked as 'Main Gallery Page'</span></div></a>
					<ul>
						<li><div class="tooltip-container"><a href="#">Gallery By User</a><span class="tooltip"><b>Gallery by User</b><br>[flexi-gallery user="user_name"]</span></div></li>
						<li><div class="tooltip-container"><a href="#">Gallery By Album</a><span class="tooltip"><b>Gallery by Category</b><br>[flexi-gallery album="category_slug"]</span></div></li>
						<li><div class="tooltip-container"><a href="#">Gallery By Tag</a><span class="tooltip"><b>Gallery by Tags</b><br>[flexi-gallery tag="tag_slug"]</span></div></li>
					</ul>
				</li>
			</ul>
		</li>

	</ul>
</div>
<?php
$content = ob_get_clean();
   return $content;
 }

 function flexi_dashboard_pages()
{
  ob_start();
  ?>

<h3>Primary shortcode reference</h3>
<b><i>Below pages are automatically generated. No need to create again if already exists.</i></b><br><br>

<?php
echo "<a href='" . flexi_get_button_url('', false, 'main_page', 'flexi_image_layout_settings') . "' target='_blank'>Main Gallery Page:</a><br>"
  ?>
Page should contain <code>[flexi-gallery]</code> shortcode. Main page cannot be WordPress's front or homepage.<br><br>




<?php
echo "<a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' target='_blank'>Submission form Page:</a><br>"
  ?>
Page should contain <code>[flexi-form]</code> shortcode enclosed with <code>[flexi-form-tag]</code>. Add this page into menu.
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


<?php
echo "<a href='" . flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings') . "' target='_blank'>My Gallery Page:</a><br>"
  ?>
Page should contain <code>[flexi-gallery user="show_mine"]</code> shortcode. Add this page into menu. <br><br>

<?php
echo "<a href='" . flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings') . "' target='_blank'>Edit Page:</a><br>"
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

<h3>Documentation under development</h3>
<?php
$content = ob_get_clean();
  return $content;
 }

 function flexi_dashboard_pro()
{
  ob_start();
  ?>
  <h3>Flexi Pro</h3>
<b>Flexi Version: </b> <?php echo FLEXI_VERSION; ?> (Beta Version)<br>
<b>Flexi PRO status:</b> <?php if (is_flexi_pro()) {echo "Enabled";} else {echo "Disabled";}?>

<h4>Flexi-PRO is not available. Till June 2020, you can use UPG-PRO</h4>
For any suggestion and issues mail at navneet@odude.com
<?php
$content = ob_get_clean();
  return $content;
 }
 ?>

<hr>
<div style='clear:both;'></div>

<hr>

</div>