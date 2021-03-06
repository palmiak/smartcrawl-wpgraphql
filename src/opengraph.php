<?php
class Opengraph extends Social {
	public function __construct( $object = null, $type = 'post_type' ) {
		$this->object = $object;

		if ( $type === 'post_type' ) {
			$this->id     = $this->object->ID;
		} elseif( $type === 'taxonomy' ) {
			$this->id     = $this->object->term_id;
		}

		$this->type        = $type;

		$this->meta_field = '_wds_opengraph';
		$this->social_meta = 'opengraph';
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
		$obj          = Smartcrawl_OpenGraph_Printer::get();
		$helper       = new Smartcrawl_OpenGraph_Value_Helper();
		$this->helper = $helper;

		return true;
	}

	public function is_disabled() {
		return ! $this->helper->is_enabled();
	}

	public function get_title() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return $this->helper->get_title();
	}

	public function get_description() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return $this->helper->get_description();
	}
}
