<?php
$detail_layout = flexi_get_option('detail_layout', 'flexi_detail_settings', 'basic');
require FLEXI_PLUGIN_DIR . 'public/partials/layout/detail/' . $detail_layout . '/single.php';
