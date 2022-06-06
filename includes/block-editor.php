<?php
/**
 * Block editor (gutenberg) specific functionality
 *
 * @package UnderstrapChild
 */

add_filter( 'register_block_type_args', 'register_block_type_args_core_social_link_show_label', 10, 3 );
function register_block_type_args_core_social_link_show_label( $args, $name )
{
	if ( $name === 'core/social-link' ) {
		$args[ 'render_callback' ] = 'render_block_core_social_link_show_label';
	}
	return $args;
}

/**
 * Renders the `core/social-link` block on server.
 *
 * @see render_block_core_social_link
 *
 * @param Array    $attributes The block attributes.
 * @param String   $content    InnerBlocks content of the Block.
 * @param WP_Block $block      Block object.
 *
 * @return string Rendered HTML of the referenced block.
 */
function render_block_core_social_link_show_label( $attributes, $content, $block ) {
	$open_in_new_tab = isset( $block->context['openInNewTab'] ) ? $block->context['openInNewTab'] : false;

	$service = ( isset( $attributes['service'] ) ) ? $attributes['service'] : 'Icon';
	$url     = ( isset( $attributes['url'] ) ) ? $attributes['url'] : false;
	$label   = ( isset( $attributes['label'] ) ) ? $attributes['label'] : sprintf(
	/* translators: %1$s: Social-network name. %2$s: URL. */
		__( '%1$s: %2$s' ),
		block_core_social_link_get_name( $service ),
		$url
	);
	$class_name = isset( $attributes['className'] ) ? ' ' . $attributes['className'] : false;

	// Don't render a link if there is no URL set.
	if ( ! $url ) {
		return '';
	}

	$attribute = '';
	if ( $open_in_new_tab ) {
		$attribute = 'rel="noopener nofollow" target="_blank"';
	}

	$icon               = block_core_social_link_get_icon( $service );
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => 'wp-social-link wp-social-link-' . $service . $class_name,
			'style' => block_core_social_link_get_color_styles( $block->context ),
		)
	);

	return '<li ' . $wrapper_attributes . '><a href="' . esc_url( $url ) . '" aria-label="' . esc_attr( $label ) . '" ' . $attribute . ' class="wp-block-social-link-anchor"> ' . $icon . '<span class="ms-1">' . esc_attr( $label ) . '</span></a></li>';
}