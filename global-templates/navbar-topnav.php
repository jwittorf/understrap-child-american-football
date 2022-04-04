<?php
/**
 * Top Navbar
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="<?php echo esc_attr( $container ); ?>">
	<?php wp_nav_menu([
		'theme_location' => 'topnav',
		'menu_class' => 'nav justify-content-end',
		'walker' => new Understrap_WP_Bootstrap_Navwalker()
	]); ?>
</div>