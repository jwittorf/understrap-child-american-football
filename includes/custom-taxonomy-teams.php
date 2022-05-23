<?php
/**
 * Custom taxonomy for Teams
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Create a custom taxonomy, to organize football related content for each team.
function custom_taxonomy_teams()
{

	// Add new taxonomy, make it hierarchical like categories.
	// Do the translations part for GUI.
	$labels = array (
		'name'              => _x( 'Teams', 'taxonomy general name' ),
		'singular_name'     => _x( 'Team', 'taxonomy singular name' ),
		'search_items'      => __( 'Search teams' ),
		'all_items'         => __( 'All teams' ),
		'parent_item'       => __( 'Parent team' ),
		'parent_item_colon' => __( 'Parent team:' ),
		'edit_item'         => __( 'Edit team' ),
		'update_item'       => __( 'Update team' ),
		'add_new_item'      => __( 'Add new team' ),
		'new_item_name'     => __( 'New Team name' ),
		'menu_name'         => __( 'Teams' ),
	);

	// Register the taxonomy
	register_taxonomy( 'teams', array ( 'games' ), array (
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array ( 'slug' => 'team' ),
	) );
	register_taxonomy_for_object_type( 'teams', 'games' );

}

// hook into the init action and call custom_taxonomy_teams when it fires
add_action( 'init', 'custom_taxonomy_teams', 0 );


// Add additional fields to the created custom taxonomy.
add_action( 'teams_add_form_fields', 'custom_taxonomy_teams_add_term_fields' );
function custom_taxonomy_teams_add_term_fields()
{

	// URL
	echo '<div class="form-field">
	<label for="custom_taxonomy_teams-url">' . __( 'URL' ) . '</label>
	<input type="url" name="custom_taxonomy_teams-url" id="custom_taxonomy_teams-url" />
	<p>' . __( 'Website of the team, starting with http:// or https://' ) . '</p>
	</div>';

	// Home field address
	echo '<div class="form-field">
	<label for="custom_taxonomy_teams-homefield_address">' . __( 'Home field address' ) . '</label>
	<input type="text" name="custom_taxonomy_teams-homefield_address" id="custom_taxonomy_teams-homefield_address" />
	<p>' . __( 'Full address of home field, including: street, number, ZIP and city' ) . '</p>
	</div>';

	// Image
	?>
	<div class="form-field">

		<label for="custom_taxonomy_teams_image_id"><?php _e( 'Image' ); ?></label>
		<input type="hidden" id="custom_taxonomy_teams_image_id" name="custom_taxonomy_teams_image_id"
		       class="custom_media_url"
		       value="">

		<div id="image_wrapper"></div>

		<p>
			<input type="button" class="button button-secondary" id="taxonomy_media_add"
			       name="taxonomy_media_add" value="<?php _e( 'Add Image' ); ?>">
			<input type="button" class="button button-secondary hidden" id="taxonomy_media_remove"
			       name="taxonomy_media_remove" value="<?php _e( 'Remove Image' ); ?>">
		</p>

	</div>
	<?php
}

add_action( 'teams_edit_form_fields', 'custom_taxonomy_teams_edit_term_fields' );
function custom_taxonomy_teams_edit_term_fields( $term )
{

	$value_url = get_term_meta( $term->term_id, 'custom_taxonomy_teams-url', true );
	echo '<tr class="form-field">
	<th>
		<label for="custom_taxonomy_teams-url">' . __( 'URL' ) . '</label>
	</th>
	<td>
		<input name="custom_taxonomy_teams-url" id="custom_taxonomy_teams-url" type="url" title="' .
		__( 'Full URL starting with http:// or https://' ) . '" value="' .
		esc_url_raw( $value_url, array ( 'http', 'https' ) ) . '" />
		<p class="description">' . __( 'Website of the team, starting with http:// or https://' ) . '</p>
	</td>
	</tr>';

	$value_homefield_address = get_term_meta( $term->term_id, 'custom_taxonomy_teams-homefield_address', true );
	echo '<tr class="form-field">
	<th>
		<label for="custom_taxonomy_teams-homefield_address">' . __( 'Home field address' ) . '</label>
	</th>
	<td>
		<input name="custom_taxonomy_teams-homefield_address" id="custom_taxonomy_teams-homefield_address" type="text" title="' .
		__( 'Full address of home field, including: street, number, ZIP and city' ) . '" value="' .
		esc_attr( $value_homefield_address ) . '" />
		<p class="description">' . __( 'Full address of home field, including: street, number, ZIP and city' ) . '</p>
	</td>
	</tr>';

	?>
	<tr class="form-field">
		<th scope="row">
			<label for="custom_taxonomy_teams_image_id"><?php _e( 'Image' ); ?></label>
		</th>
		<td>

			<?php
			// The image basically is just an input for the image (attachment) id.
			$custom_taxonomy_teams_image_id = get_term_meta( $term->term_id, 'custom_taxonomy_teams_image_id', true );
			?>
			<input type="hidden" id="custom_taxonomy_teams_image_id" name="custom_taxonomy_teams_image_id" value="<?php
			echo
			$custom_taxonomy_teams_image_id; ?>">

			<div id="image_wrapper">
				<?php if ( $custom_taxonomy_teams_image_id ) { ?>
					<?php echo wp_get_attachment_image( $custom_taxonomy_teams_image_id ); ?>
				<?php } ?>
			</div>

			<p>
				<input type="button"
				       class="button button-secondary<?php echo ( $custom_taxonomy_teams_image_id ) ? " hidden" : "" ?>"
				       id="taxonomy_media_add"
				       name="taxonomy_media_add" value="<?php _e( 'Add Image' ); ?>">
				<input type="button"
				       class="button button-secondary<?php echo ( $custom_taxonomy_teams_image_id ) ? "" : " hidden" ?>"
				       id="taxonomy_media_remove"
				       name="taxonomy_media_remove" value="<?php _e( 'Remove Image' ); ?>">
			</p>

		</td>
	</tr>
	<?php
}


add_action( 'created_teams', 'custom_taxonomy_teams_save_term_fields' );
add_action( 'edited_teams', 'custom_taxonomy_teams_save_term_fields' );
function custom_taxonomy_teams_save_term_fields( $term_id )
{

	update_term_meta(
		$term_id,
		'custom_taxonomy_teams-url',
		sanitize_text_field( $_POST[ 'custom_taxonomy_teams-url' ] )
	);

	update_term_meta(
		$term_id,
		'custom_taxonomy_teams-homefield_address',
		sanitize_text_field( $_POST[ 'custom_taxonomy_teams-homefield_address' ] )
	);

}

add_action( 'created_teams', 'custom_taxonomy_teams_save_term_images' );
function custom_taxonomy_teams_save_term_images( $term_id )
{
	if ( isset( $_POST[ 'custom_taxonomy_teams_image_id' ] ) && '' !== $_POST[ 'custom_taxonomy_teams_image_id' ] ) {
		add_term_meta(
			$term_id,
			'teams_custom_taxonomy_teams_image_id',
			$_POST[ 'custom_taxonomy_teams_image_id' ],
			true
		);
	}
}


add_action( 'edited_teams', 'custom_taxonomy_teams_update_term_images' );
function custom_taxonomy_teams_update_term_images( $term_id )
{
	if ( isset( $_POST[ 'custom_taxonomy_teams_image_id' ] ) && '' !== $_POST[ 'custom_taxonomy_teams_image_id' ] ) {
		$image = $_POST[ 'custom_taxonomy_teams_image_id' ];
		update_term_meta( $term_id, 'custom_taxonomy_teams_image_id', $image );
	} else {
		// TODO: make this nicer/cleaner, maybe just unset/remove the meta value?
		update_term_meta( $term_id, 'custom_taxonomy_teams_image_id', '' );
	}
}

add_action( 'admin_enqueue_scripts', 'load_media' );
function load_media()
{
	wp_enqueue_media();
}

add_action( 'admin_footer', 'add_custom_script' );
function add_custom_script()
{
	?>
	<script>
		jQuery(function ($) {
			let mediaFrame;
			const buttonAdd = $("#taxonomy_media_add"),
				buttonRemove = $("#taxonomy_media_remove"),
				imageWrapper = $("#image_wrapper"),
				imageInput = $("#custom_taxonomy_teams_image_id");

			buttonAdd.on("click", (e) => {
				e.preventDefault();

				if (mediaFrame) {
					mediaFrame.open();
					return;
				}

				// Prepare the popup.
				mediaFrame = wp.media({
					title: 'Select team logo',
					button: {
						text: 'Use this logo'
					},
					multiple: false
				});

				// Handle the selection of an image (show preview, hide button).
				mediaFrame.on("select", () => {
					const attachment = mediaFrame.state().get('selection').first().toJSON();
					imageWrapper.html(`<img src="${attachment.url}" alt="" style="max-width: 100px;" />`);
					imageInput.val(attachment.id);
					buttonAdd.addClass("hidden");
					buttonRemove.removeClass("hidden");
				})

				mediaFrame.open();
			});

			// Handle deleting the current image.
			buttonRemove.on("click", (e) => {
				e.preventDefault();

				imageWrapper.html('');
				imageInput.val('');
				buttonAdd.removeClass("hidden");
				buttonRemove.addClass("hidden");
			});
		});
	</script>
	<?php
}