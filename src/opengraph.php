<?php
class Opengraph extends Social {
	public function __construct( $id = null ) {
		if ( $id === null ) {
			global $post;
			$this->post_id = $post->ID;
		} else {
			$this->post_id = $id;
		}
		$this->meta_field = '_wds_opengraph';
		$this->set_data();
		$this->set_helper();
	}

	public function get_images() {
		if ( $this->is_disabled() ) {
			return null;
		}

		$images = $this->helper->get_images();
		if ( ! empty( $images ) && is_array( $images ) ) {
			foreach ( $images as $image ) {
				$object            = new stdClass();
				$object->sourceUrl = $image;

				$ret[] = $object;
			}

			return $ret;
		} else {
			return null;
		}
	}

	public function set_helper() {
		$obj = Smartcrawl_OpenGraph_Printer::get();
		$helper     = new Smartcrawl_OpenGraph_Value_Helper();
		$this->helper = $helper;

		return true;
	}

	public function is_disabled() {
	 	return ! $this->helper->is_enabled();
	}
}
