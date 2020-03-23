<?php
class PostSeo {
	public $post_type;

	public function __construct( $id = null, $post_type ) {
		if ( $id === null ) {
			global $post;
			$this->post_id = $post->ID;
		} else {
			$this->post_id = $id;
		}

		$this->post_type = $post_type;
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
		$options = Options::get_instance();

		return $options->get_index();
	}

	/**
	 * @todo check global options
	 */
	public function get_robots_nofollow() {
		$options = Options::get_instance();

		return $options->get_follow();
	}

	public function get_canonical() {
		$helper = new Smartcrawl_Canonical_Value_Helper();

		return $helper->get_canonical();
	}
}
