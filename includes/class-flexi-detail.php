<?php
class Flexi_Public_Detail
{
	public function __construct()
    {
       
       //
    }

	/**
	 * Filter the post content.
	 *
	 * @since  1.0.0
	 * @param  string $content Content of the current post.
	 * @return string $content Modified Content.
	 */
	public function the_content( $content ) {	
		if ( is_singular( 'flexi' ) && in_the_loop() && is_main_query() ) {		
			global $post;
			
			if (  is_user_logged_in() ) {
                $content = __( 'Sorry, this content is reserved for members only.', 'text-domain' );
            }
			// Process output
			//ob_start();
            //require apply_filters( 'flexi_load_template', FLEXI_PLUGIN_DIR  . 'public/partials/layout/detail/attach.php');
            //require FLEXI_PLUGIN_DIR  . 'public/partials/layout/detail/attach.php';
			//$content = ob_get_clean();			
		}
		
		return $content;	
	}
}
?>