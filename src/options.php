<?php
class Options {
	private static $_instance;
	private $options;
	private $follow;
	private $index;

	public static function get_instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->options = Smartcrawl_Settings::get_options();
	}

	public function get( $key ) {
		if ( isset( $this->options[ $key ] ) ) {
			return $this->options[ $key ];
		} else {
			return '';
		}
	}

	public function get_index() {
		return $this->index;
	}

	public function get_follow() {
		return $this->follow;
	}

	public function set_follow_index_data() {
		$helper = new Smartcrawl_Robots_Value_Helper();
		$helper->traverse();
		$robots = $helper->get_value();

		$this->index  = strpos( $robots, 'noindex' ) !== false ? 'noindex' : 'index';
		$this->follow = strpos( $robots, 'nofollow' ) !== false ? 'nofollow' : 'follow';
	}

	public function clear_data() {
		unset( $this->follow );
		unset( $this->index );
	}
}
