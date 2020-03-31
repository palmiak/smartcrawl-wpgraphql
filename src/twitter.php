<?php
class Twitter extends Social {
	public function __construct( $object, $type = 'post_type' ) {
		$this->object = $object;

		if ( $type === 'post_type' ) {
			$this->id     = $this->object->ID;
		} elseif( $type === 'taxonomy' ) {
			$this->id     = $this->object->term_id;
		}

		$this->type        = $type;
		$this->meta_field  = '_wds_twitter';
		$this->social_meta = 'twitter';
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

		if ( $this->type === 'post_type' ) {
			$key = 'twitter-active-' . trim( $this->object->post_type );
		} else {
			$key = 'twitter-active-' . trim( $this->object->taxonomy );
		}

		$disabled_by_type  = ! $options->get( $key );
		$disabled_by_entry = isset( $this->data['disabled'] ) && $this->data['disabled'];
		$disabled_globally = empty( $options->get( 'twitter-card-enable' ) );

		return $disabled_by_entry || $disabled_by_type || $disabled_globally;
	}

	public function get_card_type() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return Smartcrawl_Twitter_Printer::get()->get_card_content();
	}

	public function get_title() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return $this->helper->get_title_content();
	}

	public function get_description() {
		if ( $this->is_disabled() ) {
			return '';
		}
		return $this->helper->get_description_content();
	}
}
