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
 }

 public function render_form($params, $content = null)
 {

  $attr = shortcode_atts(array(
   'class'         => 'pure-form pure-form-stacked',
   'title'         => 'Submit',
   'preview'       => 'default',
   'name'          => '',
   'id'            => get_the_ID(),
   'taxonomy'      => 'flexi_category',
   'tag_taxonomy'  => 'flexi_tag',
   'ajax'          => 'true',
   'media_private' => 'false',
  ), $params);

  $abc = "";
  ob_start();

  if (isset($_POST['flexi-nonce']) && wp_verify_nonce($_POST['flexi-nonce'], 'flexi-nonce')) {

   $this->process_forms($attr);

  } else {

   ?>

    <?php
if ('false' == $attr['ajax']) {
    echo '<form class="' . $attr['class'] . '" method="post" enctype="multipart/form-data" action="">';
   } else {
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
   echo '<input type="hidden" name="form_attach" value="' . $attr['id'] . '">';

   echo '</form></div>';

   $abc = ob_get_clean();
   return $abc;
  }

 }

 //Examine & save the form submitted
 public function process_forms($attr)
 {
  $title    = '';
  $author   = '';
  $url      = '';
  $email    = '';
  $tags     = '';
  $captcha  = '';
  $verify   = '';
  $content  = '';
  $category = '';

  $files = array();
  if (isset($_FILES['user-submitted-image'])) {
   $files = $_FILES['user-submitted-image'];
  }

  $preview = $attr['preview'];

  $title = sanitize_text_field($_POST['user-submitted-title']);
  if (isset($_POST['user-submitted-content'])) {
   $content = flexi_sanitize_content($_POST['user-submitted-content']);
  }

  if (isset($_POST['cat'])) {
   $category = intval($_POST['cat']);
  }

  if (isset($_POST['tags'])) {
   $tags = $_POST['tags'];
  }

  $content = str_replace("[", "[[", $content);
  $content = str_replace("]", "]]", $content);

  //$result = array();
  $result = flexi_submit($title, $files, $content, $category, $preview, 'flexi', 'flexi_category', $tags, 'flexi_tag');
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

    echo "<h2>" . __('Successfully posted.', 'flexi') . "</h2>";

    if (flexi_get_option('my_gallery', 'flexi_image_layout_settings', '0') != '0') {
     echo "<br><a href='" . esc_url(get_page_link(flexi_get_option('my_gallery', 'flexi_image_layout_settings', '0'))) . "' class=\"pure-button\">" . __('My Gallery', 'flexi') . "</a><br><br>";
    }
   } else {
    echo "<h2>" . __('Your submission is under review.', 'flexi') . "</h2>";
   }

  } else {

   if ($error) {
    $e = implode(',', $error);
    $e = trim($e, ',');
   } else {
    $e = 'error';
   }

   if ('file-type' == $e) {
    echo "<h1>" . __('Invalid file', 'flexi') . "</h1>";
   } else {
    echo "<h1>" . __('Error occurred', 'flexi') . "</h1>";
   }
  }
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
   echo $frm->addInput('text', "user-submitted-title", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

  } else if ('video_url' == $attr['type']) {
   echo $frm->addLabelFor("user-submitted-url", $attr['title']);
   // arguments: type, name, value
   echo $frm->addInput('url', "user-submitted-url", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

  } else if ('category' == $attr['type']) {
   echo $frm->addLabelFor('cat', $attr['title']);
   echo flexi_droplist_album();

  } else if ('tag' == $attr['type']) {
   echo $frm->addLabelFor("tags", $attr['title']);
   // arguments: type, name, value
   echo $frm->addInput('', "tags", $attr['value'], array('id' => 'tags', 'placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
   echo " <script>
          jQuery(document).ready(function ()
          {

              jQuery('#tags').tagsInput();
          });
          </script>";

  } else if ('captcha' == $attr['type']) {

   echo "<br>reCaptcha spam block is UNDER DEVELOPMENT<br>";

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

   //Toggle GUI editor
   if ("true" == $attr['editor']) {

    ?>
          <div class="flexi_text-editor">
              <?php $settings = array(
     'wpautop'          => true, // enable rich text editor
     'media_buttons'    => false, // enable add media button
     'textarea_name'    => 'user-submitted-content', // name
     'textarea_rows'    => '10', // number of textarea rows
     'tabindex'         => '', // tabindex
     'editor_css'       => '', // extra CSS
     'editor_class'     => 'usp-rich-textarea', // class
     'teeny'            => false, // output minimal editor config
     'dfw'              => false, // replace fullscreen with DFW
     'tinymce'          => true, // enable TinyMCE
     'quicktags'        => true, // enable quicktags
     'drag_drop_upload' => true, // enable drag-drop
    );
    wp_editor('', 'flexicontent', apply_filters('flexi_editor_settings', $settings));?>

          </div>
  <?php
} else {
    // arguments: name, rows, cols, value, optional assoc. array
    echo $frm->addTextArea(
     'user-submitted-content',
     $attr['rows'],
     $attr['cols'],
     '',
     array('id' => $attr['id'], 'placeholder' => $attr['placeholder'], 'required' => $attr['required'])
    );
   }

  } else if ('text' == $attr['type']) {
   //if($attr['placeholder']=='')
   // arguments: for (id of associated form element), text
   echo $frm->addLabelFor($attr['name'], $attr['title']);
   // arguments: type, name, value
   echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

  } else if ('other' == $attr['type']) {
   //if($attr['placeholder']=='')
   // arguments: for (id of associated form element), text
   echo $frm->addLabelFor($attr['name'], $attr['title']);
   // arguments: type, name, value
   echo $frm->addInput($attr['new_type'], $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));

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
  return $abc;
 }
}