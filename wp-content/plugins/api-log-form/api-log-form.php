<?php
/**
 * Plugin Name: Api Log Form
 * Plugin URI: https://zenx5.pro
 * Description: ...
 * Version: 1.0.0
 * Author: Octavio Martinez
 * Author URI: https://zenx5.pro
 * Domain Path: /i18n/languages/
 *
 */

 require_once 'classes/class-api-log-form.php';
 $nameclass = 'ApiLogForm';


 register_activation_hook(__FILE__, [$nameclass, 'activation']);
 register_deactivation_hook(__FILE__, [$nameclass, 'deactivation']);
 register_uninstall_hook(__FILE__, [$nameclass, 'uninstall']);

 add_action('init', [$nameclass, 'init']);