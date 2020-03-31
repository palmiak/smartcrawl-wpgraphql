<?php

abstract class Social {
	var $data;
	var $meta_field;
	var $id;
	var $helper;
	var $object;
	var $type;

	public function get_data() {
		if ( empty( $this->data ) ) {
			$this->set_data();
		}
		return $this->data;
	}

	public function set_data() {
		if ( empty( $this->data ) ) {
			if ( $this->type === 'post_type' ) {
				$data = get_post_meta( $this->id, $this->meta_field, true );
			} elseif ( $this->type === 'taxonomy' ) {
				$data = smartcrawl_get_term_meta( $this->object, $this->object->taxonomy, $this->social_meta );
			}

			if ( isset( $data['disabled'] ) && $data['disabled'] ) {
				$this->data = array( 'disabled' => true );
				return false;
			}

			$this->data = $data;
			return true;
		}

		return false;
	}

	public function clear_data() {
		$this->data   = null;
		$this->helper = null;
	}
}
