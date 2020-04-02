<?php
	/**
	 * Create the metabox
	 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
	function _wpp_redirect_create_metabox() {

		add_meta_box(
			'_wpp_redirect_metabox', // Metabox ID
			'Redirect Options', // Title to display
			'_wpp_redirect_render_metabox', // Function to call that contains the metabox content
			'whatsapp-redirect', // Post type to display metabox on
			'normal', // Where to put it (normal = main colum, side = sidebar, etc.)
			'default' // Priority relative to other metaboxes
		);

	}
	add_action( 'add_meta_boxes', '_wpp_redirect_create_metabox' );
	function _wpp_redirect_render_metabox() {
		// Variables
		global $post; // Get the current post data
		$phone = get_post_meta( $post->ID, '_wpp_phone', true ); // Get the saved values
		$mensagem = get_post_meta( $post->ID, '_wpp_message', true ); // Get the saved values
		echo '<style>';
		include('assets/style.css');
		echo '</style>'
		?>

			<fieldset class="wpp_metabox">
				<div>
					<label for="_wpp_phone">
						Phone Number
					</label>
					<?php
						// The `esc_attr()` function here escapes the data for
						// HTML attribute use to avoid unexpected issues
					?>
					<input
						type="text"
						name="_wpp_phone_"
						id="_wpp_phone_"
						value="<?php echo esc_attr( $phone ); ?>"
					>
					<input
						type="hidden"
						name="_wpp_phone"
						id="_wpp_phone">
				</div>
				<div>
					<label for="_wpp_message">
						Message
					</label>
					<?php
						// The `esc_attr()` function here escapes the data for
						// HTML attribute use to avoid unexpected issues
					?>
					<input
						type="text"
						name="_wpp_message"
						id="_wpp_message"
						value="<?php echo esc_attr( $mensagem ); ?>"
					>
				</div>
			</fieldset>
		<?php
		// Security field
		// This validates that submission came from the
		// actual dashboard and not the front end or
		// a remote server.
		wp_nonce_field( '_wpp_redirect_metabox_nonce', '_wpp_redirect_metabox_process' );
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.2/js/intlTelInput.min.js" integrity="sha256-cGq+80NU2ep5WeTYdcesx4VxGraSCoKg/SdrPKSGG5Q=" crossorigin="anonymous"></script>
		<script>';
		include('assets/main.js');
		echo '</script>';
	}
	//
	// Save our data
	//
	function _namespace_save_metabox( $post_id, $post ) {
		// Verify that our security field exists. If not, bail.
		if ( !isset( $_POST['_wpp_redirect_metabox_process'] ) ) return;
		// Verify data came from edit/dashboard screen
		if ( !wp_verify_nonce( $_POST['_wpp_redirect_metabox_process'], '_wpp_redirect_metabox_nonce' ) ) {
			return $post->ID;
		}
		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}
		// Check that our custom fields are being passed along
		// This is the `name` value array. We can grab all
		// of the fields and their values at once.
		if ( !isset( $_POST['_wpp_phone'] ) ) {
			return $post->ID;
		}
		/**
		 * Sanitize the submitted data
		 * This keeps malicious code out of our database.
		 * `wp_filter_post_kses` strips our dangerous server values
		 * and allows through anything you can include a post.
		 */
		$sanitized_phone = wp_filter_post_kses( $_POST['_wpp_phone'] );
		$sanitized_mensagem = wp_filter_post_kses( $_POST['_wpp_message'] );
		// Save our submissions to the database
		update_post_meta( $post->ID, '_wpp_phone', $sanitized_phone );
		update_post_meta( $post->ID, '_wpp_message', $sanitized_mensagem );
	}
	add_action( 'save_post', '_namespace_save_metabox', 1, 2 );
