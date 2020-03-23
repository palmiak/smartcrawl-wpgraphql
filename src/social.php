<?php

abstract class Social {
	var $data;
	var $meta_field;
	var $post_id;

	function get_title( $title = '' ) {
		if ( $this->is_disabled() ) {
			return '';
		}

		return ! empty( $this->data['title'] ) ? $this->data['title'] : $title;
	}

	function get_description( $description = '' ) {
		if ( $this->is_disabled() ) {
			return '';
		}

		return ! empty( $data['description'] ) ? $data['description'] : $description;

	}

	function get_data() {
		if ( empty( $this->data ) ) {
			$this->set_data( $this->post_id );
		}
		return $this->data;
	}

	function set_data() {
		if ( empty( $this->data ) ) {
			$data = get_post_meta( $this->post_id, $this->meta_field, true );

			if ( isset( $data['disabled'] ) && $data['disabled'] ) {
				$this->data = array( 'disabled' => true );
				return false;
			}

			$this->data = $data;
			return true;
		}

		$this->data = array( 'disabled' => true );
		return false;
	}

	function clear_data() {
		$this->data = null;
	}

	function is_disabled() {
		if ( isset( $this->data['disabled'] ) && $this->data['disabled'] ) {
			return true;
		} else {
			return false;
		}
	}
}
