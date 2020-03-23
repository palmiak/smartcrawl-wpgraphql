<?php
class PostSeo {
	var $post_id;

	public function __construct() {
		$this->post_id = $post->ID;
	}

	function get_title() {
		return esc_html( strip_tags( stripslashes( Smartcrawl_Meta_Value_Helper::get()->get_title() ) ) );
	}

	function get_description() {
		return esc_attr( wp_kses( strip_tags( Smartcrawl_Meta_Value_Helper::get()->get_description() ), array(), array() ) );
	}

	/**
	 * @todo check global options
	 */
	function get_robots_noindex() {
		return smartcrawl_get_value( 'meta-robots-noindex', $id ) ? 'noindex' : 'index';
	}

	/**
	 * @todo check global options
	 */
	function get_robots_nofollow() {
		return smartcrawl_get_value( 'meta-robots-nofollow', $id ) ? 'nofollow' : 'follow';
	}

	function get_canonical() {
		$helper = new Smartcrawl_Canonical_Value_Helper();

		return $helper->get_canonical();
	}
}
