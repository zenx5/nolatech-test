<?php


class ApiLogForm {

    public static function activation() {
        update_option('count_logs', 0);
        update_option('logs', '[]');
    }

    public static function deactivation() {

    }

    public static function uninstall() {

    }

    public static function init() {
        add_action( 'rest_api_init', [__CLASS__, 'add_endpoints']);
        add_action( 'elementor_pro/forms/new_record', [__CLASS__, 'new_record'],10,2);
    }

    public static function new_record($record, $handler ) {
        try {
            $form_name = $record->get_form_settings( 'form_name' );
            if ( 'new_log' !== $form_name ) {
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
        $logs = json_decode( get_option('logs', '[]') );
        return [
            "host" => get_site_url(),
            "data" => $logs
        ];
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