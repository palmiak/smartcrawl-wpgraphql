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
	}

	public function get_images() {
		if ( $this->is_disabled() ) {
			return null;
		}

		if ( ! empty( $this->data['images'] ) && is_array( $this->data['images'] ) ) {
			foreach ( $this->data['images'] as $image ) {
				$object            = new stdClass();
				$object->sourceUrl = $image;

				$ret = $object;
			}

			return $ret;
		} else {
			return null;
		}
	}
}
