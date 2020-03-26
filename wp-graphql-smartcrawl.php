<?php

/**
 * Plugin Name:     WP GraphQL Smartcrawl
 * Plugin URI:      https://github.com/wp-graphql/wp-graphql
 * Description:     A WPGraphQL Extension that adds support for Smartcrawl
 * Author:          Maciek Palmowski
 * Author URI:
 * Text Domain:     wp-graphql-smartcrawl
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WP_Graphql_Smartcrawl
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

require __DIR__ . '/vendor/autoload.php';

use WPGraphQL\AppContext;

class WP_Graphql_Smartcrawl {
	public function __construct() {
		if ( !( class_exists( 'Smartcrawl_Loader' ) && class_exists( 'WPGraphQL' ) ) ) {
			add_action( 'admin_init', array( $this, 'plugin_deactivate' ) );
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		}

		add_action(
			'graphql_register_types',
			array( $this, 'init' )
		);
	}

	public function admin_notice() {
		echo '<div class="updated">
			<p><strong>WP GraphQL SmartCrawl</strong> requires SmartCrawl or SmartCrawl Pro and WP GraphQL to run. Therfore the plugin has been disabled.</p>
		</div>';
	}

	function plugin_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	public function init() {
		$post_types = \WPGraphQL::get_allowed_post_types();
		// $taxonomies = \WPGraphQL::get_allowed_taxonomies();

		register_graphql_object_type(
			'SEO',
			array(
				'fields' => array(
					'title'                => array( 'type' => 'String' ),
					'metaDesc'             => array( 'type' => 'String' ),
					'metaRobotsNoindex'    => array( 'type' => 'String' ),
					'metaRobotsNofollow'   => array( 'type' => 'String' ),
					'opengraphTitle'       => array( 'type' => 'String' ),
					'opengraphDescription' => array( 'type' => 'String' ),
					'opengraphImage'       => array( 'type' => array( 'list_of' => 'MediaItem' ) ),
					'canonical'            => array( 'type' => 'String' ),
					'twitterCard'          => array( 'type' => 'String' ),
					'twitterTitle'         => array( 'type' => 'String' ),
					'twitterDescription'   => array( 'type' => 'String' ),
					'twitterImage'         => array( 'type' => 'MediaItem' ),

				),
			)
		);

		if ( ! empty( $post_types ) && is_array( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				$post_type_object = get_post_type_object( $post_type );

				if ( isset( $post_type_object->graphql_single_name ) ) :
					register_graphql_field(
						$post_type_object->graphql_single_name,
						'smartcrawl_seo',
						array(
							'type'        => 'SEO',
							'description' => __( 'The Smartcrawl data of the SmartCrawl ', 'wp-graphql' ),
							'resolve'     => function ( $post, array $args, AppContext $context ) {
								// Base array
								$seo = array();

								query_posts(
									array(
										'p'         => $post->ID,
										'post_type' => 'any',
									)
								);
								the_post();

								$options = Options::get_instance();
								$options->set_follow_index_data();

								$post_seo = new PostSeo( null, $post->post_type );
								$twitter = new Twitter();
								$opengraph = new Opengraph();

								// Get data
								$seo = array(
									'title'                => $post_seo->get_title(),
									'metaDesc'             => $post_seo->get_description(),
									'metaRobotsNoindex'    => $post_seo->get_robots_noindex(),
									'metaRobotsNofollow'   => $post_seo->get_robots_nofollow(),
									'opengraphTitle'       => $opengraph->get_title( $post_seo->get_title() ),
									'opengraphDescription' => $opengraph->get_description( $post_seo->get_description() ),
									'opengraphImage'       => $opengraph->get_images(),
									'canonical'            => $post_seo->get_canonical(),
									'twitterTitle'         => $twitter->get_title( $post_seo->get_title() ),
									'twitterDescription'   => $twitter->get_description( $post_seo->get_description() ),
									'twitterImage'         => $twitter->get_images(),

								);
								wp_reset_query();
								$twitter->clear_data();
								$opengraph->clear_data();
								$options->clear_data();

								return ! empty( $seo ) ? $seo : null;
							},
						)
					);
				endif;
			}
		}
	}
}

add_action(
	'init',
	function() {
		new WP_Graphql_Smartcrawl();
	}
);
