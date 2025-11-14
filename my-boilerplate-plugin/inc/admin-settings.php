<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}

function mbp_register_settings() {
    register_setting( 'mbp_options_group', 'mbp_settings', 'mbp_sanitize_settings' );
    add_settings_section( 'mbp_main_section', 'My Boilerplate Settings', 'mbp_section_cb', 'mbp-settings' );
    add_settings_field( 'mbp_load_frontend', 'Load frontend assets?', 'mbp_field_load_frontend_cb', 'mbp-settings', 'mbp_main_section' );
}
add_action( 'admin_init', 'mbp_register_settings' );

function mbp_section_cb() {
    echo '<p>Enable or disable frontend assets for testing.</p>';
}

function mbp_field_load_frontend_cb() {
    $opts = get_option( 'mbp_settings', array( 'load_frontend' => '1' ) );
    $value = isset( $opts['load_frontend'] ) ? $opts['load_frontend'] : '0';
    ?>
    <label>
        <input type="checkbox" name="mbp_settings[load_frontend]" value="1" <?php checked( 1, $value ); ?> />
        Enable frontend CSS & JS
    </label>
    <?php
}

function mbp_sanitize_settings( $input ) {
    $output = array();
    $output['load_frontend'] = isset( $input['load_frontend'] ) && $input['load_frontend'] === '1' ? '1' : '0';
    return $output;
}

function mbp_add_settings_page() {
    add_options_page(
        'My Boilerplate',
        'My Boilerplate',
        'manage_options',
        'mbp-settings',
        'mbp_settings_page_html'
    );
}
add_action( 'admin_menu', 'mbp_add_settings_page' );

function mbp_settings_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>My Boilerplate Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'mbp_options_group' );
            do_settings_sections( 'mbp-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
