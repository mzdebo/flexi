<?php
class Flexi_Admin_Dashboard_Pro
{
 public function __construct()
 {
  add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
  add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
 }

 public function add_tabs($tabs)
 {

  $extra_tabs = array("pro" => 'Flexi Pro');

  // combine the two arrays
  $new = array_merge($tabs, $extra_tabs);
  //flexi_log($new);
  return $new;
 }

 public function add_content()
 {

  if (isset($_GET['tab']) && 'pro' == $_GET['tab']) {
   echo $this->flexi_dashboard_content();
  }
 }

 public function flexi_dashboard_content()
 {
  ob_start();
  if (isset($_POST['flexi_license'])) {
   flexi_process_license($_POST['flexi_license']);
  }
  ?>
<H1><?php echo get_option('FLEXI_PRO', 'FAIL'); ?></H1>
FLC3-D3-DB-D1XI
<div class="update-nag">

<form method="post">
<b>Enter license key: </b>
<input type="text" name="flexi_license" class="regular-text" value="<?php echo get_option('FLEXI_PRO_LICENSE', ''); ?>">
<input type="submit" value="Activate" class="button-primary">
</form>
</div>

<h3>Flexi Pro</h3>
<b>Flexi Version: </b> <?php echo FLEXI_VERSION; ?><br>
<b>Flexi PRO status:</b> <?php if (is_flexi_pro()) {echo "Enabled";} else {echo "Disabled";}?>

<h3>Features of Flexi PRO</h3>
<ul>
<li>Google reCaptcha (Security code during form submission) <a href="#TB_inline?width=600&height=200&inlineId=reCaptcha" title="Form with Google reCaptcha Option" class="thickbox">View dummy code</a></li>
<li>Bulk image upload (drag and drop multiple file) <a href="#TB_inline?width=600&height=200&inlineId=drag" title="Drag & Drop multiple files" class="thickbox">View dummy code</a></li>
<li>Let users to modify own submitted post (Edit Button)  <a href="#TB_inline?width=600&height=200&inlineId=modify" title="Edit page content" class="thickbox">View dummy code</a></li>
</ul>


<div id="reCaptcha" style="display:none;">
     <p>
   [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
	 [flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]<br>
		[flexi-form-tag type="file" title="Select file"]<br>
    <code>[flexi-form-tag type="captcha" title="Security"]</code><br>
    [flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
		[/flexi-form]<br>
     </p>
</div>

<div id="drag" style="display:none;">
     <p>
   [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
	 [flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]<br>
    <code>[flexi-form-tag type="file_multiple" title="Drag &amp; Drop multiple files" class="flexi_drag_file" multiple="true"]</code><br>
    [flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
		[/flexi-form]<br>
     </p>
</div>

<div id="modify" style="display:none;">
     <p>
     <b>Add edit="true" as parameter</b><br><br>
[flexi-form class="xxx_class" title="Update Flexi" name="my_form" ajax="true" edit="true"]<br>
[flexi-form-tag type="post_title" title="Title" placeholder="main title" edit="true" ]<br>
[flexi-form-tag type="category" title="Select category" edit="true"]<br>
[flexi-form-tag type="tag" title="Insert tag" edit="true"]<br>
[flexi-form-tag type="article" title="Description" placeholder="Content" edit="true"]<br>
[flexi-form-tag type="submit" name="submit" value="Update Now"]<br>
[/flexi-form]<br>
     </p>
</div>

<h4>Flexi-PRO is not available. Till June 2020, you can use UPG-PRO</h4>
For any suggestion and issues mail at navneet@odude.com
<?php
$content = ob_get_clean();
  return $content;
 }

}
$add_tabs = new Flexi_Admin_Dashboard_Pro();
