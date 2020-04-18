<div class="wrap about-wrap">
	<h1><?php echo __('Welcome to Flexi', 'flexi') . ' ' . FLEXI_VERSION; ?></h1>
		<div class="about-text">
		<?php echo __('Let visitors to post images from frontend with full controls.', 'flexi'); ?>
		<br><a href="https://odude.com/docs/flexi-gallery/" target="_blank">Online Documentation</a>
		<br><a href="https://odude.com/demo/flexi/" target="_blank">Live Demo</a>
		</div>
		<div class="flexi-badge-logo"></div>
<nav class="nav-tab-wrapper">
<?php
//Get the active tab from the $_GET param
$default_tab = 'intro';
$get_tab     = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

$tabs = array();
$tabs = apply_filters('flexi_dashboard_tab', $tabs);

foreach ($tabs as $key => &$val) {

 if ($key == $get_tab) {
  $active_tab = 'nav-tab-active';
 } else {
  $active_tab = '';
 }
 echo '<a href="?page=flexi&tab=' . $key . '" class="nav-tab ' . $active_tab . '">' . $val . '</a>';
}

?>
</nav>

	<div class="tab-content">

	<?php do_action('flexi_dashboard_tab_content')?>


    </div>
  </div>