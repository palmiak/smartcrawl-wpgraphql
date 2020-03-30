<?php
class PostSeo {
	public $post_type;
	public $object;

	public function __construct( $object = null, $type = 'post_type' ) {
		$this->object = $object;
		$this->type = $object->post_type;
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

	public function get_robots_noindex() {
		$options = Options::get_instance();

		return $options->get_index();
	}

	public function get_robots_nofollow() {
		$options = Options::get_instance();

		return $options->get_follow();
	}

	public function get_canonical() {
		$helper = new Smartcrawl_Canonical_Value_Helper();

		return $helper->get_canonical();
	}

	public function get_focus_keywords() {
		return implode( ' ', Smartcrawl_Meta_Value_Helper::get()->get_focus_keywords() );
	}
}
