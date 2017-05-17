<?php
/**
 * Created by PhpStorm.
 * User: mtbsoft
 * Date: 15/04/2017
 * Time: 10:44
 */

// Add scripts and stylesheets
function startwordpress_scripts() {
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() .
        '/css/bootstrap.min.css', array(), '3.3.6' );
    wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css'
    );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() .
        '/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
}

add_action( 'wp_enqueue_scripts', 'startwordpress_scripts' );

// Add Google Fonts
function startwordpress_google_fonts() {
    wp_register_style('OpenSans',
        'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');
    wp_enqueue_style( 'OpenSans');
}
add_action('wp_print_styles', 'startwordpress_google_fonts');

// WordPress Titles
add_theme_support( 'title-tag' );

// Custom settings
function custom_settings_add_menu() {
    add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options',
        'custom-settings', 'custom_settings_page', null, 99 );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );

// Create Custom Global Settings
function custom_settings_page() { ?>
    <div class="wrap">
        <h1>Custom Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'section' );
            do_settings_sections( 'theme-options' );
            submit_button(); ?>
        </form>
    </div>
<?php }

// Twitter
function setting_twitter() { ?>
    <input type="text" name="twitter" id="twitter" value="<?php echo
    get_option( 'twitter' ); ?>" />
<?php }

// Facebook
function setting_facebook() { ?>
    <input type="text" name="facebook" id="facebook" value="<?php echo
    get_option( 'facebook' ); ?>" />
<?php }

function custom_settings_page_setup() {
    add_settings_section( 'section', 'All Settings', null, 'theme-options' );
    add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options',
        'section' );
    add_settings_field( 'facebook', 'facebook URL', 'setting_facebook', 'theme-options',
        'section' );
    register_setting('section', 'twitter');
    register_setting('section', 'facebook');
}
add_action( 'admin_init', 'custom_settings_page_setup' );

function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>

	<p>
		<label for="meta-Etat" class="prfx-row-title"><?php _e( 'Etat', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-Etat" id="meta-Etat" value="<?php if ( isset ( $prfx_stored_meta['meta-Etat'] ) ) echo $prfx_stored_meta['meta-Etat'][0]; ?>" />
			<br>
		<label for="meta-dateE" class="prfx-row-title"><?php _e( 'Date de la réclamation', 'prfx-textdomain' )?></label>
		<input  type="text" name="meta-dateE" id="meta-dateE" value="<?php if ( isset ( $prfx_stored_meta['meta-dateE'] ) ) echo $prfx_stored_meta['meta-dateE'][0]; ?>" />
         <br>	
	<label for="meta-Agent" class="prfx-row-title"><?php _e( 'Agent responsable', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-Agent" id="meta-Agent" value="<?php if ( isset ( $prfx_stored_meta['meta-Agent'] ) ) echo $prfx_stored_meta['meta-Agent'][0]; ?>" />
			<br>
			<label for="meta-date" class="prfx-row-title"><?php _e( 'Date de l’intervention', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-date" id="meta-date" value="<?php if ( isset ( $prfx_stored_meta['meta-date'] ) ) echo $prfx_stored_meta['meta-date'][0]; ?>" />
			<br>
	</p>
	

	<?php
}
function prfx_meta_save( $post_id ) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'meta-Etat' ] )||isset( $_POST[ 'meta-dateE' ]) ||isset( $_POST[ 'meta-Agent' ]) ||isset( $_POST[ 'meta-date' ]  ) ) {
		update_post_meta( $post_id, 'meta-Etat', sanitize_text_field( $_POST[ 'meta-Etat' ] ) );
		update_post_meta( $post_id, 'meta-dateE', sanitize_text_field( $_POST[ 'meta-dateE' ] ) );
		update_post_meta( $post_id, 'meta-Agent', sanitize_text_field( $_POST[ 'meta-Agent' ] ) );
		update_post_meta( $post_id, 'meta-date', sanitize_text_field( $_POST[ 'meta-date' ] ) );
	}
}
add_action( 'save_post', 'prfx_meta_save' );
function prfx_custom_meta() {
	add_meta_box( 'prfx_meta', __( 'Enseignant et Nombre D\'absence', 'prfx-textdomain' ), 'prfx_meta_callback', 'post' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );