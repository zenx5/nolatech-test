<?php


class ApiLogForm {

    public static function activation() {
        update_option('count_logs', 0);
        update_option('logs', '[]');
        update_option('log_form_name','');
    }

    public static function deactivation() {

    }

    public static function uninstall() {

    }

    public static function init() {
        add_action( 'rest_api_init', [__CLASS__, 'add_endpoints']);
        add_action( 'admin_menu', [__CLASS__, 'admin_menu']);
        add_action( 'wp_ajax_save_log_form', [__CLASS__,'save_log_form']);
        add_action( 'elementor_pro/forms/new_record', [__CLASS__, 'new_record'],10,2);
    }

    public static function save_log_form() {
        if( isset( $_POST['log_form_name'] ) ) {
            update_option( 'log_form_name', $_POST['log_form_name']);
        }
    }

    public static function admin_menu() {
        add_menu_page(
            null,
            'form settings',
            'manage_options',
            'log-form',
            'render_form',
            null,
            5
        );

        function render_form() {
            include_once WP_PLUGIN_DIR.'/api-log-form/templates/form.php';
        }
    }

    public static function new_record($record, $handler ) {
        try {
            $form_name = $record->get_form_settings( 'form_name' );
            if ( get_option('log_form_name','') !== $form_name ) {
                return;
            }

            $raw_fields = $record->get( 'fields' );
            $fields = [];
            foreach ( $raw_fields as $id => $field ) {
                $fields[ $id ] = $field['value'];
            }
            self::set_log($fields);
        } catch( Exception $error ) {
            echo $error->getMessage();
            return false;
        }
    }

    public static function add_endpoints(){
        register_rest_route("nolatech/v1", 'logs', array(
            'methods' => 'get',
            'permission_callback' => '__return_true',
            'callback' => [__CLASS__, 'get_logs']
        ));
        register_rest_route("nolatech/v1", 'logs', array(
            'methods' => 'post',
            'permission_callback' => '__return_true',
            'callback' => [__CLASS__, 'set_log']
        ));
    }

    public static function get_logs() {
        return json_decode( get_option('logs', '[]') );
    }

    public static function set_log($data = null) {
        try {
            if( !$data ) {
                $data = [
                    "name" => $_POST['name'],
                    "surname" => $_POST['surname'],
                    "phone" => $_POST['phone'],
                    "email" => $_POST['email'],
                    "departament" => $_POST['departament'],
                    "message" => $_POST['message']
                ];
            }
            $logs = json_decode( get_option('logs', '[]') );
            $count = json_decode( get_option('count_logs', 0) );
            $logs[] = $data;
            update_option('logs', json_encode( $logs ) );
            update_option('count_logs', $count + 1 );
            return true;
        } catch( Exception $error ) {
            echo $error->getMessage();
            return false;
        }
        
    }

}