<?php

/*	-----------------------------------------------------------------------------------------------
	THEME SUPPORTS
--------------------------------------------------------------------------------------------------- */

function susurrus_setup() {
	add_editor_style( array( trailingslashit( get_template_directory_uri() ) . 'assets/css/editor-style.css', 'style.css' ) );
}
add_action( 'after_setup_theme', 'susurrus_setup' );


/*	-----------------------------------------------------------------------------------------------
	ENQUEUE STYLESHEETS
--------------------------------------------------------------------------------------------------- */

function susurrus_styles() {
	wp_enqueue_style( 'susurrus_styles', get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'hideo' )->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'susurrus_styles' );


/*	-----------------------------------------------------------------------------------------------
	REGISTER BLOCK STYLES
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'susurrus_block_styles' ) ) :
	function susurrus_block_styles() {

		/* REGISTER STYLES FOR BLOCKS */

		$core_block_styles = apply_filters( 'susurrus_wp_enqueue_block_style_blocks', array( 
			'categories', 
			'comments', 
			'gallery', 
			'navigation', 
			'post-comments-form', 
			'post-navigation-link', 
			'pullquote', 
			'search' 
		) );

		foreach( $core_block_styles as $block_name ) {
			wp_enqueue_block_style(
				'core/' . $block_name,
				array(
					'handle' => 'susurrus-' . $block_name . '-style',
					'src'    => get_template_directory_uri() . '/assets/css/' . $block_name . '.css',
					'ver'    => wp_get_theme( 'susurrus' )->get( 'Version' ),
					'path'   => get_template_directory() . '/assets/css/' . $block_name . '.css',
				)
			);
		}

		/* REGISTER BLOCK STYLES */

		$desatured_style_blocks = array( 
			'core/avatar', 
			'core/image',
			'core/post-featured-image' 
		);

		foreach ( $desatured_style_blocks as $block_name ) {
			register_block_style(
				$block_name,
				array(
					'name'         => 'desaturated',
					'label'        => __( 'Desaturated', 'susurrus' ),
					'inline_style' => ".is-style-desaturated { mix-blend-mode: luminosity; }",
				)
			);
		}

		register_block_style(
			'core/column',
			array(
				'name'         => 'aspect-ratio-1-1',
				'label'        => __( '1:1 Aspect Ratio', 'susurrus' ),
				'inline_style' => ".is-style-aspect-ratio-1-1 { aspect-ratio: 1/1; }",
			)
		);

		register_block_style(
			'core/column',
			array(
				'name'         => 'aspect-ratio-4-3',
				'label'        => __( '4:3 Aspect Ratio', 'susurrus' ),
				'inline_style' => ".is-style-aspect-ratio-4-3 { aspect-ratio: 4/3; }",
			)
		);

		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill-shape-with-border',
				'label'        => __( 'Pill Shape With Border', 'susurrus' ),
				'inline_style' => "
				.wp-block-post-terms.is-style-pill-shape-with-border {
					display: flex;
					flex-wrap: wrap;
					gap: .75em;
				}
				.wp-block-post-terms.is-style-pill-shape-with-border a {
					border: 1px solid var( --wp--preset--color--30 ) !important;
					border-radius: 999px;
					padding: .44em 1em;
				}
				.is-style-pill-shape-with-border .wp-block-post-terms__separator {
					display: none;
				}",
			)
		);

		register_block_style(
			'core/post-date',
			array(
				'name'         => 'pill-shape',
				'label'        => __( 'Pill Shape', 'susurrus' ),
				'inline_style' => "
				.wp-block-post-date.is-style-pill-shape {
					border-radius: 99px;
				}",
			)
		);

		register_block_style(
			'core/query-pagination',
			array(
				'name'         => 'susurrus-pagination',
				'label'        => __( 'Susurrus Pagination', 'susurrus' ),
				'inline_style' => "
				:root .is-style-susurrus-pagination > *,
				.is-style-susurrus-pagination [class*=\"is-arrow-\"]:only-child {
					margin: 0;
				}

				.wp-block-query-pagination,
				.is-style-susurrus-pagination .wp-block-query-pagination-numbers {
					display: flex;
					flex-wrap: wrap;
					gap: .66em;
				}

				.is-style-susurrus-pagination > a,
				.is-style-susurrus-pagination .wp-block-query-pagination-numbers > * { 
					align-items: center;
					border: 1px solid var( --wp--preset--color--30 );
					border-radius: 50%;
					display: flex;
					height: 2em;
					justify-content: center;
					margin: 0;
					width: 2em;
				}

				.is-style-susurrus-pagination a:hover,
				.is-style-susurrus-pagination .wp-block-query-pagination-numbers .current {
					background: var( --wp--preset--color--30 );
				}",
			)
		);

		register_block_style(
			'core/quote',
			array(
				'name'         => 'has-quotation-mark',
				'label'        => __( 'Quotation Mark', 'susurrus' ),
				'inline_style' => "",
			)
		);

		register_block_style(
			'core/social-links',
			array(
				'name'         => 'pill-shape-with-border',
				'label'        => __( 'Default With Border', 'susurrus' ),
				'inline_style' => "
				:root .is-style-pill-shape-with-border .wp-block-social-link-anchor {
					border: 1px solid var( --wp--preset--color--30 ) !important;
					border-radius: 999px;
					padding: .33em;
				}",
			)
		);
		
	}
endif;
add_action( 'init', 'susurrus_block_styles' );


/*	-----------------------------------------------------------------------------------------------
	BLOCK PATTERNS
	Register theme specific block pattern categories. The patterns themselves are stored in /patterns/.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'susurrus_register_block_patterns' ) ) :
	function susurrus_register_block_patterns() {

		// The block pattern categories included in Susurrus.
		$susurrus_block_pattern_categories = apply_filters( 'susurrus_block_pattern_categories', array(
			'susurrus'  => array(
				'label'			=> esc_html__( 'Susurrus - All', 'susurrus' ),
			),
			'susurrus-cta'  => array(
				'label'			=> esc_html__( 'Susurrus - Call to Action', 'susurrus' ),
			),
			'susurrus-general' => array(
				'label'			=> esc_html__( 'Susurrus - General', 'susurrus' ),
			),
			'susurrus-hero' => array(
				'label'			=> esc_html__( 'Susurrus - Hero', 'susurrus' ),
			),
			'susurrus-media' => array(
				'label'			=> esc_html__( 'Susurrus - Media', 'susurrus' ),
			),
		) );

		// Sort the block pattern categories alphabetically based on the label value, to ensure alphabetized order when the strings are localized.
		uasort( $susurrus_block_pattern_categories, function( $a, $b ) { 
			return strcmp( $a["label"], $b["label"] ); }
		);

		// Register block pattern categories.
		foreach ( $susurrus_block_pattern_categories as $slug => $settings ) {
			register_block_pattern_category( $slug, $settings );
		}

	}
endif;
add_action( 'init', 'susurrus_register_block_patterns' );


/*	-----------------------------------------------------------------------------------------------
	MODIFY wp_list_categories() MARKUP

	In the output, wrap the category count in a span element so it can be styled separately.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'susurrus_modify_wp_list_categories_markup' ) ) :
	function susurrus_modify_wp_list_categories_markup( $output, $args ) {

		if ( $args['show_count'] === true ) {
			$output = str_replace(
				array( '</a> (', ')' ), 
				array( '</a><span class="count">', '</span>' ),
				$output
			);
		}

		return $output;

	}
endif;
add_filter( 'wp_list_categories', 'susurrus_modify_wp_list_categories_markup', 10, 2 );
