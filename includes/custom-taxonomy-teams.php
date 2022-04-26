<?php

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

	// Image
	?>
	<div class="form-field term-group">

		<label for="image_id"><?php _e( 'Image' ); ?></label>
		<input type="hidden" id="image_id" name="image_id" class="custom_media_url" value="">

		<div id="image_wrapper"></div>

		<p>
			<input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button"
			       name="taxonomy_media_button" value="<?php _e( 'Add Image' ); ?>">
			<input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove"
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

	?>
	<tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="image_id"><?php _e( 'Image' ); ?></label>
		</th>
		<td>

			<?php $image_id = get_term_meta( $term->term_id, 'image_id', true ); ?>
			<input type="hidden" id="image_id" name="image_id" value="<?php echo $image_id; ?>">

			<div id="image_wrapper">
				<?php if ( $image_id ) { ?>
					<?php echo wp_get_attachment_image( $image_id ); ?>
				<?php } ?>
			</div>

			<p>
				<input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button"
				       name="taxonomy_media_button" value="<?php _e( 'Add Image' ); ?>">
				<input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove"
				       name="taxonomy_media_remove" value="<?php _e( 'Remove Image' ); ?>">
			</p>

			</div></td>
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

}

add_action( 'created_teams', 'custom_taxonomy_teams_save_term_images' );
function custom_taxonomy_teams_save_term_images( $term_id )
{
	if ( isset( $_POST[ 'image_id' ] ) && '' !== $_POST[ 'image_id' ] ) {
		add_term_meta( $term_id, 'teams_image_id', $_POST[ 'image_id' ], true );
	}
}


add_action( 'edited_teams', 'custom_taxonomy_teams_update_term_images' );
function custom_taxonomy_teams_update_term_images( $term_id )
{
	if ( isset( $_POST[ 'image_id' ] ) && '' !== $_POST[ 'image_id' ] ) {
		$image = $_POST[ 'image_id' ];
		update_term_meta( $term_id, 'image_id', $image );
	} else {
		// TODO: make this nicer/cleaner, maybe just unset/remove the meta value?
		update_term_meta( $term_id, 'image_id', '' );
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
	<script>jQuery(document).ready(function ($) {
			function taxonomy_media_upload(button_class) {
				let custom_media = true,
					original_attachment = wp.media.editor.send.attachment;
				$('body').on('click', button_class, function (e) {
					const button_id = '#' + $(this).attr('id');
					const button = $(button_id);
					custom_media = true;
					wp.media.editor.send.attachment = function (props, attachment) {
						if (custom_media) {
							$('#image_id').val(attachment.id);
							$('#image_wrapper').html('<img alt="" class="custom_media_image" src="" style="margin:0;' +
								'padding:0;max-height:100px;float:none;" />');
							$('#image_wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
						} else {
							return original_attachment.apply(button_id, [props, attachment]);
						}
					}
					wp.media.editor.open(button);
					return false;
				});
			}

			taxonomy_media_upload('.taxonomy_media_button.button');
			$('body').on('click', '.taxonomy_media_remove', function () {
				$('#image_id').val('');
				$('#image_wrapper').html('<img alt="" class="custom_media_image" src="" style="margin:0;padding:0;' +
					'max-height:100px;float:none;" />');
			});

			$(document).ajaxComplete(function (event, xhr, settings) {
				const queryStringArr = settings.data.split('&');
				let $response;
				if ($.inArray('action=add-tag', queryStringArr) !== -1) {
					const xml = xhr.responseXML;
					$response = $(xml).find('term_id').text();
					if ($response !== "") {
						$('#image_wrapper').html('');
					}
				}
			});
		});</script> <?php
}