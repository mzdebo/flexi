<?php
class Flexi_Admin_Dashboard_Intro
{
 public function __construct()
 {
  add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
  add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
 }

 public function add_tabs($tabs)
 {

  $extra_tabs = array("intro" => 'Flexi Intro');

  // combine the two arrays
  $new = array_merge($tabs, $extra_tabs);
  //flexi_log($new);
  return $new;
 }

 public function add_content()
 {
  if (!isset($_GET['tab'])) {
   echo $this->flexi_dashboard_content();
  }

  if (isset($_GET['tab']) && 'intro' == $_GET['tab']) {
   echo $this->flexi_dashboard_content();
  }
 }

 public function flexi_dashboard_content()
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
							<li> <a href='<?php echo flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings'); ?>' target='_blank'><div class="tooltip-container">User Dashboard<span class="tooltip"><b>Gallery submitted by current user</b><br>[flexi-user-dashboard]<br> Add it into menu bar.</span></div></a>

						<ul>
							<li><a href='<?php echo flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings'); ?>' target='_blank'><div class="tooltip-container">Edit Page<span class="tooltip"><b>Edit/Modify Page</b><br>Submission form page with edit option which let's user to modify own submitted post.</span></div></a></li>
						</ul>
						</li>
						</ul>
				</li>
				<li>
                    <a href='<?php echo flexi_get_button_url('', false, 'primary_page', 'flexi_image_layout_settings'); ?>' target='_blank'><div class="tooltip-container">Primary Gallery Page<span class="tooltip"><b>Base of Flexi Gallery</b><br>[flexi-primary]<br>Do not add additional filter parameters.<br>Permalinks refers to this page.</span></div></a>
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
				<li><a href="#"><div class="tooltip-container">Standalone Gallery<span class="tooltip">[flexi-gallery]<br>Should not be linked as 'Primary Gallery Page'</span></div></a>
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

}
$add_tabs = new Flexi_Admin_Dashboard_Intro();
