<?php
/**
 * Handling stylesheets and scripts
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


function disable_elementor_google_fonts(): bool
{
	return false;
}
add_filter('elementor/frontend/print_google_fonts', 'disable_elementor_google_fonts');