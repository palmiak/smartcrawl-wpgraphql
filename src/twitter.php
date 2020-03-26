<?php
class Twitter extends Social {
	public function __construct( $object = null ) {
		if ( $object === null ) {
			global $post;
			$this->object = $post;
		} else {
			$this->object = $object;
		}

		$this->post_id = $post->ID;
		$this->meta_field = '_wds_twitter';
		$this->set_data();
		$this->set_helper();
	}

	public function get_images() {
		if ( $this->is_disabled() ) {
			return '';
		}

		$image = $this->helper->get_image_content();

		if ( ! empty( $image ) ) {
			$object            = new stdClass();
			$object->sourceUrl = $image;
			return $object;
		} else {
			return null;
		}
	}

	public function set_helper() {
		$this->helper = Smartcrawl_Twitter_Printer::get();
	}

	public function is_disabled() {
		$options = Options::get_instance();
		$key = 'twitter-active-' . $this->object->post_type;

		$disabled_by_post = isset( $this->data['disabled'] ) && $this->data['disabled'];
		$disabled_by_type = ! $options->get( $key );
		$disabled_globally = empty( $options->get( 'twitter-card-enable' ) );


		return $disabled_by_post || $disabled_by_type || $disabled_globally;
	}

	public function get_card_type() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return Smartcrawl_Twitter_Printer::get()->get_card_content();
	}
}
