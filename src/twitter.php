<?php
class Twitter extends Social {
	public function __construct( $id = null ) {
		if ( $id === null ) {
			global $post;
			$this->post_id = $post->ID;
		} else {
			$this->post_id = $id;
		}
		$this->meta_field = '_wds_twitter';
		$this->set_data();
		$this->set_helper();
	}

	public function get_images() {
		if ( $this->is_disabled() ) {
			return null;
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

}
