<?php
class PostSeo {
	public function __construct( $id = null ) {
		if ( $id === null ) {
			global $post;
			$this->post_id = $post->ID;
		} else {
			$this->post_id = $id;
		}
	}

	public function get_title() {
		return esc_html(
			strip_tags(
				stripslashes( Smartcrawl_Meta_Value_Helper::get()->get_title() )
			)
		);
	}

	public function get_description() {
		return esc_attr(
			wp_kses(
				strip_tags( Smartcrawl_Meta_Value_Helper::get()->get_description() ),
				array(),
				array()
			)
		);
	}

	/**
	 * @todo check global options
	 */
	public function get_robots_noindex() {
		return smartcrawl_get_value( 'meta-robots-noindex', $this->post_id ) ? 'noindex' : 'index';
	}

	/**
	 * @todo check global options
	 */
	public function get_robots_nofollow() {
		return smartcrawl_get_value( 'meta-robots-nofollow', $this->post_id ) ? 'nofollow' : 'follow';
	}

	public function get_canonical() {
		$helper = new Smartcrawl_Canonical_Value_Helper();

		return $helper->get_canonical();
	}
}
