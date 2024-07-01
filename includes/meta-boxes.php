<?php
add_action( 'add_meta_boxes', 'db_add_meta_boxes' );
add_action( 'save_post', 'db_save_meta_box_data' );

function db_add_meta_boxes() {
	add_meta_box(
		'db_meta_box',
		'Design Badge',
		'db_meta_box_html',
		'page'
	);
}

function db_meta_box_html( $post ) {
	if ( is_admin() && $post && $post->post_type === 'page' ) {
		wp_nonce_field( 'db_save_meta_box_data', 'db_meta_box_nonce' );

		// Design Link
		$design_link = get_post_meta( $post->ID, '_db_meta_key_design_link', true );
		echo '<div class="db-meta-box-design-link">';
		echo '<label for="db_meta_design_link">Design Link:</label>';
		echo '<input type="text" id="db_meta_design_link" name="db_meta_design_link" value="' . esc_attr( $design_link ) . '" />';
		echo '</div>';

		// Display Badge
		$display_badge = get_post_meta( $post->ID, '_db_meta_key_display_badge', true );
		$checked = $display_badge ? 'checked' : '';

		echo '<div class="db-meta-box-display-badge">';
		echo '<label for="db_meta_display_badge">Display Badge:</label>';
		echo '<div class="db-meta-box-display-badge-input">';
		echo '<input type="radio" id="db_meta_display_badge" name="db_meta_display_badge" value="1" ' . $checked . '> Yes';
		echo '<input type="radio" id="db_meta_display_badge" name="db_meta_display_badge" value="0" ' . ( ! $checked ? 'checked' : '' ) . '> No';
		echo '</div>';
		echo '</div>';
	}
}

function db_save_meta_box_data( $post_id ) {
	// Check nonce.
	if ( ! isset( $_POST['db_meta_box_nonce'] ) ) {
		return;
	}

	$nonce = $_POST['db_meta_box_nonce'];

	// Verify nonce.
	if ( ! wp_verify_nonce( $nonce, 'db_save_meta_box_data' ) ) {
		return;
	}

	// Check autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Sanitize input.
	if ( isset( $_POST['db_meta_design_link'] ) ) {
		$meta_value_design_link = sanitize_text_field( $_POST['db_meta_design_link'] );
		update_post_meta( $post_id, '_db_meta_key_design_link', $meta_value_design_link );
	}

	if ( isset( $_POST['db_meta_display_badge'] ) ) {
		$meta_value_display_badge = sanitize_text_field( $_POST['db_meta_display_badge'] );
		update_post_meta( $post_id, '_db_meta_key_display_badge', $meta_value_display_badge );
	}
}