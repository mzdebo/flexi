<?php
class Flexi_Shortcode_Form
{

 /**
  * Display & process form submission with help of shortcode [flexi-form] & [flexi-form-tag]
  *
  * @since  1.0.0
  */

 public function __construct()
 {

  //Shortcode [flexi-form] to display form
  add_shortcode('flexi-form', array($this, 'render_form'));
  //Shortcode [flexi-tag] to render to tags
  add_shortcode('flexi-form-tag', array($this, 'render_tags'));
//Add icon after form submitted
  add_filter("flexi_submit_toolbar", array($this, 'flexi_add_icon_submit_toolbar'), 10, 3);
 }

 public function render_form($params, $content = null)
 {
  $attr = flexi_default_args($params);
  $abc  = "";
  ob_start();

  $check_enable_form = flexi_get_option('enable_form', 'flexi_form_settings', 'everyone');

  $enable_form_access = true;

  if ('everyone' == $check_enable_form) {
   $enable_form_access = true;
  } else if ('member' == $check_enable_form) {
   if (!is_user_logged_in()) {
    $enable_form_access = false;
    flexi_login_link();
   }
  } else {
   $enable_form_access = false;
   echo "<div class='flexi_alert-box flexi_notice'>" . __('Submission disabled', 'flexi') . "</div>";
  }

  $edit_post = true;
  if (isset($_REQUEST["id"])) {
   $edit_post = flexi_check_rights($_REQUEST["id"]);
  }

  //Check if current page is EDIT page and not having post_id
  $current_page_id = get_the_ID();
  $edit_page_id    = flexi_get_option('edit_flexi_page', 'flexi_form_settings', 0);
  if ($current_page_id == $edit_page_id) {
   if (!isset($_REQUEST["id"])) {
    $edit_post = false;
   }
  }

  //Prevent form update if not UPG pro
  if ($current_page_id == $edit_page_id) {
   if (!is_flexi_pro()) {
    $edit_post = false;
    echo flexi_pro_required();
   }
  }

  //Prevent from modification if wrong wrong edit page & unauthorized access
  if (false == $edit_post) {
   echo "<div class='flexi_alert-box flexi_warning'>" . __('No permission to modify or update', 'flexi') . "</div>";

  }

  if ($enable_form_access && $edit_post) {
   if (isset($_POST['flexi-nonce']) && wp_verify_nonce($_POST['flexi-nonce'], 'flexi-nonce')) {
    //Check if edit form has parameter edit=true as input hidden field
    if ("false" == $_POST['edit']) {
     $this->process_new_forms($attr);
    } else {
     $this->process_update_forms($attr);
    }

   } else {

    if ('false' == $attr['ajax']) {

     echo '<form class="' . $attr['class'] . '" method="post" enctype="multipart/form-data" action="">';

    } else {

     ?>

    <div id="flexi_ajax">

        <!-- Image loader -->
        <div id='flexi_loader' style='display: none;'>

            <br>
            <?php echo __("Uploading", "flexi"); ?>
            <div class="flexi_progress-bar">
                <span id="flexi_progress" class="flexi_progress-bar-load" style="width: 0%;text-align: center;"></span>
            </div>
            <br>
            <?php echo __("Processing", "flexi"); ?>
            <div class="flexi_progress-bar">
                <span id="flexi_progress_process" class="flexi_progress-bar-process"
                    style="width: 0%;text-align: center;"></span>
            </div>

        </div>

        <div class='flexi_response'></div>
        <div id="flexi_after_response" style='display: none;'>

            <?php echo flexi_post_toolbar_grid(get_the_ID(), true); ?>

        </div>

    </div>

<?php
echo '<div id="flexi_form">
<form
id="flexi-request-form"
class="flexi_ajax_post ' . $attr['class'] . '"
method="post"
enctype="multipart/form-data"
action="' . admin_url("admin-ajax.php") . '"
>';
    }

    echo do_shortcode($content);

    wp_nonce_field('flexi-nonce', 'flexi-nonce', false);

    echo '<input type="hidden" name="action" value="flexi_ajax_post">';
    echo '<input type="hidden" name="preview" value="' . $attr['preview'] . '">';
    echo '<input type="hidden" name="form_name" value="' . $attr['name'] . '">';
    echo '<input type="hidden" name="media_private" value="' . $attr['media_private'] . '">';
    echo '<input type="hidden" name="edit" value="' . $attr['edit'] . '">';
    if (isset($_GET['id'])) {
     echo '<input type="hidden" name="flexi_id" value="' . $_GET['id'] . '">';
    }

    echo '<input type="hidden" name="upload_type" value="flexi">';

    echo '</form>';

   }
  }
  $abc = ob_get_clean();
  if (is_singular()) {
   return $abc;
  } else {
   return '';
  }
 }

 //Examine & save the form submitted
 public function process_new_forms($attr)
 {
  $title    = '';
  $author   = '';
  $url      = '';
  $email    = '';
  $tags     = '';
  $verify   = '';
  $content  = '';
  $category = '';

  //var_dump($attr);

  $files = array();
  if (isset($_FILES['user-submitted-image'])) {
   $files = $_FILES['user-submitted-image'];
  }

  $preview  = $attr['preview'];
  $title    = $attr['user-submitted-title'];
  $content  = $attr['content'];
  $category = $attr['category'];
  $tags     = $attr['tags'];

  //$result = array();
  $result = flexi_submit($title, $files, $content, $category, $preview, $tags);
  //flexi_log($title . '-' . $content . '-' . $category . '-' . $preview . '-' . $tags);
  //var_dump($result);

  $post_id = false;
  if (isset($result['id'])) {
   $post_id = $result['id'];
  }

  $error = false;
  if (isset($result['error'])) {
   $error = array_filter(array_unique($result['error']));
  }

  if ($post_id) {
   //Submit extra fields data
   for ($x = 1; $x <= 10; $x++) {
    if (isset($_POST['flexi_field_' . $x])) {
     add_post_meta($post_id, 'flexi_field_' . $x, $_POST['flexi_field_' . $x]);
    }

   }
   //Ended to submit extra fields

   $post = get_post($post_id);

   do_action("flexi_submit_complete");

   if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {

    echo "<div class='flexi_alert-box flexi_success'>" . __('Successfully posted', 'flexi') . "</div>";

   } else {
    echo "<div class='flexi_alert-box flexi_warning'>" . __('Your submission is under review.', 'flexi') . "</div>";
   }

  } else {

   $reindex_array = array_values(array_filter($error));
   //var_dump($reindex_array);

   for ($x = 0; $x < count($reindex_array); $x++) {
    //echo $reindex_array[$x] . "-";
    echo flexi_error_code($reindex_array[$x]);
   }

  }
  ?>
   <div id="flexi_form">

       <?php echo flexi_post_toolbar_grid(get_the_ID(), false); ?>
</div>

<?php
}

 //Examine & update the old form submitted
 public function process_update_forms($attr)
 {
  $title    = '';
  $author   = '';
  $url      = '';
  $email    = '';
  $tags     = '';
  $verify   = '';
  $content  = '';
  $category = '';
  if (isset($_POST['flexi_id'])) {
   $post_id = $_POST['flexi_id'];
  }

  //var_dump($attr);

  $files = array();
  if (isset($_FILES['user-submitted-image'])) {
   $files = $_FILES['user-submitted-image'];
  }

  $preview  = $attr['preview'];
  $title    = $attr['user-submitted-title'];
  $content  = $attr['content'];
  $category = $attr['category'];
  $tags     = $attr['tags'];

  $result = flexi_update_post($post_id, $title, $files, $content, $category, $tags);

  if ($result) {
   do_action("flexi_submit_complete");

   if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {

    echo "<div class='flexi_alert-box flexi_success'>" . __('Successfully posted', 'flexi') . "</div>";

   } else {
    echo "<div class='flexi_alert-box flexi_warning'>" . __('Your submission is under review.', 'flexi') . "</div>";
   }
  } else {
   echo "FAIL";
  }
  ?>
   <a href='<?php echo flexi_get_button_url($post_id, false, 'edit_flexi_page', 'flexi_form_settings'); ?>' class='button'>
                <?php echo __('Edit again', 'flexi'); ?>
            </a> |
 <a href='<?php echo flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings'); ?>' class='button'>
                <?php echo __('My Dashboard', 'flexi'); ?>
            </a>
  <?php

 }

 public function render_tags($params)
 {
  $attr = shortcode_atts(array(
   'type'           => 'text',
   'new_type'       => 'number',
   'class'          => '',
   'title'          => '',
   'name'           => '',
   'id'             => '',
   'placeholder'    => '',
   'value'          => '',
   'edit'           => '',
   'required'       => '',
   'editor'         => '',
   'type'           => '',
   'rows'           => '4',
   'cols'           => '40',
   'checked'        => '',
   'disabled'       => '',
   'readonly'       => '',
   'formnovalidate' => '',
   'novalidate'     => '',
   'taxonomy'       => 'flexi_category',
   'tag_taxonomy'   => 'flexi_tag',
   'filter'         => '',
   'multiple'       => '',

  ), $params);
  $frm = new flexi_HTML_Form(false); // pass false for html rather than xhtml syntax
  $abc = "";
  ob_start();
  if ('post_title' == $attr['type']) {
   echo $frm->addLabelFor("user-submitted-title", $attr['title']);
   // arguments: type, name, value
   if ('' == $attr['edit']) {
    echo $frm->addInput('text', "user-submitted-title", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   } else {
    echo $frm->addInput('text', "user-submitted-title", flexi_get_detail($_GET['id'], 'post_title'), array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   }

  } else if ('video_url' == $attr['type']) {
   echo $frm->addLabelFor("user-submitted-url", $attr['title']);
   // arguments: type, name, value
   echo $frm->addInput('url', "user-submitted-url", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

  } else if ('category' == $attr['type']) {
   echo $frm->addLabelFor('cat', $attr['title']);
   if ('' == $attr['edit']) {
    echo flexi_droplist_album();
   } else {
    $old_category_id = flexi_get_album($_GET['id'], 'term_id');
    echo flexi_droplist_album('flexi_category', $old_category_id);
   }

  } else if ('tag' == $attr['type']) {
   echo $frm->addLabelFor("tags", $attr['title']);
   // arguments: type, name, value
   if ('' == $attr['edit']) {
    echo $frm->addInput('', "tags", $attr['value'], array('id' => 'tags', 'placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   } else {
    echo $frm->addInput('', "tags", flexi_get_taxonomy_raw($_GET['id'], 'flexi_tag'), array('id' => 'tags', 'placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   }
   echo " <script>
          jQuery(document).ready(function ()
          {

              jQuery('#tags').tagsInput();
          });
          </script>";

  } else if ('captcha' == $attr['type']) {

   do_action("flexi_captcha");

  } else if ('file' == $attr['type']) {
   echo $frm->addLabelFor('user-submitted-image[]', $attr['title']);
   echo $frm->addInput('file', "user-submitted-image[]", '', array('id' => 'file', 'class' => $attr['class'], 'accept' => 'image/*', 'required' => $attr['required']));

  } else if ('file_multiple' == $attr['type']) {
   if (is_flexi_pro()) {
    echo $frm->startTag('div', array('class' => $attr['class']));
    echo $frm->addInput('file', "user-submitted-image[]", '', array('id' => 'file', 'class' => $attr['class'] . '_hide', 'accept' => 'image/*', 'required' => $attr['required'], 'multiple' => $attr['multiple']));
    echo "<p>" . $attr['title'] . "</p>";
    echo $frm->endTag('div');
    echo '
      <script>
      jQuery(document).ready(function()
      {
          jQuery("form input").change(function ()
          {
              if(this.files && this.files.length)
              {
                  jQuery("form p").text(this.files.length + " file(s) selected");
              }

          });
        });
      </script>
      ';

   } else {
    echo "<br>Multiple upload is only available in FLEXI-PRO<br>";
   }

  } else if ('article' == $attr['type']) {
   echo $frm->addLabelFor('user-submitted-content', $attr['title']);

   // arguments: name, rows, cols, value, optional assoc. array
   if ('' == $attr['edit']) {
    echo $frm->addTextArea(
     'user-submitted-content',
     $attr['rows'],
     $attr['cols'],
     '',
     array('id' => $attr['id'], 'placeholder' => $attr['placeholder'], 'required' => $attr['required'])
    );
   } else {
    echo $frm->addTextArea(
     'user-submitted-content',
     $attr['rows'],
     $attr['cols'],
     flexi_get_detail($_GET['id'], 'post_content'),
     array('id' => $attr['id'], 'placeholder' => $attr['placeholder'], 'required' => $attr['required'])
    );
   }

  } else if ('text' == $attr['type']) {
   if ('' == $attr['edit']) {
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   } else {
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], flexi_custom_field_value($_GET['id'], $attr['name']), array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

   }
  } else if ('other' == $attr['type']) {
   if ('' == $attr['edit']) {
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput($attr['new_type'], $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   } else {
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput($attr['new_type'], $attr['name'], flexi_custom_field_value($_GET['id'], $attr['name']), array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

   }
  } else if ('submit' == $attr['type']) {
   //submit

   echo $frm->addInput('submit', $attr['name'], $attr['value'], array('class' => $attr['class']));

  } else if ('radio' == $attr['type'] || 'checkbox' == $attr['type']) {

   $values = explode(',', $attr['value']);
   echo $frm->addLabelFor($attr['name'], $attr['title']);
   foreach ($values as $option) {
    $val     = explode(":", $option);
    $caption = isset($val[1]) ? $val[1] : $val[0];

    if ("radio" == $attr['type']) {
     echo $frm->addInput('radio', $attr['name'], $val[0], array('required' => $attr['required'])) . ' ' . $caption . ' ';
    }

    if ("checkbox" == $attr['type']) {
     echo $frm->addInput('checkbox', $val[0], $caption, array('required' => $attr['required'])) . ' ' . $caption . ' ';
    }

   }

  } else if ('select' == $attr['type']) {
   $val   = array();
   $label = array();

   $values = explode(',', $attr['value']);
   foreach ($values as $option) {
    $cap = explode(":", $option);
    array_push($val, $cap[0]);
    array_push($label, $cap[1]);
   }
   //var_dump($values);
   //var_dump($val);
   //var_dump($label);

   /** addSelectListArrays arguments:
    *   name, array containing option values, array containing option text,
    *   optional: selected option's value, header, additional attributes in associative array
    */
   echo $frm->addLabelFor($attr['name'], $attr['title']);
   if ('' == $attr['placeholder']) {
    echo $frm->addSelectListArrays($attr['name'], $val, $label, '');
   } else {
    echo $frm->addSelectListArrays($attr['name'], $val, $label, '', ' - ' . $attr['placeholder'] . ' - ', array('required' => $attr['required']));
   }

  } else if ('textarea' == $attr['type']) {
   echo $frm->addLabelFor($attr['name'], $attr['title']);
   // arguments: name, rows, cols, value, optional assoc. array
   echo $frm->addTextArea(
    $attr['name'],
    $attr['rows'],
    $attr['cols'],
    '',
    array('id' => $attr['id'], 'placeholder' => $attr['placeholder'])
   );
  } else {
   echo "Invalid Form tag";
  }

  $abc = ob_get_clean();
  if (is_singular()) {
   return $abc;
  } else {
   return '';
  }
 }

 //Adds edit icon in flexi icon container.
 public function flexi_add_icon_grid_edit($icon)
 {
  global $post;
  $edit_flexi_icon = flexi_get_option('edit_flexi_icon', 'flexi_icon_settings', 1);
  // $nonce = wp_create_nonce("flexi_ajax_edit");
  $link = flexi_get_button_url($post->ID, false, 'edit_flexi_page', 'flexi_form_settings');

  $extra_icon = array();

  if (get_the_author_meta('ID') == get_current_user_id()) {
   // if (isset($options['show_trash_icon'])) {
   if ("1" == $edit_flexi_icon) {
    $extra_icon = array(
     array("dashicons-edit", __('Modify', 'flexi'), $link, '', $post->ID),

    );
   }
   // }
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

 //Add post again button after form submit
 public function flexi_add_icon_submit_toolbar($icon, $id = '', $bool)
 {

  $extra_icon = array();
  if ($bool) {
   $link  = flexi_get_button_url($id, true);
   $class = 'flexi_send_again';
  } else {
   $link  = flexi_get_button_url('', false);
   $class = '';
  }

  if ("#" != $link) {
   $extra_icon = array(
    array("save", __('Post again', 'flexi'), $link, $id, $class),

   );
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

}
