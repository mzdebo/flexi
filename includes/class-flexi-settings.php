<?php

/**
 * Settings
 *
 * @link    https://odude.com
 * @since   1.0.0
 *
 * @package Flexi
 */

// Exit if accessed directly
if (!defined('WPINC')) {
    die;
}

/**
 * AIOVG_Admin_Settings class.
 *
 * @since 1.0.0
 */
class FLEXI_Admin_Settings
{

    /**
     * Settings tabs array.
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $tabs = array();

    /**
     * Settings sections array.
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $sections = array();

    /**
     * Settings fields array
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $fields = array();

    /**
     * Add a settings menu for the plugin.
     *
     * @since 1.0.0
     */
    public function admin_menu()
    {
        add_submenu_page(
            'flexi',
            __('Flexi - Settings', 'flexi'),
            __('Settings', 'flexi'),
            'manage_options',
            'flexi_settings',
            array($this, 'gallery_settings_form')
        );
    }

    /**
     * gallery settings form.
     *
     * @since 1.0.0
     */
    public function gallery_settings_form()
    {
        require FLEXI_PLUGIN_DIR  . 'admin/partials/settings.php';
    }

    /**
     * Initiate settings.
     *
     * @since 1.0.0
     */
    public function admin_init()
    {
        $this->tabs     = $this->get_tabs();
        $this->sections = $this->get_sections();
        $this->fields   = $this->get_fields();

        // Initialize settings
        $this->initialize_settings();
    }

    /**
     * Get settings tabs.
     *
     * @since  1.0.0
     * @return array $tabs Setting tabs array.
     */
    public function get_tabs()
    {
        $tabs = array(
            'general'  => __('General', 'flexi'),
            'gallery'  => __('gallery', 'flexi'),
            'advanced' => __('Advanced', 'flexi')
        );

        return apply_filters('aiovg_settings_tabs', $tabs);
    }

    /**
     * Get settings sections.
     *
     * @since  1.0.0
     * @return array $sections Setting sections array.
     */
    public function get_sections()
    {
        $sections = array(
            array(
                'id'    => 'aiovg_general_settings',
                'title' => __('General Settings', 'flexi'),
                'tab'   => 'general'
            ),
            array(
                'id'    => 'aiovg_player_settings',
                'title' => __('Player Settings', 'flexi'),
                'tab'   => 'general'
            ),
            array(
                'id'    => 'aiovg_videos_settings',
                'title' => __('Videos Layout', 'flexi'),
                'tab'   => 'gallery'
            ),
            array(
                'id'    => 'aiovg_categories_settings',
                'title' => __('Categories Layout', 'flexi'),
                'tab'   => 'gallery'
            ),
            array(
                'id'    => 'aiovg_video_settings',
                'title' => __('Single Video Page', 'flexi'),
                'tab'   => 'gallery'
            ),
            array(
                'id'    => 'aiovg_image_settings',
                'title' => __('Image Settings', 'flexi'),
                'tab'   => 'gallery'
            ),
            array(
                'id'    => 'aiovg_page_settings',
                'title' => __('Page Settings', 'flexi'),
                'tab'   => 'advanced'
            ),
            array(
                'id'          => 'aiovg_permalink_settings',
                'title'       => __('Permalink Slugs', 'flexi'),
                'description' => __('NOTE: Just make sure that, after updating the fields in this section, you flush the rewrite rules by visiting "Settings > Permalinks". Otherwise you\'ll still see the old links.', 'flexi'),
                'tab'         => 'advanced'
            ),
            array(
                'id'          => 'aiovg_socialshare_settings',
                'title'       => __('Socialshare Buttons', 'flexi'),
                'description' => __('Select social share buttons galleryed in the single video pages.', 'flexi'),
                'tab'         => 'advanced'
            ),
            array(
                'id'          => 'aiovg_privacy_settings',
                'title'       => __('Privacy Settings', 'flexi'),
                'description' => __('These options will help with privacy restrictions such as GDPR and the EU Cookie Law.', 'flexi'),
                'tab'         => 'advanced'
            )
        );

        if (false !== get_option('aiovg_brand_settings')) {
            $sections[] = array(
                'id'    => 'aiovg_brand_settings',
                'title' => __('Logo & Branding', 'flexi'),
                'tab'   => 'general'
            );
        }

        return apply_filters('aiovg_settings_sections', $sections);
    }

    /**
     * Get settings fields.
     *
     * @since  1.0.0
     * @return array $fields Setting fields array.
     */
    public function get_fields()
    {
        //$video_templates = aiovg_get_video_templates();
        $video_templates = 'classic';
        $fields = array(
            'aiovg_general_settings' => array(
                array(
                    'name'              => 'delete_plugin_data',
                    'label'             => __('Remove data on uninstall?', 'flexi'),
                    'description'       => __('Check this box to delete all of the plugin data (database stored content) when uninstalled', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'delete_media_files',
                    'label'             => __('Delete media files?', 'flexi'),
                    'description'       => __('Check this box to also delete the associated media files when a video post or a video category is deleted', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                )
            ),
            'aiovg_player_settings' => array(
                array(
                    'name'              => 'width',
                    'label'             => __('Width', 'flexi'),
                    'description'       => __('In pixels. Maximum width of the player. Leave this field empty to scale 100% of its enclosing container/html element.', 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'aiovg_sanitize_int'
                ),
                array(
                    'name'              => 'ratio',
                    'label'             => __('Ratio', 'flexi'),
                    'description'       => sprintf(
                        '%s<br /><br /><strong>%s:</strong><br />"56.25" - %s<br />"62.5" - %s<br />"75" - %s<br />"67" - %s<br />"100" - %s<br />"41.7" - %s',
                        __("In percentage. 1 to 100. Calculate player's height using the ratio value entered.", 'flexi'),
                        __('Examples', 'flexi'),
                        __('Wide Screen TV', 'flexi'),
                        __('Monitor Screens', 'flexi'),
                        __('Classic TV', 'flexi'),
                        __('Photo Camera', 'flexi'),
                        __('Square', 'flexi'),
                        __('Cinemascope', 'flexi')
                    ),
                    'type'              => 'text',
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'              => 'autoplay',
                    'label'             => __('Autoplay', 'flexi'),
                    'description'       => __('Check this to start playing the video as soon as it is ready', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'loop',
                    'label'             => __('Loop', 'flexi'),
                    'description'       => __('Check this, so that the video will start over again, every time it is finished', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'muted',
                    'label'             => __('Muted', 'flexi'),
                    'description'       => __('Check this to turn OFF the audio output of the video by default', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'preload',
                    'label'             => __('Preload', 'flexi'),
                    'description'       => sprintf(
                        '%s<br /><br />%s<br />%s<br />%s',
                        __('Specifies if and how the video should be loaded when the page loads.', 'flexi'),
                        __('"Auto" - the video should be loaded entirely when the page loads', 'flexi'),
                        __('"Metadata" - only metadata should be loaded when the page loads', 'flexi'),
                        __('"None" - the video should not be loaded when the page loads', 'flexi')
                    ),
                    'type'              => 'select',
                    'options'           => array(
                        'auto'     => __('Auto', 'flexi'),
                        'metadata' => __('Metadata', 'flexi'),
                        'none'     => __('None', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'controls',
                    'label'             => __('Player Controls', 'flexi'),
                    'description'       => '',
                    'type'              => 'multicheck',
                    'options'           => array(
                        'playpause'  => __('Play / Pause', 'flexi'),
                        'current'    => __('Current Time', 'flexi'),
                        'progress'   => __('Progressbar', 'flexi'),
                        'duration'   => __('Duration', 'flexi'),
                        'tracks'     => __('Subtitles', 'flexi'),
                        'volume'     => __('Volume', 'flexi'),
                        'fullscreen' => __('Fullscreen', 'flexi')
                    ),
                    'sanitize_callback' => 'aiovg_sanitize_array'
                ),
                array(
                    'name'              => 'use_native_controls',
                    'label'             => __('Use Native Controls', 'flexi'),
                    'description'       => __('Enables native player controls on the selected source types. For example, uses YouTube Player for playing YouTube videos & Vimeo Player for playing Vimeo videos. Note that none of our custom player features will work on the selected sources.', 'flexi'),
                    'type'              => 'multicheck',
                    'options'           => array(
                        'youtube'     => __('YouTube', 'flexi'),
                        'vimeo'       => __('Vimeo', 'flexi'),
                        'dailymotion' => __('Dailymotion', 'flexi'),
                        'facebook'    => __('Facebook', 'flexi')
                    ),
                    'sanitize_callback' => 'aiovg_sanitize_array'
                )
            ),
            'aiovg_videos_settings' => array(
                array(
                    'name'              => 'template',
                    'label'             => __('Select Template', 'flexi'),
                    'description'       => 'uuuuuu',
                    'type'              => 'select',
                    'options'           => $video_templates,
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'columns',
                    'label'             => __('Columns', 'flexi'),
                    'description'       => __('Enter the number of columns you like to have in the gallery view.', 'flexi'),
                    'type'              => 'number',
                    'min'               => 1,
                    'max'               => 12,
                    'step'              => 1,
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'limit',
                    'label'             => __('Limit (per page)', 'flexi'),
                    'description'       => __('Number of videos to show per page. Use a value of "0" to show all videos.', 'flexi'),
                    'type'              => 'number',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'orderby',
                    'label'             => __('Order By', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'title' => __('Title', 'flexi'),
                        'date'  => __('Date Posted', 'flexi'),
                        'views' => __('Views Count', 'flexi'),
                        'rand'  => __('Random', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'order',
                    'label'             => __('Order', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'asc'  => __('Ascending', 'flexi'),
                        'desc' => __('Descending', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'thumbnail_style',
                    'label'             => __('Thumbnail Style', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'standard'   => __('Image Top Aligned', 'flexi'),
                        'image-left' => __('Image Left Aligned', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'gallery',
                    'label'             => __('Show / Hide', 'flexi'),
                    'description'       => '',
                    'type'              => 'multicheck',
                    'options'           => array(
                        'count'    => __('Videos Count', 'flexi'),
                        'category' => __('Category Name', 'flexi'),
                        'date'     => __('Date Added', 'flexi'),
                        'user'     => __('Author Name', 'flexi'),
                        'views'    => __('Views Count', 'flexi'),
                        'duration' => __('Video Duration', 'flexi'),
                        'excerpt'  => __('Video Excerpt', 'flexi')
                    ),
                    'sanitize_callback' => 'aiovg_sanitize_array'
                ),
                array(
                    'name'              => 'excerpt_length',
                    'label'             => __('Excerpt Length', 'flexi'),
                    'description'       => __('Number of characters.', 'flexi'),
                    'type'              => 'number',
                    'sanitize_callback' => 'intval'
                ),
            ),
            'aiovg_categories_settings' => array(
                array(
                    'name'              => 'template',
                    'label'             => __('Select Template', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'grid' => __('Grid', 'flexi'),
                        'list' => __('List', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'columns',
                    'label'             => __('Columns', 'flexi'),
                    'description'       => __('Enter the number of columns you like to have in your categories page.', 'flexi'),
                    'type'              => 'number',
                    'min'               => 1,
                    'max'               => 12,
                    'step'              => 1,
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'orderby',
                    'label'             => __('Order by', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'id'    => __('ID', 'flexi'),
                        'count' => __('Count', 'flexi'),
                        'name'  => __('Name', 'flexi'),
                        'slug'  => __('Slug', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'order',
                    'label'             => __('Order', 'flexi'),
                    'description'       => '',
                    'type'              => 'select',
                    'options'           => array(
                        'asc'  => __('Ascending', 'flexi'),
                        'desc' => __('Descending', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'hierarchical',
                    'label'             => __('Show Hierarchy', 'flexi'),
                    'description'       => __('Check this to show the child categories', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'show_description',
                    'label'             => __('Show Description', 'flexi'),
                    'description'       => __('Check this to show the categories description', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'show_count',
                    'label'             => __('Show Videos Count', 'flexi'),
                    'description'       => __('Check this to show the videos count next to the category name', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'hide_empty',
                    'label'             => __('Hide Empty Categories', 'flexi'),
                    'description'       => __('Check this to hide categories with no videos', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                )
            ),
            'aiovg_video_settings' => array(
                array(
                    'name'              => 'gallery',
                    'label'             => __('Show / Hide', 'flexi'),
                    'description'       => '',
                    'type'              => 'multicheck',
                    'options'           => array(
                        'category' => __('Category Name', 'flexi'),
                        'date'     => __('Date Added', 'flexi'),
                        'user'     => __('Author Name', 'flexi'),
                        'views'    => __('Views Count', 'flexi'),
                        'related'  => __('Related Videos', 'flexi')
                    ),
                    'sanitize_callback' => 'aiovg_sanitize_array'
                ),
                array(
                    'name'              => 'has_comments',
                    'label'             => __('Enable Comments', 'flexi'),
                    'description'       => __('Allow visitors to comment videos using the standard WordPress comment form. Comments are public', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                )
            ),
            'aiovg_image_settings' => array(
                array(
                    'name'              => 'width',
                    'label'             => __('Width', 'flexi'),
                    'description'       => __('Always 100% of its enclosing container/html element.', 'flexi'),
                    'type'              => 'html',
                    'sanitize_callback' => 'aiovg_sanitize_int'
                ),
                array(
                    'name'              => 'ratio',
                    'label'             => __('Ratio', 'flexi'),
                    'description'       => __("In percentage. 1 to 100. Calculate images's height using the ratio value entered.", 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'floatval'
                ),
            ),
            'aiovg_page_settings' => array(
                array(
                    'name'              => 'category',
                    'label'             => __('Single Category Page', 'flexi'),
                    'description'       => __('This is the page where the videos from a particular category is galleryed. The [aiovg_category] short code must be on this page.', 'flexi'),
                    'type'              => 'pages',
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'search',
                    'label'             => __('Search Page', 'flexi'),
                    'description'       => __('This is the page where the search results are galleryed. The [aiovg_search] short code must be on this page.', 'flexi'),
                    'type'              => 'pages',
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'user_videos',
                    'label'             => __('User Videos Page', 'flexi'),
                    'description'       => __('This is the page where the videos from an user is galleryed. The [aiovg_user_videos] short code must be on this page.', 'flexi'),
                    'type'              => 'pages',
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'player',
                    'label'             => __('Player Page', 'flexi'),
                    'description'       => __('This is the page used to show the video player.', 'flexi'),
                    'type'              => 'pages',
                    'sanitize_callback' => 'sanitize_key'
                )
            ),
            'aiovg_permalink_settings' => array(
                array(
                    'name'              => 'video',
                    'label'             => __('Video Detail Page', 'flexi'),
                    'description'       => __('Replaces the SLUG value used by custom post type "aiovg_videos".', 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                )
            ),
            'aiovg_socialshare_settings' => array(
                array(
                    'name'              => 'services',
                    'label'             => __('Enable Services', 'flexi'),
                    'description'       => '',
                    'type'              => 'multicheck',
                    'options'           => array(
                        'facebook'  => __('Facebook', 'flexi'),
                        'twitter'   => __('Twitter', 'flexi'),
                        'linkedin'  => __('Linkedin', 'flexi'),
                        'pinterest' => __('Pinterest', 'flexi'),
                        'whatsapp'  => __('WhatsApp', 'flexi')
                    ),
                    'sanitize_callback' => 'aiovg_sanitize_array'
                )
            ),
            'aiovg_privacy_settings' => array(
                array(
                    'name'              => 'show_consent',
                    'label'             => __('GDPR - Show Consent', 'flexi'),
                    'description'       => __('Ask for consent before loading YouTube / Vimeo content.', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'consent_message',
                    'label'             => __('GDPR - Consent Message', 'flexi'),
                    'description'       => '',
                    'type'              => 'wysiwyg',
                    'sanitize_callback' => 'wp_kses_post'
                ),
                array(
                    'name'              => 'consent_button_label',
                    'label'             => __('GDPR - Consent Button Label', 'flexi'),
                    'description'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                )
            )
        );

        if (false !== get_option('aiovg_brand_settings')) {
            $fields['aiovg_brand_settings'] = array(
                array(
                    'name'              => 'show_logo',
                    'label'             => __('Show Logo', 'flexi'),
                    'description'       => __('Check this option to show the watermark on the video.', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'logo_image',
                    'label'             => __('Logo Image', 'flexi'),
                    'description'       => __('Upload the image file of your logo. We recommend using the transparent PNG format with width below 100 pixels. If you do not enter any image, no logo will galleryed.', 'flexi'),
                    'type'              => 'file',
                    'sanitize_callback' => 'esc_url_raw'
                ),
                array(
                    'name'              => 'logo_link',
                    'label'             => __('Logo Link', 'flexi'),
                    'description'       => __('The URL to visit when the watermark image is clicked. Clicking a logo will have no affect unless this is configured.', 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'esc_url_raw'
                ),
                array(
                    'name'              => 'logo_position',
                    'label'             => __('Logo Position', 'flexi'),
                    'description'       => __('This sets the corner in which to gallery the watermark.', 'flexi'),
                    'type'              => 'select',
                    'options'           => array(
                        'topleft'     => __('Top Left', 'flexi'),
                        'topright'    => __('Top Right', 'flexi'),
                        'bottomleft'  => __('Bottom Left', 'flexi'),
                        'bottomright' => __('Bottom Right', 'flexi')
                    ),
                    'sanitize_callback' => 'sanitize_key'
                ),
                array(
                    'name'              => 'logo_margin',
                    'label'             => __('Logo Margin', 'flexi'),
                    'description'       => __('The distance, in pixels, of the logo from the edges of the gallery.', 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'              => 'copyright_text',
                    'label'             => __('Copyright Text', 'flexi'),
                    'description'       => __('Text that is shown when a user right-clicks the player with the mouse.', 'flexi'),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                )
            );
        }

        return apply_filters('aiovg_settings_fields', $fields);
    }

    /**
     * Initialize and registers the settings sections and fields to WordPress.
     *
     * @since 1.0.0
     */
    public function initialize_settings()
    {
        // Register settings sections & fields
        foreach ($this->sections as $section) {
            $page_hook = $section['id'];

            // Sections
            if (false == get_option($section['id'])) {
                add_option($section['id']);
            }

            if (isset($section['description']) && !empty($section['description'])) {
                $callback = array($this, 'settings_section_callback');
            } elseif (isset($section['callback'])) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section($section['id'], $section['title'], $callback, $page_hook);

            // Fields			
            $fields = $this->fields[$section['id']];

            foreach ($fields as $option) {
                $name     = $option['name'];
                $type     = isset($option['type']) ? $option['type'] : 'text';
                $label    = isset($option['label']) ? $option['label'] : '';
                $callback = isset($option['callback']) ? $option['callback'] : array($this, 'callback_' . $type);
                $args     = array(
                    'id'                => $name,
                    'class'             => isset($option['class']) ? $option['class'] : $name,
                    'label_for'         => "{$section['id']}[{$name}]",
                    'description'       => isset($option['description']) ? $option['description'] : '',
                    'name'              => $label,
                    'section'           => $section['id'],
                    'size'              => isset($option['size']) ? $option['size'] : null,
                    'options'           => isset($option['options']) ? $option['options'] : '',
                    'sanitize_callback' => isset($option['sanitize_callback']) ? $option['sanitize_callback'] : '',
                    'type'              => $type,
                    'placeholder'       => isset($option['placeholder']) ? $option['placeholder'] : '',
                    'min'               => isset($option['min']) ? $option['min'] : '',
                    'max'               => isset($option['max']) ? $option['max'] : '',
                    'step'              => isset($option['step']) ? $option['step'] : ''
                );

                add_settings_field("{$section['id']}[{$name}]", $label, $callback, $page_hook, $section['id'], $args);
            }

            // Creates our settings in the options table
            register_setting($page_hook, $section['id'], array($this, 'sanitize_options'));
        }
    }

    /**
     * gallerys a section description.
     *
     * @since 1.0.0
     * @param array $args Settings section args.
     */
    public function settings_section_callback($args)
    {
        foreach ($this->sections as $section) {
            if ($section['id'] == $args['id']) {
                printf('<div class="inside">%s</div>', sanitize_text_field($section['description']));
                break;
            }
        }
    }

    /**
     * gallerys a text field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_text($args)
    {
        $value       = esc_attr($this->get_option($args['id'], $args['section'], ''));
        $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
        $type        = isset($args['type']) ? $args['type'] : 'text';
        $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf('<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder);
        $html       .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a url field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_url($args)
    {
        $this->callback_text($args);
    }

    /**
     * gallerys a number field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_number($args)
    {
        $value       = esc_attr($this->get_option($args['id'], $args['section'], 0));
        $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
        $type        = isset($args['type']) ? $args['type'] : 'number';
        $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $min         = empty($args['min']) ? '' : ' min="' . $args['min'] . '"';
        $max         = empty($args['max']) ? '' : ' max="' . $args['max'] . '"';
        $step        = empty($args['max']) ? '' : ' step="' . $args['step'] . '"';

        $html        = sprintf('<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step);
        $html       .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a checkbox for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_checkbox($args)
    {
        $value = esc_attr($this->get_option($args['id'], $args['section'], 0));

        $html  = '<fieldset>';
        $html  .= sprintf('<label for="%1$s[%2$s]">', $args['section'], $args['id']);
        $html  .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="0" />', $args['section'], $args['id']);
        $html  .= sprintf('<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="1" %3$s />', $args['section'], $args['id'], checked($value, 1, false));
        $html  .= sprintf('%1$s</label>', $args['description']);
        $html  .= '</fieldset>';

        echo $html;
    }

    /**
     * gallerys a multicheckbox for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_multicheck($args)
    {
        $value = $this->get_option($args['id'], $args['section'], array());

        $html  = '<fieldset>';
        $html .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id']);
        foreach ($args['options'] as $key => $label) {
            $checked  = in_array($key, $value) ? 'checked="checked"' : '';
            $html    .= sprintf('<label for="%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key);
            $html    .= sprintf('<input type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, $checked);
            $html    .= sprintf('%1$s</label><br>',  $label);
        }
        $html .= $this->get_field_description($args);
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * gallerys a radio button for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_radio($args)
    {
        $value = $this->get_option($args['id'], $args['section'], '');

        $html  = '<fieldset>';
        foreach ($args['options'] as $key => $label) {
            $html .= sprintf('<label for="%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key);
            $html .= sprintf('<input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked($value, $key, false));
            $html .= sprintf('%1$s</label><br>', $label);
        }
        $html .= $this->get_field_description($args);
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * gallerys a selectbox for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_select($args)
    {
        $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
        $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

        $html  = sprintf('<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id']);
        foreach ($args['options'] as $key => $label) {
            $html .= sprintf('<option value="%s"%s>%s</option>', $key, selected($value, $key, false), $label);
        }
        $html .= sprintf('</select>');
        $html .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a textarea for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_textarea($args)
    {
        $value       = esc_textarea($this->get_option($args['id'], $args['section'], ''));
        $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
        $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf('<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $size, $args['section'], $args['id'], $placeholder, $value);
        $html       .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys the html for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_html($args)
    {
        echo $this->get_field_description($args);
    }

    /**
     * gallerys a rich text textarea for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_wysiwyg($args)
    {
        $value = $this->get_option($args['id'], $args['section'], '');
        $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : '500px';

        echo '<div style="max-width: ' . $size . ';">';
        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10
        );
        if (isset($args['options']) && is_array($args['options'])) {
            $editor_settings = array_merge($editor_settings, $args['options']);
        }
        wp_editor($value, $args['section'] . '-' . $args['id'], $editor_settings);
        echo '</div>';
        echo $this->get_field_description($args);
    }

    /**
     * gallerys a file upload field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_file($args)
    {
        $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
        $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
        $id    = $args['section'] . '[' . $args['id'] . ']';
        $label = isset($args['options']['button_label']) ? $args['options']['button_label'] : __('Choose File', 'flexi');

        $html  = sprintf('<input type="text" class="%1$s-text aiovg-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value);
        $html .= '<input type="button" class="button aiovg-browse" value="' . $label . '" />';
        $html .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a password field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_password($args)
    {
        $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
        $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

        $html  = sprintf('<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value);
        $html .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a color picker field for a settings field.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_color($args)
    {
        $value = esc_attr($this->get_option($args['id'], $args['section'], '#ffffff'));
        $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

        $html  = sprintf('<input type="text" class="%1$s-text aiovg-color-picker" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, '#ffffff');
        $html .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * gallerys a select box for creating the pages select box.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function callback_pages($args)
    {
        $dropdown_args = array(
            'show_option_none'  => '-- ' . __('Select a page', 'flexi') . ' --',
            'option_none_value' => -1,
            'selected'          => esc_attr($this->get_option($args['id'], $args['section'], -1)),
            'name'              => $args['section'] . '[' . $args['id'] . ']',
            'id'                => $args['section'] . '[' . $args['id'] . ']',
            'echo'              => 0
        );

        $html  = wp_dropdown_pages($dropdown_args);
        $html .= $this->get_field_description($args);

        echo $html;
    }

    /**
     * Get field description for gallery.
     *
     * @since 1.0.0
     * @param array $args Settings field args.
     */
    public function get_field_description($args)
    {
        if (!empty($args['description'])) {
            if ('wysiwyg' == $args['type']) {
                $description = sprintf('<pre>%s</pre>', $args['description']);
            } else {
                $description = sprintf('<p class="description">%s</p>', $args['description']);
            }
        } else {
            $description = '';
        }

        return $description;
    }

    /**
     * Sanitize callback for Settings API.
     *
     * @since  1.0.0
     * @param  array $options The unsanitized collection of options.
     * @return                The collection of sanitized values.
     */
    public function sanitize_options($options)
    {
        if (!$options) {
            return $options;
        }

        foreach ($options as $option_slug => $option_value) {
            $sanitize_callback = $this->get_sanitize_callback($option_slug);

            // If callback is set, call it
            if ($sanitize_callback) {
                $options[$option_slug] = call_user_func($sanitize_callback, $option_value);
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug.
     *
     * @since  1.0.0
     * @param  string $slug Option slug.
     * @return mixed        String or bool false.
     */
    public function get_sanitize_callback($slug = '')
    {
        if (empty($slug)) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach ($this->fields as $section => $options) {
            foreach ($options as $option) {
                if ($option['name'] != $slug) {
                    continue;
                }

                // Return the callback name
                return isset($option['sanitize_callback']) && is_callable($option['sanitize_callback']) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }

    /**
     * Get the value of a settings field.
     *
     * @since  1.0.0
     * @param  string $option  Settings field name.
     * @param  string $section The section name this field belongs to.
     * @param  string $default Default text if it's not found.
     * @return string
     */
    public function get_option($option, $section, $default = '')
    {
        $options = get_option($section);

        if (!empty($options[$option])) {
            return $options[$option];
        }

        return $default;
    }
}
