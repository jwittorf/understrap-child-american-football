<?php
/**
 * Top Navbar
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$topnav_pos = get_theme_mod( 'understrap_child_topnav_position' );
?>

<div class="<?php echo esc_attr( $container ); ?>">
	<?php wp_nav_menu(
		array (
			'theme_location' => 'topnav',
			'menu_class'     => 'nav ' . $topnav_pos,
			'depth'          => 1,
			'walker'         => new Understrap_WP_Bootstrap_Navwalker(),
		)
	); ?>
</div>