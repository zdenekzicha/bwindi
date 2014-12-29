<?php
/*
Plugin Name: Sucuri Security - Auditing, Malware Scanner and Hardening
Plugin URI: http://wordpress.sucuri.net/
Description: The <a href="http://sucuri.net/" target="_blank">Sucuri</a> plugin provides the website owner the best Activity Auditing, SiteCheck Remote Malware Scanning, Effective Security Hardening and Post-Hack features. SiteCheck will check for malware, spam, blacklisting and other security issues like .htaccess redirects, hidden eval code, etc. The best thing about it is it's completely free.
Author: Sucuri, INC
Version: 1.7.5
Author URI: http://sucuri.net
*/


/**
 * Main file to control the plugin.
 *
 * @package   Sucuri Security
 * @author    Yorman Arias <yorman.arias@sucuri.net>
 * @author    Daniel Cid   <dcid@sucuri.net>
 * @copyright Since 2010-2014 Sucuri Inc.
 * @license   Released under the GPL - see LICENSE file for details.
 * @link      https://wordpress.sucuri.net/
 * @since     File available since Release 0.1
 */


/**
 * Plugin dependencies.
 *
 * List of required functions for the execution of this plugin, we are assuming
 * that this site was built on top of the WordPress project, and that it is
 * being loaded through a pluggable system, these functions most be defined
 * before to continue.
 *
 * @var array
 */
$sucuriscan_dependencies = array(
    'wp',
    'wp_die',
    'add_action',
    'remove_action',
    'wp_remote_get',
    'wp_remote_post',
);

// Terminate execution if any of the functions mentioned above is not defined.
foreach( $sucuriscan_dependencies as $dependency ){
    if( !function_exists($dependency) ){
        exit(0);
    }
}

/**
 * Plugin's constants.
 *
 * These constants will hold the basic information of the plugin, file/folder
 * paths, version numbers, read-only variables that will affect the functioning
 * of the rest of the code. The conditional will act as a container helping in
 * the readability of the code considering the total number of lines that this
 * file will have.
 */

/**
 * Unique name of the plugin through out all the code.
 */
define('SUCURISCAN', 'sucuriscan');

/**
 * Current version of the plugin's code.
 */
define('SUCURISCAN_VERSION', '1.7.5');

/**
 * The name of the Sucuri plugin main file.
 */
define('SUCURISCAN_PLUGIN_FILE', 'sucuri.php');

/**
 * The name of the folder where the plugin's files will be located.
 */
define('SUCURISCAN_PLUGIN_FOLDER', 'sucuri-scanner');

/**
 * The fullpath where the plugin's files will be located.
 */
define('SUCURISCAN_PLUGIN_PATH', WP_PLUGIN_DIR.'/'.SUCURISCAN_PLUGIN_FOLDER);

/**
 * The fullpath of the main plugin file.
 */
define('SUCURISCAN_PLUGIN_FILEPATH', SUCURISCAN_PLUGIN_PATH.'/'.SUCURISCAN_PLUGIN_FILE);

/**
 * The local URL where the plugin's files and assets are served.
 */
define('SUCURISCAN_URL', rtrim(plugin_dir_url(SUCURISCAN_PLUGIN_FILEPATH), '/') );

/**
 * Checksum of this file to check the integrity of the plugin.
 */
define('SUCURISCAN_PLUGIN_CHECKSUM', @md5_file(SUCURISCAN_PLUGIN_FILEPATH));

/**
 * Remote URL where the public Sucuri API service is running.
 */
define('SUCURISCAN_API', 'https://wordpress.sucuri.net/api/');

/**
 * Latest version of the public Sucuri API.
 */
define('SUCURISCAN_API_VERSION', 'v1');

/**
 * Remote URL where the CloudProxy API service is running.
 */
define('SUCURISCAN_CLOUDPROXY_API', 'https://waf.sucuri.net/api');

/**
 * Latest version of the CloudProxy API.
 */
define('SUCURISCAN_CLOUDPROXY_API_VERSION', 'v2');

/**
 * The maximum quantity of entries that will be displayed in the last login page.
 */
define('SUCURISCAN_LASTLOGINS_USERSLIMIT', 25);

/**
 * The maximum quantity of entries that will be displayed in the audit logs page.
 */
define('SUCURISCAN_AUDITLOGS_PER_PAGE', 50);

/**
 * The maximum quantity of buttons in the paginations.
 */
define('SUCURISCAN_MAX_PAGINATION_BUTTONS', 20);

/**
 * The minimum quantity of seconds to wait before each filesystem scan.
 */
define('SUCURISCAN_MINIMUM_RUNTIME', 10800);

/**
 * The life time of the cache for the results of the SiteCheck scans.
 */
define('SUCURISCAN_SITECHECK_LIFETIME', 1200);

/**
 * The life time of the cache for the results of the get_plugins function.
 */
define('SUCURISCAN_GET_PLUGINS_LIFETIME', 1800);

/**
 * Plugin's global variables.
 *
 * These variables will be defined globally to allow the inclusion in multiple
 * functions and classes defined in the libraries loaded by this plugin. The
 * conditional will act as a container helping in the readability of the code
 * considering the total number of lines that this file will have.
 */
if( defined('SUCURISCAN') ){

    /**
     * List an associative array with the sub-pages of this plugin.
     *
     * @return array
     */
    $sucuriscan_pages = array(
        'sucuriscan' => 'Dashboard',
        'sucuriscan_scanner' => 'Malware Scan',
        'sucuriscan_monitoring' => 'Firewall (WAF)',
        'sucuriscan_hardening' => 'Hardening',
        'sucuriscan_posthack' => 'Post-Hack',
        'sucuriscan_lastlogins' => 'Last Logins',
        'sucuriscan_settings' => 'Settings',
        'sucuriscan_infosys' => 'Site Info',
    );

    /**
     * Settings options.
     *
     * The following global variables are mostly associative arrays where the key is
     * linked to an option that will be stored in the database, and their
     * correspondent values are the description of the option. These variables will
     * be used in the settings page to offer the user a way to configure the
     * behaviour of the plugin.
     *
     * @var array
     */

    $sucuriscan_notify_options = array(
        'sucuriscan_prettify_mails' => 'Enable email alerts in HTML <em>(uncheck to get email in plain text format)</em>',
        'sucuriscan_lastlogin_redirection' => 'Allow redirection after login to report the last-login information',
        'sucuriscan_notify_user_registration' => 'Enable email alerts for new user registration',
        'sucuriscan_notify_success_login' => 'Enable email alerts for successful logins',
        'sucuriscan_notify_failed_login' => 'Enable email alerts for failed logins',
        'sucuriscan_notify_bruteforce_attack' => 'Enable email alerts for login brute-force attack',
        'sucuriscan_notify_post_publication' => 'Enable email alerts for new site content',
        'sucuriscan_notify_theme_editor' => 'Enable email alerts when a file is modified via the theme/plugin editor',
        'sucuriscan_notify_website_updated' => 'Enable email alerts when your website is updated',
        'sucuriscan_notify_settings_updated' => 'Enable email alerts when your website settings are updated',
        'sucuriscan_notify_theme_switched' => 'Enable email alerts when the website theme is switched',
        'sucuriscan_notify_theme_updated' => 'Enable email alerts when a theme is updated',
        'sucuriscan_notify_widget_added' => 'Enable email alerts when a widget is added to a sidebar',
        'sucuriscan_notify_widget_deleted' => 'Enable email alerts when a widget is deleted from a sidebar',
        'sucuriscan_notify_plugin_change' => 'Enable email alerts for Sucuri plugin changes',
        'sucuriscan_notify_plugin_activated' => 'Enable email alerts when a plugin is activated',
        'sucuriscan_notify_plugin_deactivated' => 'Enable email alerts when a plugin is deactivated',
        'sucuriscan_notify_plugin_updated' => 'Enable email alerts when a plugin is updated',
        'sucuriscan_notify_plugin_installed' => 'Enable email alerts when a plugin is installed',
        'sucuriscan_notify_plugin_deleted' => 'Enable email alerts when a plugin is deleted',
    );

    $sucuriscan_schedule_allowed = array(
        'hourly' => 'Every three hours (3 hours)',
        'twicedaily' => 'Twice daily (12 hours)',
        'daily' => 'Once daily (24 hours)',
        '_oneoff' => 'Never',
    );

    $sucuriscan_interface_allowed = array(
        'spl' => 'SPL (high performance)',
        'opendir' => 'OpenDir (medium)',
        'glob' => 'Glob (low)',
    );

    $sucuriscan_emails_per_hour = array(
        '5' => 'Maximum 5 per hour',
        '10' => 'Maximum 10 per hour',
        '20' => 'Maximum 20 per hour',
        '40' => 'Maximum 40 per hour',
        '80' => 'Maximum 80 per hour',
        '160' => 'Maximum 160 per hour',
        'unlimited' => 'Unlimited',
    );

    $sucuriscan_maximum_failed_logins = array(
        '30' => '30 failed logins per hour',
        '60' => '60 failed logins per hour',
        '120' => '120 failed logins per hour',
        '240' => '240 failed logins per hour',
        '480' => '480 failed logins per hour',
    );

    $sucuriscan_verify_ssl_cert = array(
        'true' => 'Verify peer\'s cert',
        'false' => 'Stop peer\'s cert verification',
    );

    $sucuriscan_no_notices_in = array(
    );

    $sucuriscan_email_subjects = array(
        'Sucuri Alert, :domain, :event',
        'Sucuri Alert, :domain, :event, :remoteaddr',
        'Sucuri Alert, :event, :remoteaddr',
        'Sucuri Alert, :event',
    );

    /**
     * Remove the WordPress generator meta-tag from the source code.
     */
    remove_action( 'wp_head', 'wp_generator' );

    /**
     * Run a specific function defined in the plugin's code to locate every
     * directory and file, collect their checksum and file size, and send this
     * information to the Sucuri API service where a security and integrity scan
     * will be performed against the hashes provided and the official versions.
     */
    add_action('sucuriscan_scheduled_scan', 'SucuriScanEvent::filesystem_scan');

    /**
     * Initialize the execute of the main plugin's functions.
     *
     * This will load the menu options in the WordPress administrator panel, and
     * execute the bootstrap function of the plugin.
     */
    add_action( 'init', 'SucuriScanInterface::initialize', 1 );
    add_action( 'admin_init', 'SucuriScanInterface::create_datastore_folder' );
    add_action( 'admin_init', 'SucuriScanInterface::handle_old_plugins' );
    add_action( 'admin_enqueue_scripts', 'SucuriScanInterface::enqueue_scripts', 1 );
    add_action( 'admin_menu', 'SucuriScanInterface::add_interface_menu' );

    /**
     * Function call interceptors.
     *
     * Define the names for the hooks that will intercept specific function calls in
     * the admin interface and parts of the external site, an event report will be
     * sent to the API service and an email notification to the administrator of the
     * site.
     *
     * @see Class SucuriScanHook
     */
    if( class_exists('SucuriScanHook') ){
        $sucuriscan_hooks = array(
            // Passes.
            'add_attachment',
            'add_link',
            'create_category',
            'delete_post',
            'delete_user',
            'login_form_resetpass',
            'private_to_published',
            'publish_page',
            'publish_post',
            'publish_phone',
            'xmlrpc_publish_post',
            'retrieve_password',
            'switch_theme',
            'user_register',
            'wp_login',
            'wp_login_failed',
        );

        foreach( $sucuriscan_hooks as $hook_name ){
            $hook_func = 'SucuriScanHook::hook_' . $hook_name;
            add_action( $hook_name, $hook_func, 50 );
        }

        add_action( 'admin_init', 'SucuriScanHook::hook_undefined_actions' );
        add_action( 'login_form', 'SucuriScanHook::hook_undefined_actions' );
    } else {
        SucuriScanInterface::error( 'Function call interceptors are not working properly.' );
    }

    /**
     * Display a message if the plugin is not activated.
     *
     * Display a message at the top of the administration panel with a button that
     * once clicked will send the site's email and domain name to the Sucuri API
     * service where an API key will be generated for the site, this key will allow
     * the plugin to execute the filesystem scans, the project integrity, and the
     * email notifications.
     */
    $sucuriscan_admin_notice_name = SucuriScan::is_multisite() ? 'network_admin_notices' : 'admin_notices';
    add_action( $sucuriscan_admin_notice_name, 'SucuriScanInterface::setup_notice' );

    /**
     * Heartbeat API
     *
     * Update the settings of the Heartbeat API according to the values set by an
     * administrator. This tool may cause an increase in the CPU usage, a bad
     * configuration may cause low account to run out of resources, but in better
     * cases it may improve the performance of the site by reducing the quantity of
     * requests sent to the server per session.
     */
    add_filter( 'init', 'SucuriScanHeartbeat::register_script', 1 );
    add_filter( 'heartbeat_settings', 'SucuriScanHeartbeat::update_settings' );
    add_filter( 'heartbeat_send', 'SucuriScanHeartbeat::respond_to_send', 10, 3 );
    add_filter( 'heartbeat_received', 'SucuriScanHeartbeat::respond_to_received', 10, 3 );
    add_filter( 'heartbeat_nopriv_send', 'SucuriScanHeartbeat::respond_to_send', 10, 3 );
    add_filter( 'heartbeat_nopriv_received', 'SucuriScanHeartbeat::respond_to_received', 10, 3 );

}

/**
 * Miscellaneous library.
 *
 * Multiple and generic functions that will be used through out the code of
 * other libraries extending from this and functions defined in other files, be
 * aware of the hierarchy and check the other libraries for duplicated methods.
 */
class SucuriScan {

    /**
     * Class constructor.
     */
    public function __construct(){
    }

    /**
     * Return name of a variable with the plugin's prefix (if needed).
     *
     * To facilitate the development, you can prefix the name of the key in the
     * request (when accessing it) with a single colon, this function will
     * automatically replace that character with the unique identifier of the
     * plugin.
     *
     * @param  string $var_name Name of a variable with an optional colon at the beginning.
     * @return string           Full name of the variable with the extra characters (if needed).
     */
    public static function variable_prefix( $var_name='' ){
        if( preg_match('/^:(.*)/', $var_name, $match) ){
            $var_name = sprintf( '%s_%s', SUCURISCAN, $match[1] );
        }

        return $var_name;
    }

    /**
     * Gets the value of a configuration option.
     *
     * @param  string $property The configuration option name.
     * @return string           Value of the configuration option as a string on success.
     */
    public static function ini_get( $property='' ){
        $ini_value = ini_get($property);

        if( empty($ini_value) || is_null($ini_value) ){
            switch( $property ){
                case 'error_log': $ini_value = 'error_log'; break;
                case 'safe_mode': $ini_value = 'Off'; break;
                case 'allow_url_fopen': $ini_value = '1'; break;
                case 'memory_limit': $ini_value = '128M'; break;
                case 'upload_max_filesize': $ini_value = '2M'; break;
                case 'post_max_size': $ini_value = '8M'; break;
                case 'max_execution_time': $ini_value = '30'; break;
                case 'max_input_time': $ini_value = '-1'; break;
            }
        }

        return $ini_value;
    }

    /**
     * Encodes the less-than, greater-than, ampersand, double quote and single quote
     * characters, will never double encode entities.
     *
     * @param  string $text The text which is to be encoded.
     * @return string       The encoded text with HTML entities.
     */
    public static function escape( $text='' ){
        // Escape the value of the variable using a built-in function if possible.
        if( function_exists('esc_attr') ){
            $text = esc_attr($text);
        } else {
            $text = htmlspecialchars($text);
        }

        return $text;
    }

    /**
     * Generates a lowercase random string with an specific length.
     *
     * @param  integer $length Length of the string that will be generated.
     * @return string          The random string generated.
     */
    public static function random_char( $length=4 ){
        $string = '';
        $chars = range('a','z');

        for( $i=0; $i<$length; $i++ ){
            $string .= $chars[ rand(0, count($chars)-1) ];
        }

        return $string;
    }

    /**
     * Translate a given number in bytes to a human readable file size using the
     * a approximate value in Kylo, Mega, Giga, etc.
     *
     * @link   http://www.php.net/manual/en/function.filesize.php#106569
     * @param  integer $bytes    An integer representing a file size in bytes.
     * @param  integer $decimals How many decimals should be returned after the translation.
     * @return string            Human readable representation of the given number in Kylo, Mega, Giga, etc.
     */
    public static function human_filesize( $bytes=0, $decimals=2 ){
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    /**
     * Returns the system filepath to the relevant user uploads directory for this
     * site. This is a multisite capable function.
     *
     * @param  string $path The relative path that needs to be completed to get the absolute path.
     * @return string       The full filesystem path including the directory specified.
     */
    public static function datastore_folder_path( $path='' ){
        $datastore_path = SucuriScanOption::get_option(':datastore_path');

        // Use the uploads folder by default.
        if ( empty($datastore_path) ) {
            if ( function_exists('wp_upload_dir') ) {
                $wp_dir_array = wp_upload_dir();
                $wp_dir_array['basedir'] = untrailingslashit($wp_dir_array['basedir']);
                $datastore_path = $wp_dir_array['basedir'] . '/sucuri';
            }

            else {
                $datastore_path = rtrim(ABSPATH, '/') . '/wp-content/uploads/sucuri';
            }

            SucuriScanOption::update_option( ':datastore_path', $datastore_path );
        }

        $wp_filepath = rtrim($datastore_path, '/') . '/' . $path;

        return $wp_filepath;
    }

    /**
     * Check whether the current site is working as a multi-site instance.
     *
     * @return boolean Either TRUE or FALSE in case WordPress is being used as a multi-site instance.
     */
    public static function is_multisite(){
        if(
            function_exists('is_multisite')
            && is_multisite()
        ){
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Find and retrieve the current version of Wordpress installed.
     *
     * @return string The version number of Wordpress installed.
     */
    public static function site_version(){
        // Maybe the version number is in the database.
        $version = get_option('version');
        if( $version ){ return $version; }

        // If not, then check for a specific file.
        $wp_version_path = ABSPATH . WPINC . '/version.php';
        if( file_exists($wp_version_path) ){
            include($wp_version_path);
            if( isset($wp_version) ){ return $wp_version; }
        }

        // At last, use the checksum of the main framework class.
        return md5_file(ABSPATH . WPINC . '/class-wp.php');
    }

    /**
     * Find and retrieve the absolute path of the WordPress configuration file.
     *
     * @return string Absolute path of the WordPress configuration file.
     */
    public static function get_wpconfig_path(){
        if( defined('ABSPATH') ){
            $file_path = ABSPATH . '/wp-config.php';

            // if wp-config.php doesn't exist, or is not readable check one directory up.
            if( !file_exists($file_path) ){
                $file_path = ABSPATH . '/../wp-config.php';
            }

            // Remove duplicated double slashes.
            $file_path = realpath($file_path);

            if( $file_path ){
                return $file_path;
            }
        }

        return FALSE;
    }

    /**
     * Find and retrieve the absolute path of the main WordPress htaccess file.
     *
     * @return string Absolute path of the main WordPress htaccess file.
     */
    public static function get_htaccess_path(){
        if( defined('ABSPATH') ){
            $base_dirs = array(
                rtrim(ABSPATH, '/'),
                dirname(ABSPATH),
                dirname(dirname(ABSPATH))
            );

            foreach( $base_dirs as $base_dir ){
                $htaccess_path = sprintf('%s/.htaccess', $base_dir);

                if( file_exists($htaccess_path) ){
                    return $htaccess_path;
                }
            }
        }

        return FALSE;
    }

    /**
     * Get the pattern of the definition related with a WordPress secret key.
     *
     * @return string Secret key definition pattern.
     */
    public static function secret_key_pattern(){
        return '/define\(\'([A-Z_]+)\',([ ]+)\'(.*)\'\);/';
    }

    /**
     * Retrieve the real ip address of the user in the current request.
     *
     * @param  boolean $return_header Whether the header name where the address was found must be returned.
     * @return string                 The real ip address of the user in the current request.
     */
    public static function get_remote_addr( $return_header=FALSE ){
        $remote_addr = '';
        $header_used = 'unknown';

        if( self::is_behind_cloudproxy() ){
            $alternatives = array(
                'HTTP_X_SUCURI_CLIENTIP',
                'HTTP_X_REAL_IP',
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'SUCURI_RIP',
                'REMOTE_ADDR',
            );

            foreach( $alternatives as $alternative ){
                if(
                    isset($_SERVER[$alternative])
                    && self::is_valid_ip($_SERVER[$alternative])
                ){
                    $remote_addr = $_SERVER[$alternative];
                    $header_used = $alternative;
                    break;
                }
            }
        }

        elseif( isset($_SERVER['REMOTE_ADDR']) ) {
            $remote_addr = $_SERVER['REMOTE_ADDR'];
            $header_used = 'REMOTE_ADDR';
        }

        if( $remote_addr == '::1' ){
            $remote_addr = '127.0.0.1';
        }

        if( $return_header ){
            return $header_used;
        }

        return $remote_addr;
    }

    /**
     * Return the HTTP header used to retrieve the remote address.
     *
     * @return string The HTTP header used to retrieve the remote address.
     */
    public static function get_remote_addr_header(){
        return self::get_remote_addr(TRUE);
    }

    /**
     * Retrieve the user-agent from the current request.
     *
     * @return string The user-agent from the current request.
     */
    public static function get_user_agent(){
        if( isset($_SERVER['HTTP_USER_AGENT']) ){
            return self::escape($_SERVER['HTTP_USER_AGENT']);
        }

        return FALSE;
    }

    /**
     * Get the clean version of the current domain.
     *
     * @return string The domain of the current site.
     */
    public static function get_domain(){
        if( function_exists('get_site_url') ){
            $site_url = get_site_url();
        } else {
            if( !isset($_SERVER['HTTP_HOST']) ){
                $_SERVER['HTTP_HOST'] = 'localhost';
            }

            $site_url = $_SERVER['HTTP_HOST'];
        }

        $pattern = '/([fhtps]+:\/\/)?([^:\/]+)(:[0-9:]+)?(\/.*)?/';
        $domain_name =  preg_replace( $pattern, '$2', $site_url );

        return $domain_name;
    }

    /**
     * Check whether the site is behing the Sucuri CloudProxy network.
     *
     * @param  boolean $verbose Return an array with the hostname, address, and status, or not.
     * @return boolean          Either TRUE or FALSE if the site is behind CloudProxy.
     */
    public static function is_behind_cloudproxy( $verbose=FALSE ){
        $http_host = self::get_domain();
        $host_by_addr = @gethostbyname($http_host);
        $host_by_name = @gethostbyaddr($host_by_addr);
        $status = (bool) preg_match('/^cloudproxy[0-9]+\.sucuri\.net$/', $host_by_name);

        /*
         * If the DNS reversion failed but the CloudProxy API key is set, then consider
         * the site as protected by a firewall. A fake key can be used to bypass the DNS
         * checking, but that is not something that will affect us, only the client.
         */
        if (
            $status === FALSE
            && SucuriScanAPI::get_cloudproxy_key()
        ) {
            $status = TRUE;
        }

        if( $verbose ){
            return array(
                'http_host' => $http_host,
                'host_name' => $host_by_name,
                'host_addr' => $host_by_addr,
                'status' => $status,
            );
        }

        return $status;
    }

    /**
     * Get the email address set by the administrator to receive the notifications
     * sent by the plugin, if the email is missing the WordPress email address is
     * chosen by default.
     *
     * @return string The administrator email address.
     */
    public static function get_site_email(){
        $email = get_option('admin_email');

        if( self::is_valid_email($email) ){
            return $email;
        }

        return FALSE;
    }

    /**
     * Returns the current time measured in the number of seconds since the Unix Epoch.
     *
     * @return integer Return current Unix timestamp.
     */
    public static function local_time(){
        if( function_exists('current_time') ){
            return current_time('timestamp');
        } else {
            return time();
        }
    }

    /**
     * Retrieve the date in localized format, based on timestamp.
     *
     * If the locale specifies the locale month and weekday, then the locale will
     * take over the format for the date. If it isn't, then the date format string
     * will be used instead.
     *
     * @param  integer $timestamp Unix timestamp.
     * @return string             The date, translated if locale specifies it.
     */
    public static function datetime( $timestamp=0 ){
        if( is_numeric($timestamp) && $timestamp > 0 ){
            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            $timezone_format = sprintf( '%s %s', $date_format, $time_format );

            return date_i18n( $timezone_format, $timestamp );
        }

        return NULL;
    }

    /**
     * Retrieve the date in localized format based on the current time.
     *
     * @return string The date, translated if locale specifies it.
     */
    public static function current_datetime(){
        $local_time = self::local_time();

        return self::datetime($local_time);
    }

    /**
     * Return the time passed since the specified timestamp until now.
     *
     * @param  integer $timestamp The Unix time number of the date/time before now.
     * @return string             The time passed since the timestamp specified.
     */
    public static function time_ago( $timestamp=0 ){
        if( !is_numeric($timestamp) ){
            $timestamp = strtotime($timestamp);
        }

        $local_time = self::local_time();
        $diff = abs( $local_time - intval($timestamp) );

        if( $diff == 0 ){ return 'just now'; }

        $intervals = array(
            1                => array('year',   31556926),
            $diff < 31556926 => array('month',  2628000),
            $diff < 2629744  => array('week',   604800),
            $diff < 604800   => array('day',    86400),
            $diff < 86400    => array('hour',   3600),
            $diff < 3600     => array('minute', 60),
            $diff < 60       => array('second', 1)
        );

        $value = floor($diff/$intervals[1][1]);
        $time_ago = sprintf(
            '%s %s%s ago',
            $value,
            $intervals[1][0],
            ( $value > 1 ? 's' : '' )
        );

        return $time_ago;
    }

    /**
     * Convert an string of characters into a valid variable name.
     *
     * @see http://www.php.net/manual/en/language.variables.basics.php
     *
     * @param  string $text A text containing alpha-numeric and special characters.
     * @return string       A valid variable name.
     */
    public static function human2var( $text='' ){
        $text = strtolower($text);
        $pattern = '/[^a-z0-9_]/';
        $var_name = preg_replace($pattern, '_', $text);

        return $var_name;
    }

    /**
     * Check whether a variable contains a serialized data or not.
     *
     * @param  string  $data The data that will be checked.
     * @return boolean       TRUE if the data was serialized, FALSE otherwise.
     */
    public static function is_serialized( $data='' ){
        return ( is_string($data) && preg_match('/^(a|O):[0-9]+:.+/', $data) );
    }

    /**
     * Check whether an IP address has a valid format or not.
     *
     * @param  string  $remote_addr The host IP address.
     * @return boolean              Whether the IP address specified is valid or not.
     */
    public static function is_valid_ip( $remote_addr='' ){
        // Check for IPv4 and IPv6.
        if( function_exists('filter_var') ){
            return (bool) filter_var( $remote_addr, FILTER_VALIDATE_IP );
        }

        // Assuming older version of PHP and server, so only will check for IPv4.
        elseif( strlen($remote_addr) >= 7 ) {
            $pattern = '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/';

            if( preg_match($pattern, $remote_addr, $match) ){
                for( $i=0; $i<4; $i++ ){
                    if( $match[$i] > 255 ){ return FALSE; }
                }

                return TRUE;
            }
        }

        return FALSE;
    }


    /**
     * Check whether an IP address is formatted as CIDR or not.
     *
     * @param  string $remote_addr The supposed ip address that will be checked.
     * @return boolean             Either TRUE or FALSE if the ip address specified is valid or not.
     */
    public static function is_valid_cidr( $remote_addr='' ){
        if ( preg_match('/^([0-9\.]{7,15})\/(8|16|24)$/', $remote_addr, $match) ) {
            if ( self::is_valid_ip($match[1]) ) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Separate the parts of an IP address.
     *
     * @param  string $remote_addr The supposed ip address that will be formatted.
     * @return array               Clean address, CIDR range, and CIDR format; FALSE otherwise.
     */
    public static function get_ip_info( $remote_addr='' ){
        if ( $remote_addr ) {
            $addr_info = array();
            $ip_parts = explode( '/', $remote_addr );
            $addr_info['remote_addr'] = $ip_parts[0];
            $addr_info['cidr_range'] = isset($ip_parts[1]) ? $ip_parts[1] : '32';
            $addr_info['cidr_format'] = $addr_info['remote_addr'] . '/' . $addr_info['cidr_range'];


            return $addr_info;
        }

        return FALSE;
    }

    /**
     * Validate email address.
     *
     * This use the native PHP function filter_var which is available in PHP >=
     * 5.2.0 if it is not found in the interpreter this function will sue regular
     * expressions to check whether the email address passed is valid or not.
     *
     * @see http://www.php.net/manual/en/function.filter-var.php
     *
     * @param  string $email The string that will be validated as an email address.
     * @return boolean       TRUE if the email address passed to the function is valid, FALSE if not.
     */
    public static function is_valid_email( $email='' ){
        if( function_exists('filter_var') ){
            return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
        } else {
            $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
            return (bool) preg_match($pattern, $email);
        }
    }

    /**
     * Return a string with all the valid email addresses.
     *
     * @param  string  $email    The string that will be validated as an email address.
     * @param  boolean $as_array TRUE to return the list of valid email addresses as an array.
     * @return string            All the valid email addresses separated by a comma.
     */
    public static function get_valid_email( $email='', $as_array=FALSE ){
        $valid_emails = array();

        if( strpos($email, ',') !== FALSE ){
            $addresses = explode(',', $email);

            foreach( $addresses as $address ){
                $address = trim($address);

                if( self::is_valid_email($address) ){
                    $valid_emails[] = $address;
                }
            }
        }

        elseif( self::is_valid_email($email) ){
            $valid_emails[] = $email;
        }

        if( !empty($valid_emails) ){
            if( $as_array === TRUE ){
                return $valid_emails;
            }

            return self::implode(', ', $valid_emails);
        }

        return FALSE;
    }

    /**
     * Cut a long text to the length specified, and append suspensive points at the end.
     *
     * @param  string  $text   String of characters that will be cut.
     * @param  integer $length Maximum length of the returned string, default is 10.
     * @return string          Short version of the text specified.
     */
    public static function excerpt( $text='', $length=10 ){
        $text_length = strlen($text);

        if( $text_length > $length ){
            return substr( $text, 0, $length ) . '...';
        }

        return $text;
    }

    /**
     * Same as the excerpt method but with the string reversed.
     *
     * @param  string  $text   String of characters that will be cut.
     * @param  integer $length Maximum length of the returned string, default is 10.
     * @return string          Short version of the text specified.
     */
    public static function excerpt_rev( $text='', $length=10 ){
        $str_reversed = strrev($text);
        $str_excerpt = self::excerpt( $str_reversed, $length );
        $text_transformed = strrev($str_excerpt);

        return $text_transformed;
    }

    /**
     * Check whether an list is a multidimensional array or not.
     *
     * @param  array   $list An array or multidimensional array of different values.
     * @return boolean       TRUE if the list is multidimensional, FALSE otherwise.
     */
    public static function is_multi_list( $list=array() ){
        if( !empty($list) ){
            foreach( $list as $item ){
                if( is_array($item) ){
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * Join array elements with a string no matter if it is multidimensional.
     *
     * @param  string $separator Character that will act as a separator, default to an empty string.
     * @param  array  $list      The array of strings to implode.
     * @return string            String of all the items in the list, with the separator between them.
     */
    public static function implode( $separator='', $list=array() ){
        if( self::is_multi_list($list) ){
            $pieces = array();

            foreach( $list as $items ){
                $pieces[] = @implode( $separator, $items );
            }

            $joined_pieces = '(' . implode( '), (', $pieces ) . ')';

            return $joined_pieces;
        } else {
            return implode( $separator, $list );
        }
    }

    /**
     * Determine if the plugin notices can be displayed in the current page.
     *
     * @param  string  $current_page Identifier of the current page.
     * @return boolean               TRUE if the current page must not have noticies.
     */
    public static function no_notices_here( $current_page=false ){
        global $sucuriscan_no_notices_in;

        if ( $current_page === false ) {
            $current_page = SucuriScanRequest::get('page');
        }

        if (
            isset($sucuriscan_no_notices_in)
            && is_array($sucuriscan_no_notices_in)
            && !empty($sucuriscan_no_notices_in)
        ) {
            return (bool) in_array($current_page, $sucuriscan_no_notices_in);
        }

        return false;
    }

}

/**
 * HTTP request handler.
 *
 * Function definitions to retrieve, validate, and clean the parameters during a
 * HTTP request, generally after a form submission or while loading a URL. Use
 * these methods at most instead of accessing an index in the global PHP
 * variables _POST, _GET, _REQUEST since they may come with insecure data.
 */
class SucuriScanRequest extends SucuriScan {

    /**
     * Returns the value stored in a specific index in the global _GET, _POST or
     * _REQUEST variables, you can specify a pattern as the second argument to
     * match allowed values.
     *
     * @param  array  $list    The array where the specified key will be searched.
     * @param  string $key     Name of the index where the requested variable is supposed to be.
     * @param  string $pattern Optional pattern to match allowed values in the requested key.
     * @return string          The value stored in the specified key inside the global _GET variable.
     */
    public static function request( $list=array(), $key='', $pattern='' ){
        $key = self::variable_prefix($key);

        if(
            is_array($list)
            && is_string($key)
            && isset($list[$key])
        ){
            // Select the key from the list and escape its content.
            $key_value = $list[$key];

            // Define regular expressions for specific value types.
            if( $pattern === '' ){
                $pattern = '/.*/';
            } else {
                switch( $pattern ){
                    case '_nonce': $pattern = '/^[a-z0-9]{10}$/'; break;
                    case '_page': $pattern = '/^[a-z_]+$/'; break;
                    case '_array': $pattern = '_array'; break;
                    case '_yyyymmdd': $pattern = '/^[0-9]{4}(\-[0-9]{2}){2}$/'; break;
                    default: $pattern = '/^'.$pattern.'$/'; break;
                }
            }

            // If the request data is an array, then only cast the value.
            if( $pattern == '_array' && is_array($key_value) ){
                return (array) $key_value;
            }

            // Check the format of the request data with a regex defined above.
            if( @preg_match($pattern, $key_value) ){
                return self::escape($key_value);
            }
        }

        return FALSE;
    }

    /**
     * Returns the value stored in a specific index in the global _GET variable,
     * you can specify a pattern as the second argument to match allowed values.
     *
     * @param  string $key     Name of the index where the requested variable is supposed to be.
     * @param  string $pattern Optional pattern to match allowed values in the requested key.
     * @return string          The value stored in the specified key inside the global _GET variable.
     */
    public static function get( $key='', $pattern='' ){
        return self::request( $_GET, $key, $pattern );
    }

    /**
     * Returns the value stored in a specific index in the global _POST variable,
     * you can specify a pattern as the second argument to match allowed values.
     *
     * @param  string $key     Name of the index where the requested variable is supposed to be.
     * @param  string $pattern Optional pattern to match allowed values in the requested key.
     * @return string          The value stored in the specified key inside the global _POST variable.
     */
    public static function post( $key='', $pattern='' ){
        return self::request( $_POST, $key, $pattern );
    }

    /**
     * Returns the value stored in a specific index in the global _REQUEST variable,
     * you can specify a pattern as the second argument to match allowed values.
     *
     * @param  string $key     Name of the index where the requested variable is supposed to be.
     * @param  string $pattern Optional pattern to match allowed values in the requested key.
     * @return string          The value stored in the specified key inside the global _POST variable.
     */
    public static function get_or_post( $key='', $pattern='' ){
        return self::request( $_REQUEST, $key, $pattern );
    }

}

/**
 * Class to process files and folders.
 *
 * Here are implemented the functions needed to open, scan, read, create files
 * and folders using the built-in PHP class SplFileInfo. The SplFileInfo class
 * offers a high-level object oriented interface to information for an individual
 * file.
 */
class SucuriScanFileInfo extends SucuriScan {

    /**
     * Define the interface that will be used to execute the file system scans, the
     * available options are SPL, OpenDir, and Glob (all in lowercase). This can be
     * configured from the settings page.
     *
     * @var string
     */
    public $scan_interface = 'spl';

    /**
     * Whether the list of files that can be ignored from the filesystem scan will
     * be used to return the directory tree, this should be disabled when scanning a
     * directory without the need to filter the items in the list.
     *
     * @var boolean
     */
    public $ignore_files = TRUE;

    /**
     * Whether the list of folders that can be ignored from the filesystem scan will
     * be used to return the directory tree, this should be disabled when scanning a
     * path without the need to filter the items in the list.
     *
     * @var boolean
     */
    public $ignore_directories = TRUE;

    /**
     * A list of ignored directory paths, these folders will be skipped during the
     * execution of the file system scans, and any sub-directory or files inside
     * these paths will be ignored too.
     *
     * @see SucuriScanFSScanner.get_ignored_directories()
     * @var array
     */
    private $ignored_directories = array();

    /**
     * Whether the filesystem scanner should run recursively or not.
     *
     * @var boolean
     */
    public $run_recursively = TRUE;

    /**
     * Class constructor.
     */
    public function __construct(){
    }

    /**
     * Retrieve a long text string with signatures of all the files contained
     * in the main and subdirectories of the folder specified, also the filesize
     * and md5sum of that file. Some folders and files will be ignored depending
     * on some rules defined by the developer.
     *
     * @param  string  $directory Parent directory where the filesystem scan will start.
     * @param  boolean $as_array  Whether the result of the operation will be returned as an array or string.
     * @return array              List of files in the main and subdirectories of the folder specified.
     */
    public function get_directory_tree_md5( $directory='', $as_array=FALSE ){
        $project_signatures = '';
        $abs_path = rtrim( ABSPATH, '/' );
        $files = $this->get_directory_tree($directory);

        if( $as_array ){
            $project_signatures = array();
        }

        if( $files ){
            sort($files);

            foreach( $files as $filepath){
                $file_checksum = @md5_file($filepath);
                $filesize = @filesize($filepath);

                if( $as_array ){
                    $basename = str_replace( $abs_path . '/', '', $filepath );
                    $project_signatures[$basename] = array(
                        'filepath' => $filepath,
                        'checksum' => $file_checksum,
                        'filesize' => $filesize,
                        'created_at' => filectime($filepath),
                        'modified_at' => filemtime($filepath),
                    );
                } else {
                    $filepath = str_replace( $abs_path, $abs_path . '/', $filepath );
                    $project_signatures .= sprintf(
                        "%s%s%s%s\n",
                        $file_checksum,
                        $filesize,
                        chr(32),
                        $filepath
                    );
                }
            }
        }

        return $project_signatures;
    }

    /**
     * Retrieve a list with all the files contained in the main and subdirectories
     * of the folder specified. Some folders and files will be ignored depending
     * on some rules defined by the developer.
     *
     * @param  string $directory Parent directory where the filesystem scan will start.
     * @return array             List of files in the main and subdirectories of the folder specified.
     */
    public function get_directory_tree($directory=''){
        if( file_exists($directory) && is_dir($directory) ){
            $tree = array();

            // Check whether the ignore scanning feature is enabled or not.
            if( SucuriScanFSScanner::will_ignore_scanning() ){
                $this->ignored_directories = SucuriScanFSScanner::get_ignored_directories();
            }

            switch( $this->scan_interface ){
                case 'spl':
                    if( $this->is_spl_available() ){
                        $tree = $this->get_directory_tree_with_spl($directory);
                    } else {
                        $this->scan_interface = 'opendir';
                        $tree = $this->get_directory_tree($directory);
                    }
                    break;

                case 'glob':
                    $tree = $this->get_directory_tree_with_glob($directory);
                    break;

                case 'opendir':
                    $tree = $this->get_directory_tree_with_opendir($directory);
                    break;

                default:
                    $this->scan_interface = 'spl';
                    $tree = $this->get_directory_tree($directory);
                    break;
            }

            return $tree;
        }

        return FALSE;
    }

    /**
     * Find a file under the directory tree specified.
     *
     * @param  string $filename  Name of the folder or file being scanned at the moment.
     * @param  string $directory Directory where the scanner is located at the moment.
     * @return array             List of file paths where the file was found.
     */
    public function find_file( $filename='', $directory=NULL ){
        $file_paths = array();

        if(
            is_null($directory)
            && defined('ABSPATH')
        ){
            $directory = ABSPATH;
        }

        if( is_dir($directory) ){
            $dir_tree = $this->get_directory_tree( $directory );

            foreach( $dir_tree as $filepath ){
                if( stripos($filepath, $filename) !== FALSE ){
                    $file_paths[] = $filepath;
                }
            }
        }

        return $file_paths;
    }

    /**
     * Check whether the built-in class SplFileObject is available in the system
     * or not, it is required to have PHP >= 5.1.0. The SplFileObject class offers
     * an object oriented interface for a file.
     *
     * @link http://www.php.net/manual/en/class.splfileobject.php
     *
     * @return boolean Whether the PHP class "SplFileObject" is available or not.
     */
    public static function is_spl_available(){
        return (bool) class_exists('SplFileObject');
    }

    /**
     * Retrieve a list with all the files contained in the main and subdirectories
     * of the folder specified. Some folders and files will be ignored depending
     * on some rules defined by the developer.
     *
     * @link http://www.php.net/manual/en/class.recursivedirectoryiterator.php
     * @see  RecursiveDirectoryIterator extends FilesystemIterator
     * @see  FilesystemIterator         extends DirectoryIterator
     * @see  DirectoryIterator          extends SplFileInfo
     * @see  SplFileInfo
     *
     * @param  string $directory Parent directory where the filesystem scan will start.
     * @return array             List of files in the main and subdirectories of the folder specified.
     */
    private function get_directory_tree_with_spl($directory=''){
        $files = array();
        $filepath = realpath($directory);

        if( !class_exists('FilesystemIterator') ){
            return $this->get_directory_tree($directory, 'opendir');
        }

        if( $this->run_recursively ){
            $flags = FilesystemIterator::KEY_AS_PATHNAME
                | FilesystemIterator::CURRENT_AS_FILEINFO
                | FilesystemIterator::SKIP_DOTS
                | FilesystemIterator::UNIX_PATHS;
            $objects = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($filepath, $flags),
                RecursiveIteratorIterator::SELF_FIRST,
                RecursiveIteratorIterator::CATCH_GET_CHILD
            );
        } else {
            $objects = new DirectoryIterator($filepath);
        }

        foreach( $objects as $filepath => $fileinfo ){
            if( $this->run_recursively ){
                $directory = dirname($filepath);
                $filename = $fileinfo->getFilename();
            } else {
                if( $fileinfo->isDot() || $fileinfo->isDir() ){ continue; }

                $directory = $fileinfo->getPath();
                $filename = $fileinfo->getFilename();
                $filepath = $directory . '/' . $filename;
            }

            if( $this->ignore_folderpath($directory, $filename) ){ continue; }
            if( $this->ignore_filepath($filename) ){ continue; }

            $files[] = $filepath;
        }

        return $files;
    }

    /**
     * Retrieve a list with all the files contained in the main and subdirectories
     * of the folder specified. Some folders and files will be ignored depending
     * on some rules defined by the developer.
     *
     * @param  string $directory Parent directory where the filesystem scan will start.
     * @return array             List of files in the main and subdirectories of the folder specified.
     */
    private function get_directory_tree_with_glob($directory=''){
        $files = array();

        $directory_pattern = sprintf( '%s/*', rtrim($directory,'/') );
        $files_found = glob($directory_pattern);

        if( is_array($files_found) ){
            foreach( $files_found as $filepath ){
                $filepath = realpath($filepath);
                $directory = dirname($filepath);
                $filepath_parts = explode('/', $filepath);
                $filename = array_pop($filepath_parts);

                if( is_dir($filepath) ){
                    if( $this->ignore_folderpath($directory, $filename) ){ continue; }

                    if( $this->run_recursively ){
                        $sub_files = $this->get_directory_tree_with_glob($filepath);

                        if( $sub_files ){
                            $files = array_merge($files, $sub_files);
                        }
                    }
                } else {
                    if( $this->ignore_filepath($filename) ){ continue; }
                    $files[] = $filepath;
                }
            }
        }

        return $files;
    }

    /**
     * Retrieve a list with all the files contained in the main and subdirectories
     * of the folder specified. Some folders and files will be ignored depending
     * on some rules defined by the developer.
     *
     * @param  string $directory Parent directory where the filesystem scan will start.
     * @return array             List of files in the main and subdirectories of the folder specified.
     */
    private function get_directory_tree_with_opendir($directory=''){
        $dh = @opendir($directory);
        if( !$dh ){ return FALSE; }

        $files = array();
        while( ($filename = readdir($dh)) !== FALSE ){
            $filepath = realpath($directory.'/'.$filename);

            if( is_dir($filepath) ){
                if( $this->ignore_folderpath($directory, $filename) ){ continue; }

                if( $this->run_recursively ){
                    $sub_files = $this->get_directory_tree_with_opendir($filepath);

                    if( $sub_files ){
                        $files = array_merge($files, $sub_files);
                    }
                }
            } else {
                if( $this->ignore_filepath($filename) ){ continue; }
                $files[] = $filepath;
            }
        }

        closedir($dh);
        return $files;
    }

    /**
     * Skip some specific directories and file paths from the filesystem scan.
     *
     * @param  string  $directory      Directory where the scanner is located at the moment.
     * @param  string  $filename       Name of the folder or file being scanned at the moment.
     * @return boolean                 Either TRUE or FALSE representing that the scan should ignore this folder or not.
     */
    private function ignore_folderpath( $directory='', $filename='' ){
        // Ignoring current and parent folders.
        if( $filename == '.' || $filename == '..' ){ return TRUE; }

        if( $this->ignore_directories ){
            // Ignore directories based on a common regular expression.
            $filepath = realpath( $directory . '/' . $filename );
            $pattern = '/\/wp-content\/(uploads|cache|backup|w3tc)/';

            if( preg_match($pattern, $filepath) ){
                return TRUE;
            }

            // Ignore directories specified by the administrator.
            if( !empty($this->ignored_directories) ){
                foreach( $this->ignored_directories['directories'] as $ignored_dir ){
                    if( strpos($directory, $ignored_dir) !== FALSE ){
                        return TRUE;
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * Skip some specific files from the filesystem scan.
     *
     * @param  string  $filename Name of the folder or file being scanned at the moment.
     * @return boolean           Either TRUE or FALSE representing that the scan should ignore this filename or not.
     */
    private function ignore_filepath( $filename='' ){
        if( !$this->ignore_files ){ return FALSE; }

        // Ignoring backup files from our clean ups.
        if( strpos($filename, '_sucuribackup.') !== FALSE ){ return TRUE; }

        // Any file maching one of these rules WILL NOT be ignored.
        if(
            ( strpos($filename, '.php')      !== FALSE) ||
            ( strpos($filename, '.htm')      !== FALSE) ||
            ( strpos($filename, '.js')       !== FALSE) ||
            ( strcmp($filename, '.htaccess') == 0     ) ||
            ( strcmp($filename, 'php.ini')   == 0     )
        ){ return FALSE; }

        return TRUE;
    }

    /**
     * Retrieve a list of unique directory paths.
     *
     * @param  array $dir_tree A list of files under a directory.
     * @return array           A list of unique directory paths.
     */
    public function get_diretories_only( $dir_tree=array() ){
        $dirs = array();

        if( is_string($dir_tree) ){
            $dir_tree = $this->get_directory_tree($dir_tree);
        }

        if( is_array($dir_tree) && !empty($dir_tree) ){
            foreach( $dir_tree as $filepath ){
                $dir_path = dirname($filepath);

                if(
                    !in_array($dir_path, $dirs)
                    && !in_array($dir_path, $this->ignored_directories['directories'])
                ){
                    $dirs[] = $dir_path;
                }
            }
        }

        return $dirs;
    }

    /**
     * Remove a directory recursively.
     *
     * @param  string  $directory Path of the existing directory that will be removed.
     * @return boolean            TRUE if all the files and folder inside the directory were removed.
     */
    public function remove_directory_tree( $directory='' ){
        $all_removed = TRUE;
        $dir_tree = $this->get_directory_tree($directory);

        if( $dir_tree ){
            $dirs_only = array();

            foreach( $dir_tree as $filepath ){
                if( is_file($filepath) ){
                    $removed = @unlink($filepath);

                    if( !$removed ){
                        $all_removed = FALSE;
                    }
                }

                elseif( is_dir($filepath) ){
                    $dirs_only[] = $filepath;
                }
            }

            if( !function_exists('sucuriscan_strlen_diff') ){
                /**
                 * Evaluates the difference between the length of two strings.
                 *
                 * @param  string  $a First string of characters that will be measured.
                 * @param  string  $b Second string of characters that will be measured.
                 * @return integer    The difference in length between the two strings.
                 */
                function sucuriscan_strlen_diff( $a='', $b='' ){
                    return strlen($b) - strlen($a);
                }
            }

            usort($dirs_only, 'sucuriscan_strlen_diff');

            foreach( $dirs_only as $dir_path ){
                @rmdir($dir_path);
            }
        }

        return $all_removed;
    }

    /**
     * Return the lines of a file as an array, it will automatically remove the new
     * line characters from the end of each line, and skip empty lines from the
     * list.
     *
     * @param  string $filepath Path to the file.
     * @return array            An array where each element is a line in the file.
     */
    public static function file_lines( $filepath='' ){
        return @file( $filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
    }

    /**
     * Function to emulate the UNIX tail function by displaying the last X number of
     * lines in a file. Useful for large files, such as logs, when you want to
     * process lines in PHP or write lines to a database.
     *
     * @param  string  $file_path Path to the file.
     * @param  integer $lines     Number of lines to retrieve from the end of the file.
     * @param  boolean $adaptive  Whether the buffer will adapt to a specific number of bytes or not.
     * @return string             Text contained at the end of the file.
     */
    public static function tail_file( $file_path='', $lines=1, $adaptive=true ) {
        $file = @fopen( $file_path, 'rb' );
        $limit = $lines;

        if ( $file ) {
            fseek( $file, -1, SEEK_END );

            if     ( $adaptive && $lines < 2  ) { $buffer = 64; }
            elseif ( $adaptive && $lines < 10 ) { $buffer = 512; }
            else                                { $buffer = 4096; }

            if ( fread($file, 1) != "\n" ) { $lines -= 1; }

            $output = '';
            $chunk = '';

            while ( ftell($file) > 0 && $lines >= 0 ) {
                $seek = min( ftell($file), $buffer );
                fseek( $file, -$seek, SEEK_CUR );
                $chunk = fread( $file, $seek );
                $output = $chunk . $output;
                fseek( $file, -mb_strlen($chunk, '8bit'), SEEK_CUR );
                $lines -= substr_count( $chunk, "\n" );
            }

            fclose($file);

            $lines_arr = explode( "\n", $output );
            $lines_count = count($lines_arr);
            $result = array_slice( $lines_arr, ($lines_count - $limit) );

            return $result;
        }

        return FALSE;
    }

}

/**
 * File-based cache library.
 *
 * WP_Object_Cache [1] is WordPress' class for caching data which may be
 * computationally expensive to regenerate, such as the result of complex
 * database queries. However the object cache is non-persistent. This means that
 * data stored in the cache resides in memory only and only for the duration of
 * the request. Cached data will not be stored persistently across page loads
 * unless of the installation of a 3party persistent caching plugin [2].
 *
 * [1] http://codex.wordpress.org/Class_Reference/WP_Object_Cache
 * [2] http://codex.wordpress.org/Class_Reference/WP_Object_Cache#Persistent_Caching
 */
class SucuriScanCache extends SucuriScan {

    /**
     * The unique name (or identifier) of the file with the data.
     *
     * The file should be located in the same folder where the dynamic data
     * generated by the plugin is stored, and using the following format [1], it
     * most be a PHP file because it is expected to have an exit point in the first
     * line of the file causing it to stop the execution if a unauthorized user
     * tries to access it directly.
     *
     * [1] /public/data/sucuri-DATASTORE.php
     *
     * @var null|string
     */
    private $datastore = NULL;

    /**
     * The full path of the datastore file.
     *
     * @var string
     */
    private $datastore_path = '';

    /**
     * Whether the datastore file is usable or not.
     *
     * This variable will only be TRUE if the datastore file specified exists, is
     * writable and readable, in any other case it will always be FALSE.
     *
     * @var boolean
     */
    private $usable_datastore = FALSE;

    /**
     * Class constructor.
     *
     * @param  string $datastore Unique name (or identifier) of the file with the data.
     * @return void
     */
    public function __construct( $datastore='' ){
        $this->datastore = $datastore;
        $this->datastore_path = $this->datastore_file_path();
        $this->usable_datastore = (bool) $this->datastore_path;
    }

    /**
     * Default attributes for every datastore file.
     *
     * @return string Default attributes for every datastore file.
     */
    private function datastore_default_info(){
        $attrs = array(
            'datastore' => $this->datastore,
            'created_on' => time(),
            'updated_on' => time(),
        );

        return $attrs;
    }

    /**
     * Default content of every datastore file.
     *
     * @param  array  $finfo Rainbow table with the key names and decoded values.
     * @return string        Default content of every datastore file.
     */
    private function datastore_info( $finfo=array() ){
        $attrs = $this->datastore_default_info();
        $info_is_available = (bool) isset($finfo['info']);
        $info  = "<?php\n";

        foreach( $attrs as $attr_name => $attr_value ){
            if(
                $info_is_available
                && $attr_name != 'updated_on'
                && isset($finfo['info'][$attr_name])
            ){
                $attr_value = $finfo['info'][$attr_name];
            }

            $info .= sprintf( "// %s=%s;\n", $attr_name, $attr_value );
        }

        $info .= "exit(0);\n";
        $info .= "?>\n";

        return $info;
    }

    /**
     * Check if the datastore file exists, if it's writable and readable by the same
     * user running the server, in case that it does not exists the function will
     * tries to create it by itself with the right permissions to use it.
     *
     * @return string The full path where the datastore file is located, FALSE otherwise.
     */
    private function datastore_file_path(){
        if( !is_null($this->datastore) ){
            $folder_path = $this->datastore_folder_path();
            $file_path = $folder_path . 'sucuri-' . $this->datastore . '.php';

            // Create the datastore file is it does not exists and the folder is writable.
            if(
                !file_exists($file_path)
                && is_writable($folder_path)
            ){
                @file_put_contents( $file_path, $this->datastore_info(), LOCK_EX );
            }

            // Continue the operation after an attemp to create the datastore file.
            if(
                file_exists($file_path)
                && is_writable($file_path)
                && is_readable($file_path)
            ){
                return $file_path;
            }
        }

        return FALSE;
    }

    /**
     * Define the pattern for the regular expression that will check if a cache key
     * is valid or not, and also will help the function that parses the file to see
     * which characters of each line are the keys are which are the values.
     *
     * @param  string $action Either "valid", "content", or "header".
     * @return string Cache key pattern.
     */
    private function key_pattern( $action='valid' ){
        if( $action == 'valid' ){
            return '/^([0-9a-zA-Z_]+)$/';
        }

        if( $action == 'content' ){
            return '/^([0-9a-zA-Z_]+):(.+)/';
        }

        if( $action == 'header' ){
            return '/^\/\/ ([a-z_]+)=(.*);$/';
        }

        return FALSE;
    }

    /**
     * Check whether a key has a valid name or not.
     *
     * @param  string  $key Unique name to identify the data in the datastore file.
     * @return boolean      TRUE if the format of the key name is valid, FALSE otherwise.
     */
    private function valid_key_name( $key='' ){
        return (bool) preg_match( $this->key_pattern('valid'), $key );
    }

    /**
     * Update the content of the datastore file with the new entries.
     *
     * @param  array   $finfo Rainbow table with the key names and decoded values.
     * @return boolean        TRUE if the operation finished successfully, FALSE otherwise.
     */
    private function save_new_entries( $finfo=array() ){
        $data_string = $this->datastore_info($finfo);

        if( !empty($finfo) ){
            foreach( $finfo['entries'] as $key => $data ){
                if( $this->valid_key_name($key) ){
                    $data = json_encode($data);
                    $data_string .= sprintf( "%s:%s\n", $key, $data );
                }
            }
        }

        $saved = @file_put_contents( $this->datastore_path, $data_string, LOCK_EX );

        return (bool) $saved;
    }

    /**
     * Retrieve and parse the datastore file, and generate a rainbow table with the
     * key names and decoded data as the values of each entry. Duplicated key names
     * will be removed automatically while adding the keys to the array and their
     * values will correspond to the first occurrence found in the file.
     *
     * @param  boolean $assoc When TRUE returned objects will be converted into associative arrays.
     * @return array          Rainbow table with the key names and decoded values.
     */
    private function get_datastore_content( $assoc=FALSE ){
        $data_object = array(
            'info' => array(),
            'entries' => array(),
        );

        if( $this->usable_datastore ){
            $data_lines = SucuriScanFileInfo::file_lines($this->datastore_path);

            if( !empty($data_lines) ){
                foreach( $data_lines as $line ){
                    if( preg_match( $this->key_pattern('header'), $line, $match ) ){
                        $data_object['info'][$match[1]] = $match[2];
                    }

                    elseif( preg_match( $this->key_pattern('content'), $line, $match ) ){
                        if(
                            $this->valid_key_name($match[1])
                            && !array_key_exists($match[1], $data_object)
                        ){
                            $data_object['entries'][$match[1]] = @json_decode( $match[2], $assoc );
                        }
                    }
                }
            }
        }

        return $data_object;
    }

    /**
     * Retrieve the headers of the datastore file.
     *
     * Each datastore file has a list of attributes at the beginning of the it with
     * information like the creation and last update time. If you are extending the
     * functionality of these headers please refer to the function that contains the
     * default attributes and their values [1].
     *
     * [1] SucuriScanCache::datastore_default_info()
     *
     * @return array Default content of every datastore file.
     */
    public function get_datastore_info(){
        $finfo = $this->get_datastore_content();

        if( !empty($finfo['info']) ){
            return $finfo['info'];
        }

        return FALSE;
    }

    /**
     * Get the total number of unique entries in the datastore file.
     *
     * @param  array   $finfo Rainbow table with the key names and decoded values.
     * @return integer        Total number of unique entries found in the datastore file.
     */
    public function get_count( $finfo=NULL ){
        if( !is_array($finfo) ){
            $finfo = $this->get_datastore_content();
        }

        return count($finfo['entries']);
    }

    /**
     * Check whether the last update time of the datastore file has surpassed the
     * lifetime specified for a key name. This function is the only one related with
     * the caching process, any others besides this are just methods used to handle
     * the data inside those files.
     *
     * @param  integer $lifetime Life time of the key in the datastore file.
     * @param  array   $finfo    Rainbow table with the key names and decoded values.
     * @return boolean           TRUE if the life time of the data has expired, FALSE otherwise.
     */
    public function data_has_expired( $lifetime=0, $finfo=NULL ){
        if( is_null($finfo) ){
            $finfo = $this->get_datastore_content();
        }

        if( $lifetime > 0 && !empty($finfo['info']) ){
            $diff_time = time() - intval($finfo['info']['updated_on']);

            if( $diff_time >= $lifetime ){
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Execute the action using the key name and data specified.
     *
     * @param  string  $key      Unique name to identify the data in the datastore file.
     * @param  string  $data     Mixed data stored in the datastore file following the unique key name.
     * @param  string  $action   Either add, set, get, or delete.
     * @param  integer $lifetime Life time of the key in the datastore file.
     * @param  boolean $assoc    When TRUE returned objects will be converted into associative arrays.
     * @return boolean           TRUE if the operation finished successfully, FALSE otherwise.
     */
    private function handle_key_data( $key='', $data=NULL, $action='', $lifetime=0, $assoc=FALSE ){
        if( preg_match('/^(add|set|get|get_all|exists|delete)$/', $action) ){
            if(
                $this->valid_key_name($key)
                && $this->usable_datastore
            ){
                $finfo = $this->get_datastore_content($assoc);

                switch( $action ){
                    case 'add': /* no_break */
                    case 'set':
                        $finfo['entries'][$key] = $data;
                        return $this->save_new_entries($finfo);
                        break;
                    case 'get':
                        if(
                            !$this->data_has_expired($lifetime, $finfo)
                            && array_key_exists($key, $finfo['entries'])
                        ){
                            return $finfo['entries'][$key];
                        }
                        break;
                    case 'get_all': /* no_break */
                        if( !$this->data_has_expired($lifetime, $finfo) ) {
                            return $finfo['entries'];
                        }
                    case 'exists':
                        if(
                            !$this->data_has_expired($lifetime, $finfo)
                            && array_key_exists($key, $finfo['entries'])
                        ){
                            return TRUE;
                        }
                        break;
                    case 'delete':
                        unset($finfo['entries'][$key]);
                        return $this->save_new_entries($finfo);
                        break;
                }
            }
        }

        return FALSE;
    }

    /**
     * JSON-encode the data and store it in the datastore file identifying it with
     * the key name, the data will be added to the file even if the key is
     * duplicated, but when getting the value of the same key later again it will
     * return only the value of the first occurrence found in the file.
     *
     * @param  string  $key  Unique name to identify the data in the datastore file.
     * @param  string  $data Mixed data stored in the datastore file following the unique key name.
     * @return boolean       TRUE if the data was stored successfully, FALSE otherwise.
     */
    public function add( $key='', $data='' ){
        return $this->handle_key_data( $key, $data, 'add' );
    }

    /**
     * Update the data of all the key names matching the one specified.
     *
     * @param  string  $key  Unique name to identify the data in the datastore file.
     * @param  string  $data Mixed data stored in the datastore file following the unique key name.
     * @return boolean       TRUE if the data was stored successfully, FALSE otherwise.
     */
    public function set( $key='', $data='' ){
        return $this->handle_key_data( $key, $data, 'set' );
    }

    /**
     * Retrieve the first occurrence of the key found in the datastore file.
     *
     * @param  string  $key      Unique name to identify the data in the datastore file.
     * @param  integer $lifetime Life time of the key in the datastore file.
     * @param  boolean $assoc    When TRUE returned objects will be converted into associative arrays.
     * @return string            Mixed data stored in the datastore file following the unique key name.
     */
    public function get( $key='', $lifetime=0, $assoc=FALSE ){
        $assoc = ( $assoc == 'array' ? TRUE : $assoc );

        return $this->handle_key_data( $key, NULL, 'get', $lifetime, $assoc );
    }

    /**
     * Retrieve all the entries found in the datastore file.
     *
     * @param  integer $lifetime Life time of the key in the datastore file.
     * @param  boolean $assoc    When TRUE returned objects will be converted into associative arrays.
     * @return string            Mixed data stored in the datastore file following the unique key name.
     */
    public function get_all( $lifetime=0, $assoc=FALSE ){
        $assoc = ( $assoc == 'array' ? TRUE : $assoc );

        return $this->handle_key_data( 'temp', NULL, 'get_all', $lifetime, $assoc );
    }

    /**
     * Check whether a specific key exists in the datastore file.
     *
     * @param  string  $key Unique name to identify the data in the datastore file.
     * @return boolean      TRUE if the key exists in the datastore file, FALSE otherwise.
     */
    public function exists( $key='' ){
        return $this->handle_key_data( $key, NULL, 'exists' );
    }

    /**
     * Delete any entry from the datastore file matching the key name specified.
     *
     * @param  string  $key Unique name to identify the data in the datastore file.
     * @return boolean      TRUE if the entries were removed, FALSE otherwise.
     */
    public function delete( $key='' ){
        return $this->handle_key_data( $key, NULL, 'delete' );
    }

    /**
     * Remove all the entries from the datastore file.
     *
     * @return boolean Always TRUE unless the datastore file is not writable.
     */
    public function flush(){
        $finfo = $this->get_datastore_content();

        return $this->save_new_entries($finfo);
    }

}

/**
 * Plugin options handler.
 *
 * Options are pieces of data that WordPress uses to store various preferences
 * and configuration settings. Listed below are the options, along with some of
 * the default values from the current WordPress install. By using the
 * appropriate function, options can be added, changed, removed, and retrieved,
 * from the wp_options table.
 *
 * The Options API is a simple and standardized way of storing data in the
 * database. The API makes it easy to create, access, update, and delete
 * options. All the data is stored in the wp_options table under a given custom
 * name. This page contains the technical documentation needed to use the
 * Options API. A list of default options can be found in the Option Reference.
 *
 * Note that the _site_ functions are essentially the same as their
 * counterparts. The only differences occur for WP Multisite, when the options
 * apply network-wide and the data is stored in the wp_sitemeta table under the
 * given custom name.
 *
 * @see http://codex.wordpress.org/Option_Reference
 * @see http://codex.wordpress.org/Options_API
 */
class SucuriScanOption extends SucuriScanRequest {

    /**
     * Default values for the plugin options.
     *
     * @return array Default plugin option values.
     */
    private static function get_default_option_values(){
        $defaults = array(
            'sucuriscan_api_key' => FALSE,
            'sucuriscan_account' => '',
            'sucuriscan_datastore_path' => '',
            'sucuriscan_fs_scanner' => 'enabled',
            'sucuriscan_scan_frequency' => 'hourly',
            'sucuriscan_scan_interface' => 'spl',
            'sucuriscan_scan_modfiles' => 'enabled',
            'sucuriscan_scan_checksums' => 'enabled',
            'sucuriscan_scan_errorlogs' => 'enabled',
            'sucuriscan_sitecheck_scanner' => 'enabled',
            'sucuriscan_sitecheck_counter' => 0,
            'sucuriscan_parse_errorlogs' => 'enabled',
            'sucuriscan_errorlogs_limit' => 30,
            'sucuriscan_ignore_scanning' => 'disabled',
            'sucuriscan_runtime' => 0,
            'sucuriscan_lastlogin_redirection' => 'enabled',
            'sucuriscan_notify_to' => '',
            'sucuriscan_emails_sent' => 0,
            'sucuriscan_emails_per_hour' => 5,
            'sucuriscan_last_email_at' => time(),
            'sucuriscan_email_subject' => 'Sucuri Alert, :domain, :event',
            'sucuriscan_prettify_mails' => 'disabled',
            'sucuriscan_notify_success_login' => 'enabled',
            'sucuriscan_notify_failed_login' => 'enabled',
            'sucuriscan_notify_post_publication' => 'enabled',
            'sucuriscan_notify_theme_editor' => 'enabled',
            'sucuriscan_maximum_failed_logins' => 30,
            'sucuriscan_collect_wrong_passwords' => 'disabled',
            'sucuriscan_ignored_events' => '',
            'sucuriscan_verify_ssl_cert' => 'true',
            'sucuriscan_request_timeout' => 90,
            'sucuriscan_heartbeat' => 'enabled',
            'sucuriscan_heartbeat_pulse' => 15,
            'sucuriscan_heartbeat_interval' => 'standard',
            'sucuriscan_heartbeat_autostart' => 'enabled',
        );

        return $defaults;
    }

    /**
     * Retrieve the default values for some specific options.
     *
     * @param  string|array $settings Either an array that will be complemented or a string with the name of the option.
     * @return string|array           The default values for the specified options.
     */
    private static function get_default_options( $settings='' ){
        $default_options = self::get_default_option_values();

        // Use framework built-in function.
        if( function_exists('get_option') ){
            $admin_email = get_option('admin_email');
            $default_options['sucuriscan_account'] = $admin_email;
            $default_options['sucuriscan_notify_to'] = $admin_email;
        }

        if( is_array($settings) ){
            foreach( $default_options as $option_name => $option_value ){
                if( !isset($settings[$option_name]) ){
                    $settings[$option_name] = $option_value;
                }
            }

            return $settings;
        }

        if( is_string($settings) ){
            if( isset($default_options[$settings]) ){
                return $default_options[$settings];
            }
        }

        return FALSE;
    }

    /**
     * Retrieve specific options from the database.
     *
     * Considering the case in which this plugin is installed in a multisite instance
     * of Wordpress, the allowed values for the first parameter of this function will
     * be treated like this:
     *
     * <ul>
     *   <li>all_plugin_options: Will retrieve all the option values created by this plugin in the main site (aka. network),</li>
     *   <li>site_options: Will retrieve all the option values stored in the current site visited by the user (aka. sub-site) excluding the transient options,</li>
     *   <li>plugin_option: Will retrieve one specific option from the network site only if the option starts with the prefix <i>sucuri_<i>.</li>
     * </ul>
     *
     * @param  string $filter_by   Criteria to filter the results, valid values: all_plugin_options, site_options, sucuri_option.
     * @param  string $option_name Optional parameter with the name of the option that will be filtered.
     * @return array               List of options retrieved from the query in the database.
     */
    public static function get_options_from_db( $filter_by='', $option_name='' ){
        global $wpdb;

        $output = FALSE;

        switch($filter_by){
            case 'all_plugin_options':
                $output = $wpdb->get_results("SELECT * FROM {$wpdb->options} WHERE option_name LIKE 'sucuriscan%' ORDER BY option_id ASC");
                break;
            case 'site_options':
                $output = $wpdb->get_results("SELECT * FROM {$wpdb->options} WHERE option_name NOT LIKE '%_transient_%' ORDER BY option_id ASC");
                break;
            case 'plugin_option':
                $row = $wpdb->get_row( $wpdb->prepare("SELECT option_value FROM {$wpdb->base_prefix}options WHERE option_name = %s LIMIT 1", $option_name) );
                if( $row ){ $output = $row->option_value; }
                break;
        }

        return $output;
    }

    /**
     * Alias function for the method Common::SucuriScan_Get_Options()
     *
     * This function search the specified option in the database, not only the options
     * set by the plugin but all the options set for the site. If the value retrieved
     * is FALSE the method tries to search for a default value.
     *
     * To facilitate the development, you can prefix the name of the key in the
     * request (when accessing it) with a single colon, this function will
     * automatically replace that character with the unique identifier of the
     * plugin.
     *
     * @see http://codex.wordpress.org/Function_Reference/get_option
     *
     * @param  string $option_name Optional parameter that you can use to filter the results to one option.
     * @return string              The value (or default value) of the option specified.
     */
    public static function get_option( $option_name='' ){
        $option_name = self::variable_prefix($option_name);

        return self::get_options($option_name);
    }

    /**
     * Update the value of an database' option.
     *
     * Use the function to update a named option/value pair to the options database
     * table. The option name value is escaped with a special database method before
     * the insert SQL statement but not the option value, this value should always
     * be properly sanitized.
     *
     * @see http://codex.wordpress.org/Function_Reference/update_option
     *
     * @param  string  $option_name  Name of the option to update which must not exceed 64 characters.
     * @param  string  $option_value The new value for the option, can be an integer, string, array, or object.
     * @return boolean               True if option value has changed, false if not or if update failed.
     */
    public static function update_option( $option_name='', $option_value='' ){
        if( function_exists('update_option') ){
            $option_name = self::variable_prefix($option_name);

            return update_option( $option_name, $option_value );
        }

        return FALSE;
    }

    /**
     * Remove an option from the database.
     *
     * A safe way of removing a named option/value pair from the options database table.
     *
     * @see http://codex.wordpress.org/Function_Reference/delete_option
     *
     * @param  string  $option_name Name of the option to be deleted.
     * @return boolean              True, if option is successfully deleted. False on failure, or option does not exist.
     */
    public static function delete_option( $option_name='' ){
        if( function_exists('delete_option') ){
            $option_name = self::variable_prefix($option_name);

            return delete_option( $option_name );
        }

        return FALSE;
    }

    /**
     * Retrieve all the options created by this Plugin from the Wordpress database.
     *
     * The function acts as an alias of WP::get_option() and if the returned value
     * is FALSE it tries to search for a default value to complement the information.
     *
     * @param  string $option_name Optional parameter that you can use to filter the results to one option.
     * @return array               Either FALSE or an Array containing all the sucuri options in the database.
     */
    private static function get_options( $option_name='' ){
        if( !empty($option_name) ){
            return self::get_single_option($option_name);
        }

        $settings = array();
        $results = self::get_options_from_db('all_plugin_options');

        foreach( $results as $row ){
            $settings[$row->option_name] = $row->option_value;
        }

        return self::get_default_options($settings);
    }

    /**
     * Retrieve a single option from the database.
     *
     * @param  string $option_name Name of the option that will be retrieved.
     * @return string              Value of the option stored in the database, FALSE if not found.
     */
    private static function get_single_option( $option_name='' ){
        $option_value = FALSE;
        $is_plugin_option = preg_match('/^sucuriscan_/', $option_name) ? TRUE : FALSE;

        if( self::is_multisite() && $is_plugin_option ){
            $option_value = self::get_options_from_db('plugin_option', $option_name);
        }

        // Use framework built-in function.
        elseif( function_exists('get_option') ){
            $option_value = get_option($option_name);
        }

        if( $option_value === FALSE && $is_plugin_option ){
            $option_value = self::get_default_options($option_name);
        }

        return $option_value;
    }

    /**
     * Retrieve all the options stored by Wordpress in the database. The options
     * containing the word "transient" are excluded from the results, this function
     * is compatible with multisite instances.
     *
     * @return array All the options stored by Wordpress in the database, except the transient options.
     */
    public static function get_site_options(){
        $settings = array();
        $results = self::get_options_from_db('site_options');

        foreach( $results as $row ){
            $settings[$row->option_name] = $row->option_value;
        }

        return $settings;
    }

    /**
     * Check what Wordpress options were changed comparing the values in the database
     * with the values sent through a simple request using a GET or POST method.
     *
     * @param  array $request The content of the global variable GET or POST considering SERVER[REQUEST_METHOD].
     * @return array          A list of all the options that were changes through this request.
     */
    public static function what_options_were_changed( $request=array() ){
        $options_changed = array(
            'original' => array(),
            'changed' => array()
        );

        $site_options = self::get_site_options();

        foreach( $request as $req_name => $req_value ){
            if(
                array_key_exists($req_name, $site_options)
                && $site_options[$req_name] != $req_value
            ){
                $options_changed['original'][$req_name] = $site_options[$req_name];
                $options_changed['changed'][$req_name] = $req_value;
            }
        }

        return $options_changed;
    }

    /**
     * Check the nonce comming from any of the settings pages.
     *
     * @return boolean TRUE if the nonce is valid, FALSE otherwise.
     */
    public static function check_options_nonce(){
        // Create the option_page value if permalink submission.
        if(
            !isset($_POST['option_page'])
            && isset($_POST['permalink_structure'])
        ){
            $_POST['option_page'] = 'permalink';
        }

        // Check if the option_page has an allowed value.
        if( $option_page = SucuriScanRequest::post('option_page') ){
            $nonce='_wpnonce';
            $action = '';

            switch( $option_page ){
                case 'general':    /* no_break */
                case 'writing':    /* no_break */
                case 'reading':    /* no_break */
                case 'discussion': /* no_break */
                case 'media':      /* no_break */
                case 'options':    /* no_break */
                    $action = $option_page . '-options';
                    break;
                case 'permalink':
                    $action = 'update-permalink';
                    break;
            }

            // Check the nonce validity.
            if(
                !empty($action)
                && isset($_REQUEST[$nonce])
                && wp_verify_nonce($_REQUEST[$nonce], $action)
            ){
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Get a list of the post types ignored to receive email notifications when the
     * "new site content" hook is triggered.
     *
     * @return array List of ignored posts-types to send notifications.
     */
    public static function get_ignored_events(){
        $post_types = self::get_option(':ignored_events');
        $post_types_arr = FALSE;

        // Encode (old) serialized data into JSON.
        if( self::is_serialized($post_types) ){
            $post_types_arr = @unserialize($post_types);
            $post_types_fix = json_encode($post_types_arr);
            self::update_option( ':ignored_events', $post_types_fix );

            return $post_types_arr;
        }

        // Decode JSON-encoded data as an array.
        elseif( preg_match('/^\{.+\}$/', $post_types) ){
            $post_types_arr = @json_decode( $post_types, TRUE );
        }

        if( !is_array($post_types_arr) ){
            $post_types_arr = array();
        }

        return $post_types_arr;
    }

    /**
     * Add a new post type to the list of ignored events to send notifications.
     *
     * @param  string  $event_name Unique post-type name.
     * @return boolean             Whether the event was ignored or not.
     */
    public static function add_ignored_event( $event_name='' ){
        if( function_exists('get_post_types') ){
            $post_types = get_post_types();

            // Check if the event is a registered post-type.
            if( array_key_exists($event_name, $post_types) ){
                $ignored_events = self::get_ignored_events();

                // Check if the event is not ignored already.
                if( !array_key_exists($event_name, $ignored_events) ){
                    $ignored_events[$event_name] = time();
                    $saved = self::update_option( ':ignored_events', json_encode($ignored_events) );

                    return $saved;
                }
            }
        }

        return FALSE;
    }

    /**
     * Remove a post type from the list of ignored events to send notifications.
     *
     * @param  string  $event_name Unique post-type name.
     * @return boolean             Whether the event was removed from the list or not.
     */
    public static function remove_ignored_event( $event_name='' ){
        $ignored_events = self::get_ignored_events();

        if( array_key_exists($event_name, $ignored_events) ){
            unset( $ignored_events[$event_name] );
            $saved = self::update_option( ':ignored_events', json_encode($ignored_events) );

            return $saved;
        }

        return FALSE;
    }

    /**
     * Check whether an event is being ignored to send notifications or not.
     *
     * @param  string  $event_name Unique post-type name.
     * @return boolean             Whether an event is being ignored or not.
     */
    public static function is_ignored_event( $event_name='' ){
        $event_name = strtolower($event_name);
        $ignored_events = self::get_ignored_events();

        if( array_key_exists($event_name, $ignored_events) ){
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Retrieve a list of basic security keys and check whether their values were
     * randomized correctly.
     *
     * @return array Array with three keys: good, missing, bad.
     */
    public static function get_security_keys(){
        $response = array(
            'good' => array(),
            'missing' => array(),
            'bad' => array(),
        );
        $key_names = array(
            'AUTH_KEY',
            'AUTH_SALT',
            'LOGGED_IN_KEY',
            'LOGGED_IN_SALT',
            'NONCE_KEY',
            'NONCE_SALT',
            'SECURE_AUTH_KEY',
            'SECURE_AUTH_SALT',
        );

        foreach( $key_names as $key_name ){
            if( defined($key_name) ){
                $key_value = constant($key_name);

                if( stripos( $key_value, 'unique phrase' ) !== FALSE ){
                    $response['bad'][$key_name] = $key_value;
                } else {
                    $response['good'][$key_name] = $key_value;
                }
            } else {
                $response['missing'][$key_name] = FALSE;
            }
        }

        return $response;
    }

}

/**
 * System events, reports and actions.
 *
 * An event is an action or occurrence detected by the program that may be
 * handled by the program. Typically events are handled synchronously with the
 * program flow, that is, the program has one or more dedicated places where
 * events are handled, frequently an event loop. Typical sources of events
 * include the user; another source is a hardware device such as a timer. Any
 * program can trigger its own custom set of events as well, e.g. to communicate
 * the completion of a task. A computer program that changes its behavior in
 * response to events is said to be event-driven, often with the goal of being
 * interactive.
 *
 * @see http://en.wikipedia.org/wiki/Event_(computing)
 */
class SucuriScanEvent extends SucuriScan {

    /**
     * Schedule the task to run the first filesystem scan.
     *
     * @return void
     */
    public static function schedule_task(){
        $task_name = 'sucuriscan_scheduled_scan';

        if( !wp_next_scheduled($task_name) ){
            wp_schedule_event( time() + 10, 'twicedaily', $task_name );
        }

        wp_schedule_single_event( time() + 300, $task_name );
    }

    /**
     * Checks last time we ran to avoid running twice (or too often).
     *
     * @param  integer $runtime    When the filesystem scan must be scheduled to run.
     * @param  boolean $force_scan Whether the filesystem scan was forced by an administrator user or not.
     * @return boolean             Either TRUE or FALSE representing the success or fail of the operation respectively.
     */
    private static function verify_run( $runtime=0, $force_scan=FALSE ){
        $option_name = ':runtime';
        $last_run = SucuriScanOption::get_option($option_name);
        $current_time = time();

        // The filesystem scanner can be disabled from the settings page.
        if(
            SucuriScanOption::get_option(':fs_scanner') == 'disabled'
            && $force_scan === FALSE
        ){
            return FALSE;
        }

        // Check if the last runtime is too near the current time.
        if( $last_run && !$force_scan ){
            $runtime_diff = $current_time - $runtime;

            if( $last_run >= $runtime_diff ){
                return FALSE;
            }
        }

        SucuriScanOption::update_option( $option_name, $current_time );

        return TRUE;
    }

    /**
     * Check whether the current WordPress version must be reported to the API
     * service or not, this is to avoid duplicated information in the audit logs.
     *
     * @return boolean TRUE if the current WordPress version must be reported, FALSE otherwise.
     */
    private static function report_site_version(){
        $option_name = ':site_version';
        $reported_version = SucuriScanOption::get_option($option_name);
        $wp_version = self::site_version();

        if( $reported_version != $wp_version ){
            SucuriScanAPI::send_log( 'WordPress version: ' . $wp_version );
            SucuriScanOption::update_option( $option_name, $wp_version );

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Gather all the checksums (aka. file hashes) of this site, send them, and
     * analyze them using the Sucuri Monitoring service, this will generate the
     * audit logs for this site and be part of the integrity checks.
     *
     * @param  boolean $force_scan Whether the filesystem scan was forced by an administrator user or not.
     * @return boolean             TRUE if the filesystem scan was successful, FALSE otherwise.
     */
    public static function filesystem_scan( $force_scan=FALSE ){
        $minimum_runtime = SUCURISCAN_MINIMUM_RUNTIME;

        if(
            self::verify_run( $minimum_runtime, $force_scan )
            && class_exists('SucuriScanFileInfo')
            && SucuriScanAPI::get_plugin_key()
        ){
            self::report_site_version();

            $sucuri_fileinfo = new SucuriScanFileInfo();
            $sucuri_fileinfo->scan_interface = SucuriScanOption::get_option(':scan_interface');
            $signatures = $sucuri_fileinfo->get_directory_tree_md5(ABSPATH);

            if( $signatures ){
                $hashes_sent = SucuriScanAPI::send_hashes( $signatures );

                if( $hashes_sent ){
                    SucuriScanInterface::info( 'Successful filesystem scan' );
                    SucuriScanOption::update_option( ':runtime', time() );
                    return TRUE;
                } else {
                    SucuriScanInterface::error( 'The file hashes could not be stored.' );
                }
            } else {
                SucuriScanInterface::error( 'The file hashes could not be retrieved, the filesystem scan failed.' );
            }
        }

        return FALSE;
    }

    /**
     * Generates an audit event log (to be sent later).
     *
     * @param  integer $severity Importance of the event that will be reported, values from one to five.
     * @param  string  $location In which part of the system was the event triggered.
     * @param  string  $message  The explanation of the event.
     * @return boolean           TRUE if the event was logged in the monitoring service, FALSE otherwise.
     */
    public static function report_event( $severity=0, $location='', $message='' ){
        $user = wp_get_current_user();
        $username = FALSE;
        $current_time = date( 'Y-m-d H:i:s' );
        $remote_ip = self::get_remote_addr();

        // Fixing severity value.
        $severity = (int) $severity;
        if( $severity > 0 ){ $severity = 1; }
        elseif( $severity > 5 ){ $severity = 5; }

        // Identify current user in session.
        if(
            $user instanceof WP_User
            && isset($user->user_login)
            && !empty($user->user_login)
        ){
            if( $user->user_login != $user->display_name ){
                $username = sprintf( ' %s (%s),', $user->display_name, $user->user_login );
            } else {
                $username = sprintf( ' %s,', $user->user_login );
            }
        }

        // Convert the severity number into a readable string.
        switch( $severity ){
            case 0:  $severity_name = 'Debug';    break;
            case 1:  $severity_name = 'Notice';   break;
            case 2:  $severity_name = 'Info';     break;
            case 3:  $severity_name = 'Warning';  break;
            case 4:  $severity_name = 'Error';    break;
            case 5:  $severity_name = 'Critical'; break;
            default: $severity_name = 'Info';     break;
        }

        $message = str_replace( array("\n", "\r"), array('', ''), $message );
        $event_message = sprintf(
            '%s:%s %s; %s',
            $severity_name,
            $username,
            $remote_ip,
            $message
        );

        return SucuriScanAPI::send_log($event_message);
    }

    /**
     * Send a notification to the administrator of the specified events, only if
     * the administrator accepted to receive alerts for this type of events.
     *
     * @param  string $event   The name of the event that was triggered.
     * @param  string $content Body of the email that will be sent to the administrator.
     * @return void
     */
    public static function notify_event( $event='', $content='' ){
        $notify = SucuriScanOption::get_option(':notify_' . $event);
        $email = SucuriScanOption::get_option(':notify_to');
        $email_params = array();

        if ( self::is_trusted_ip() ) {
            $notify = 'disabled';
        }

        if( $notify == 'enabled' ){
            if( $event == 'post_publication' ){
                $event = 'post_update';
            }

            elseif( $event == 'failed_login' ){
                $content .= "<br>\n<br>\n<em>Explanation: Someone failed to login to your site. If you";
                $content .= " are getting too many of these messages, it is likely your site is under a brute";
                $content .= " force attack. You can disable the notifications for failed logins from here [1].";
                $content .= " More details at Password Guessing Brute Force Attacks [2].</em><br>\n<br>\n";
                $content .= "[1] " . SucuriScanTemplate::get_url('settings') . " <br>\n";
                $content .= "[2] http://kb.sucuri.net/definitions/attacks/brute-force/password-guessing <br>\n";
            }

            // Send a notification even if the limit of emails per hour was reached.
            elseif( $event == 'bruteforce_attack' ){
                $email_params['Force'] = TRUE;
            }

            $title = str_replace('_', chr(32), $event);
            $mail_sent = SucuriScanMail::send_mail( $email, $title, $content, $email_params );

            return $mail_sent;
        }

        return FALSE;
    }

    /**
     * Check whether an IP address is being trusted or not.
     *
     * @param  string  $remote_addr The supposed ip address that will be checked.
     * @return boolean              TRUE if the IP address of the user is trusted, FALSE otherwise.
     */
    private static function is_trusted_ip( $remote_addr='' ){
        $cache = new SucuriScanCache('trustip');
        $trusted_ips = $cache->get_all();

        if ( !$remote_addr ) {
            $remote_addr = SucuriScan::get_remote_addr();
        }

        $addr_md5 = md5($remote_addr);

        // Check if the CIDR in range 32 of this IP is trusted.
        if (
            is_array($trusted_ips)
            && !empty($trusted_ips)
            && array_key_exists($addr_md5, $trusted_ips)
        ) {
            return TRUE;
        }

        if ( $trusted_ips ) {
            foreach ( $trusted_ips as $cache_key => $ip_info ) {
                $ip_parts = explode( '.', $ip_info->remote_addr );
                $ip_pattern = FALSE;

                // Generate the regular expression for CIDR range 24.
                if ( $ip_info->cidr_range == 24 ) {
                    $ip_pattern = sprintf( '/^%d\.%d\.%d\.[0-9]{1,3}$/', $ip_parts[0], $ip_parts[1], $ip_parts[2] );
                }

                // Generate the regular expression for CIDR range 16.
                elseif ( $ip_info->cidr_range == 16 ) {
                    $ip_pattern = sprintf( '/^%d\.%d(\.[0-9]{1,3}){2}$/', $ip_parts[0], $ip_parts[1] );
                }

                // Generate the regular expression for CIDR range 8.
                elseif ( $ip_info->cidr_range == 8 ) {
                    $ip_pattern = sprintf( '/^%d(\.[0-9]{1,3}){3}$/', $ip_parts[0] );
                }

                if ( $ip_pattern && preg_match($ip_pattern, $remote_addr) ) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * Generate and set a new password for a specific user not in session.
     *
     * @param  integer $user_id The user identifier that will be changed, this must be different than the user in session.
     * @return boolean          Either TRUE or FALSE in case of success or error respectively.
     */
    public static function set_new_password( $user_id=0 ){
        $user_id = intval($user_id);

        if( $user_id > 0 && function_exists('wp_generate_password') ){
            $user = get_userdata($user_id);

            if( $user instanceof WP_User ){
                $new_password = wp_generate_password(15, TRUE, FALSE);

                $message .= 'The password for your user account <strong>"'. $user->display_name .'"</strong> '
                    . 'in the website specified above was changed, this is the new password generated automatically '
                    . 'by the system, please update as soon as possible.<br><div style="display:inline-block;'
                    . 'background:#ddd;font-family:monaco,monospace,courier;font-size:30px;margin:0;padding:15px;'
                    . 'border:1px solid #999">'. $new_password .'</div>';

                $data_set = array( 'Force' => TRUE ); // Skip limit for emails per hour.
                SucuriScanMail::send_mail( $user->user_email, 'Password changed', $message, $data_set );

                wp_set_password($new_password, $user_id);

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Modify the WordPress configuration file and change the keys that were defined
     * by a new random-generated list of keys retrieved from the official WordPress
     * API. The result of the operation will be either FALSE in case of error, or an
     * array containing multiple indexes explaining the modification, among them you
     * will find the old and new keys.
     *
     * @return false|array Either FALSE in case of error, or an array with the old and new keys.
     */
    public static function set_new_config_keys(){
        $new_wpconfig = '';
        $config_path = self::get_wpconfig_path();

        if( $config_path ){
            $pattern = self::secret_key_pattern();
            $define_tpl = "define('%s',%s'%s');";
            $config_lines = SucuriScanFileInfo::file_lines($config_path);
            $new_keys = SucuriScanAPI::get_new_secret_keys();
            $old_keys = array();
            $old_keys_string = '';
            $new_keys_string = '';

            foreach( (array) $config_lines as $config_line ){
                $config_line = str_replace("\n", '', $config_line);

                if( preg_match($pattern, $config_line, $match) ){
                    $key_name = $match[1];

                    if( array_key_exists($key_name, $new_keys) ){
                        $white_spaces = $match[2];
                        $old_keys[$key_name] = $match[3];
                        $config_line = sprintf( $define_tpl, $key_name, $white_spaces, $new_keys[$key_name] );
                        $old_keys_string .= sprintf( $define_tpl, $key_name, $white_spaces, $old_keys[$key_name] ) . "\n";
                        $new_keys_string .= $config_line . "\n";
                    }
                }

                $new_wpconfig .= $config_line . "\n";
            }

            $response = array(
                'updated' => is_writable($config_path),
                'old_keys' => $old_keys,
                'old_keys_string' => $old_keys_string,
                'new_keys' => $new_keys,
                'new_keys_string' => $new_keys_string,
                'new_wpconfig' => $new_wpconfig,
            );

            if( $response['updated'] ){
                file_put_contents($config_path, $new_wpconfig, LOCK_EX);
            }

            return $response;
        }

        return FALSE;
    }

}

/**
 * Function call interceptors.
 *
 * The term hooking covers a range of techniques used to alter or augment the
 * behavior of an operating system, of applications, or of other software
 * components by intercepting function calls or messages or events passed
 * between software components. Code that handles such intercepted function
 * calls, events or messages is called a "hook".
 *
 * Hooking is used for many purposes, including debugging and extending
 * functionality. Examples might include intercepting keyboard or mouse event
 * messages before they reach an application, or intercepting operating system
 * calls in order to monitor behavior or modify the function of an application
 * or other component; it is also widely used in benchmarking programs.
 */
class SucuriScanHook extends SucuriScanEvent {

    /**
     * Send to Sucuri servers an alert advising that an attachment was added to a post.
     *
     * @param  integer $id The post identifier.
     * @return void
     */
    public static function hook_add_attachment( $id=0 ){
        $data = ( is_int($id) ? get_post($id) : FALSE );
        $title = ( $data ? $data->post_title : 'Unknown' );

        $message = 'Media file added #'.$id.' ('.$title.')';
        self::report_event( 1, 'core', $message );
        self::notify_event( 'post_publication', $message );
    }

    /**
     * Send an alert advising that a new link was added to the bookmarks.
     *
     * @param  integer $id Identifier of the new link created;
     * @return void
     */
    public static function hook_add_link( $id=0 ){
        $data = ( is_int($id) ? get_bookmark($id) : FALSE );

        if( $data ){
            $title = $data->link_name;
            $url = $data->link_url;
        } else {
            $title = 'Unknown';
            $url = 'undefined/url';
        }

        $message = 'New link added #'.$id.' ('.$title.': '.$url.')';
        self::report_event( 2, 'core', $message );
        self::notify_event( 'post_publication', $message );
    }

    /**
     * Send an alert advising that a category was created.
     *
     * @param  integer $id The identifier of the category created.
     * @return void
     */
    public static function hook_create_category( $id=0 ){
        $title = ( is_int($id) ? get_cat_name($id) : 'Unknown' );

        $message = 'Category created #'.$id.' ('.$title.')';
        self::report_event( 1, 'core', $message );
        self::notify_event( 'post_publication', $message );
    }

    /**
     * Send an alert advising that a post was deleted.
     *
     * @param  integer $id The identifier of the post deleted.
     * @return void
     */
    public static function hook_delete_post( $id=0 ){
        self::report_event( 3, 'core', 'Post deleted #'.$id );
    }

    /**
     * Send an alert advising that a user account was deleted.
     *
     * @param  integer $id The identifier of the user account deleted.
     * @return void
     */
    public static function hook_delete_user( $id=0 ){
        self::report_event( 3, 'core', 'User account deleted #'.$id );
    }

    /**
     * Send an alert advising that an attempt to reset the password
     * of an user account was executed.
     *
     * @return void
     */
    public static function hook_login_form_resetpass(){
        // Detecting WordPress 2.8.3 vulnerability - $key is array.
        if( isset($_GET['key']) && is_array($_GET['key']) ){
            self::report_event( 3, 'core', 'Attempt to reset password by attacking WP/2.8.3 bug' );
        }
    }

    /**
     * Send an alert advising that the state of a post was changed
     * from private to published. This will only applies for posts not pages.
     *
     * @param  integer $id The identifier of the post changed.
     * @return void
     */
    public static function hook_private_to_published( $id=0 ){
        $data = ( is_int($id) ? get_post($id) : FALSE );

        if( $data ){
            $title = $data->post_title;
            $p_type = ucwords($data->post_type);
        } else {
            $title = 'Unknown';
            $p_type = 'Publication';
        }

        // Check whether the post-type is being ignored to send notifications.
        if( !SucuriScanOption::is_ignored_event($p_type) ){
            $message = $p_type.' changed from private to published #'.$id.' ('.$title.')';
            self::report_event( 2, 'core', $message );
            self::notify_event( 'post_publication', $message );
        }
    }

    /**
     * Send an alert advising that a post was published.
     *
     * @param  integer $id The identifier of the post or page published.
     * @return void
     */
    public static function hook_publish( $id=0 ){
        $data = ( is_int($id) ? get_post($id) : FALSE );

        if( $data ){
            $title = $data->post_title;
            $p_type = ucwords($data->post_type);
            $action = ( $data->post_date == $data->post_modified ? 'created' : 'updated' );
        } else {
            $title = 'Unknown';
            $p_type = 'Publication';
            $action = 'published';
        }

        $message = $p_type.' was '.$action.' #'.$id.' ('.$title.')';
        self::report_event( 2, 'core', $message );
        self::notify_event( 'post_publication', $message );
    }

    /**
     * Alias function for hook_publish()
     *
     * @param  integer $id The identifier of the post or page published.
     * @return void
     */
    public static function hook_publish_page( $id=0 ){
        self::hook_publish($id);
    }

    /**
     * Alias function for hook_publish()
     *
     * @param  integer $id The identifier of the post or page published.
     * @return void
     */
    public static function hook_publish_post( $id=0 ){
        self::hook_publish($id);
    }

    /**
     * Alias function for hook_publish()
     *
     * @param  integer $id The identifier of the post or page published.
     * @return void
     */
    public static function hook_publish_phone( $id=0 ){
        self::hook_publish($id);
    }

    /**
     * Alias function for hook_publish()
     *
     * @param  integer $id The identifier of the post or page published.
     * @return void
     */
    public static function hook_xmlrpc_publish_post( $id=0 ){
        self::hook_publish($id);
    }

    /**
     * Send an alert advising that an attempt to retrieve the password
     * of an user account was tried.
     *
     * @param  string $title The name of the user account involved in the trasaction.
     * @return void
     */
    public static function hook_retrieve_password( $title='' ){
        if( empty($title) ){ $title = 'Unknown'; }

        self::report_event( 3, 'core', 'Password retrieval attempt for user: '.$title );
    }

    /**
     * Send an alert advising that the theme of the site was changed.
     *
     * @param  string $title The name of the new theme selected to used through out the site.
     * @return void
     */
    public static function hook_switch_theme( $title='' ){
        if( empty($title) ){ $title = 'Unknown'; }

        $message = 'Theme switched to: '.$title;
        self::report_event( 3, 'core', $message );
        self::notify_event( 'theme_switched', $message );
    }

    /**
     * Send an alert advising that a new user account was created.
     *
     * @param  integer $id The identifier of the new user account created.
     * @return void
     */
    public static function hook_user_register( $id=0 ){
        $data = ( is_int($id) ? get_userdata($id) : FALSE );
        $title = ( $data ? $data->display_name : 'Unknown' );

        $message = 'New user account registered #'.$id.' ('.$title.')';
        self::report_event( 3, 'core', $message );
        self::notify_event( 'user_registration', $message );
    }

    /**
     * Send an alert advising that an attempt to login into the
     * administration panel was successful.
     *
     * @param  string $title The name of the user account involved in the transaction.
     * @return void
     */
    public static function hook_wp_login( $title='' ){
        if( empty($title) ){ $title = 'Unknown'; }

        $message = 'User logged in: '.$title;
        self::report_event( 2, 'core', $message );
        self::notify_event( 'success_login', $message );
    }

    /**
     * Send an alert advising that an attempt to login into the
     * administration panel failed.
     *
     * @param  string $title The name of the user account involved in the transaction.
     * @return void
     */
    public static function hook_wp_login_failed( $title='' ){
        if( empty($title) ){ $title = 'Unknown'; }

        $password = SucuriScanRequest::post('pwd');
        $message = 'User authentication failed: ' . $title;

        if ( sucuriscan_collect_wrong_passwords() === true ) {
            $message .= "<br>\nUser wrong password: " . $password;
        }

        self::report_event( 2, 'core', $message );
        self::notify_event( 'failed_login', $message );

        // Log the failed login in the internal datastore for future reports.
        $logged = sucuriscan_log_failed_login( $title, $password );

        // Check if the quantity of failed logins will be considered as a brute-force attack.
        if( $logged ){
            $failed_logins = sucuriscan_get_failed_logins();

            if( $failed_logins ){
                $max_time = 3600;
                $maximum_failed_logins = SucuriScanOption::get_option('sucuriscan_maximum_failed_logins');

                /**
                 * If the time passed is within the hour, and the quantity of failed logins
                 * registered in the datastore file is bigger than the maximum quantity of
                 * failed logins allowed per hour (value configured by the administrator in the
                 * settings page), then send an email notification reporting the event and
                 * specifying that it may be a brute-force attack against the login page.
                 */
                if(
                    $failed_logins['diff_time'] <= $max_time
                    && $failed_logins['count'] >= $maximum_failed_logins
                ){
                    sucuriscan_report_failed_logins($failed_logins);
                }

                /**
                 * If there time passed is superior to the hour, then reset the content of the
                 * datastore file containing the failed logins so far, any entry in that file
                 * will not be considered as part of a brute-force attack (if it exists) because
                 * the time passed between the first and last login attempt is big enough to
                 * mitigate the attack. We will consider the current failed login event as the
                 * first entry of that file in case of future attempts during the next sixty
                 * minutes.
                 */
                elseif( $failed_logins['diff_time'] > $max_time ){
                    sucuriscan_reset_failed_logins();
                    sucuriscan_log_failed_login($title);
                }
            }
        }
    }

    // TODO: Detect auto updates in core, themes, and plugin files.

    /**
     * Send a notifications to the administrator of some specific events that are
     * not triggered through an hooked action, but through a simple request in the
     * admin interface.
     *
     * @return integer Either one or zero representing the success or fail of the operation.
     */
    public static function hook_undefined_actions(){

        // Plugin activation and/or deactivation.
        if(
            current_user_can('activate_plugins')
            && (
                SucuriScanRequest::get('action', '(activate|deactivate)') ||
                SucuriScanRequest::post('action', '(activate|deactivate)-selected')
            )
        ){
            $plugin_list = array();

            if(
                SucuriScanRequest::get('plugin', '.+')
                && strpos($_SERVER['REQUEST_URI'], 'plugins.php') !== FALSE
            ){
                $action_d = $_GET['action'] . 'd';
                $plugin_list[] = $_GET['plugin'];
            }

            elseif(
                isset($_POST['checked'])
                && is_array($_POST['checked'])
                && !empty($_POST['checked'])
            ){
                $action_d = str_replace('-selected', 'd', $_POST['action']);
                $plugin_list = $_POST['checked'];
            }

            foreach( $plugin_list as $plugin ){
                $plugin_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

                if(
                    !empty($plugin_info['Name'])
                    && !empty($plugin_info['Version'])
                ){
                    $message = sprintf(
                        'Plugin %s: %s (v%s; %s)',
                        $action_d,
                        self::escape($plugin_info['Name']),
                        self::escape($plugin_info['Version']),
                        self::escape($plugin)
                    );

                    self::report_event( 3, 'core', $message );
                    self::notify_event( 'plugin_' . $action_d, $message );
                }
            }
        }

        // Plugin update request.
        elseif(
            current_user_can('update_plugins')
            && (
                SucuriScanRequest::get('action', '(upgrade-plugin|do-plugin-upgrade)')
                || SucuriScanRequest::post('action', 'update-selected')
            )
        ){
            $plugin_list = array();

            if(
                SucuriScanRequest::get('plugin', '.+')
                && strpos($_SERVER['REQUEST_URI'], 'wp-admin/update.php') !== FALSE
            ){
                $plugin_list[] = SucuriScanRequest::get('plugin', '.+');
            }

            elseif(
                isset($_POST['checked'])
                && is_array($_POST['checked'])
                && !empty($_POST['checked'])
            ){
                $plugin_list = $_POST['checked'];
            }

            foreach( $plugin_list as $plugin ){
                $plugin_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

                if(
                    !empty($plugin_info['Name'])
                    && !empty($plugin_info['Version'])
                ){
                    $message = sprintf(
                        'Plugin request to be updated: %s (v%s; %s)',
                        self::escape($plugin_info['Name']),
                        self::escape($plugin_info['Version']),
                        self::escape($plugin)
                    );

                    self::report_event( 3, 'core', $message );
                    self::notify_event( 'plugin_updated', $message );
                }
            }
        }

        // Plugin installation request.
        elseif(
            current_user_can('install_plugins')
            && SucuriScanRequest::get('action', '(install|upload)-plugin')
        ){
            if( isset($_FILES['pluginzip']) ){
                $plugin = self::escape($_FILES['pluginzip']['name']);
            } else {
                $plugin = SucuriScanRequest::get('plugin', '.+');

                if( !$plugin ){ $plugin = 'Unknown'; }
            }

            $message = 'Plugin request to be installed: ' . self::escape($plugin);
            self::report_event( 3, 'core', $message );
            self::notify_event( 'plugin_installed', $message );
        }

        // Plugin deletion request.
        elseif(
            current_user_can('delete_plugins')
            && SucuriScanRequest::post('action', 'delete-selected')
            && SucuriScanRequest::post('verify-delete', '1')
        ){
            $plugin_list = (array) $_POST['checked'];

            foreach( $plugin_list as $plugin ){
                $plugin_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

                if(
                    !empty($plugin_info['Name'])
                    && !empty($plugin_info['Version'])
                ){
                    $message = sprintf(
                        'Plugin request to be deleted: %s (v%s; %s)',
                        self::escape($plugin_info['Name']),
                        self::escape($plugin_info['Version']),
                        self::escape($plugin)
                    );

                    self::report_event( 3, 'core', $message );
                    self::notify_event( 'plugin_deleted', $message );
                }
            }
        }

        // Plugin editor request.
        elseif(
            current_user_can('edit_plugins')
            && SucuriScanRequest::post('action', 'update')
            && SucuriScanRequest::post('plugin', '.+')
            && SucuriScanRequest::post('file', '.+')
            && strpos($_SERVER['REQUEST_URI'], 'plugin-editor.php') !== FALSE
        ){
            $message = 'Plugin editor used on: ' . SucuriScanRequest::post('file');
            self::report_event( 3, 'core', $message );
            self::notify_event( 'theme_editor', $message );
        }

        // Theme editor request.
        elseif(
            current_user_can('edit_themes')
            && SucuriScanRequest::post('action', 'update')
            && SucuriScanRequest::post('theme', '.+')
            && SucuriScanRequest::post('file', '.+')
            && strpos($_SERVER['REQUEST_URI'], 'theme-editor.php') !== FALSE
        ){
            $message = 'Theme editor used on: ' . SucuriScanRequest::post('theme') . '/' . SucuriScanRequest::post('file');
            self::report_event( 3, 'core', $message );
            self::notify_event( 'theme_editor', $message );
        }

        // Theme activation and/or deactivation (same hook for switch_theme).
        // Theme installation request (hook not available).
        // Theme deletion request (hook not available).

        // Theme update request.
        elseif(
            current_user_can('update_themes')
            && SucuriScanRequest::get('action', '(upgrade-theme|do-theme-upgrade)')
            && SucuriScanRequest::post('checked', '_array')
        ){
            $themes = SucuriScanRequest::post('checked', '_array');

            foreach( $themes as $theme ){
                $theme_info = wp_get_theme($theme);
                $theme_name = ucwords($theme);
                $theme_version = '0.0';

                if( $theme_info->exists() ){
                    $theme_name = $theme_info->get('Name');
                    $theme_version = $theme_info->get('Version');
                }

                $message = sprintf(
                    'Theme updated: %s (v%s; %s)',
                    self::escape($theme_name),
                    self::escape($theme_version),
                    self::escape($theme)
                );

                self::report_event( 3, 'core', $message );
                self::notify_event( 'theme_updated', $message );
            }
        }

        // WordPress update request.
        elseif(
            current_user_can('update_core')
            && SucuriScanRequest::get('action', '(do-core-upgrade|do-core-reinstall)')
            && SucuriScanRequest::post('upgrade')
        ){
            $message = 'WordPress updated to version: ' . SucuriScanRequest::post('version');
            self::report_event( 3, 'core', $message );
            self::notify_event( 'website_updated', $message );
        }

        // Widget addition or deletion.
        elseif(
            current_user_can('edit_theme_options')
            && SucuriScanRequest::post('action', 'save-widget')
            && SucuriScanRequest::post('id_base') !== FALSE
            && SucuriScanRequest::post('sidebar') !== FALSE
        ){
            if( SucuriScanRequest::post('delete_widget', '1') ){
                $action_d = 'deleted';
                $action_text = 'deleted from';
            } else {
                $action_d = 'added';
                $action_text = 'added to';
            }

            $message = sprintf(
                'Widget %s (%s) %s %s (#%d; size %dx%d)',
                SucuriScanRequest::post('id_base'),
                SucuriScanRequest::post('widget-id'),
                $action_text,
                SucuriScanRequest::post('sidebar'),
                SucuriScanRequest::post('widget_number'),
                SucuriScanRequest::post('widget-width'),
                SucuriScanRequest::post('widget-height')
            );

            self::report_event( 3, 'core', $message );
            self::notify_event( 'widget_' . $action_d, $message );
        }

        // Detect any Wordpress settings modification.
        elseif(
            current_user_can('manage_options')
            && SucuriScanOption::check_options_nonce()
        ){
            // Get the settings available in the database and compare them with the submission.
            $all_options = SucuriScanOption::get_site_options();
            $options_changed = SucuriScanOption::what_options_were_changed($_POST);
            $options_changed_str = '';
            $options_changed_count = 0;

            // Generate the list of options changed.
            foreach( $options_changed['original'] as $option_name => $option_value ){
                $options_changed_count += 1;
                $options_changed_str .= sprintf(
                    "The value of the option <b>%s</b> was changed from <b>'%s'</b> to <b>'%s'</b>.<br>\n",
                    self::escape($option_name),
                    self::escape($option_value),
                    self::escape($options_changed['changed'][$option_name])
                );
            }

            // Get the option group (name of the page where the request was originated).
            $option_page = isset($_POST['option_page']) ? $_POST['option_page'] : 'options';
            $page_referer = FALSE;

            // Check which of these option groups where modified.
            switch( $option_page ){
                case 'options':
                    $page_referer = 'Global';
                    break;
                case 'general':    /* no_break */
                case 'writing':    /* no_break */
                case 'reading':    /* no_break */
                case 'discussion': /* no_break */
                case 'media':      /* no_break */
                case 'permalink':
                    $page_referer = ucwords($option_page);
                    break;
                default:
                    $page_referer = 'Common';
                    break;
            }

            if( $page_referer && $options_changed_count > 0 ){
                $message = $page_referer.' settings changed';
                self::report_event( 3, 'core', $message );
                self::notify_event( 'settings_updated', $message . "<br>\n" . $options_changed_str );
            }
        }

    }

}

/**
 * Plugin API library.
 *
 * When used in the context of web development, an API is typically defined as a
 * set of Hypertext Transfer Protocol (HTTP) request messages, along with a
 * definition of the structure of response messages, which is usually in an
 * Extensible Markup Language (XML) or JavaScript Object Notation (JSON) format.
 * While "web API" historically has been virtually synonymous for web service,
 * the recent trend (so-called Web 2.0) has been moving away from Simple Object
 * Access Protocol (SOAP) based web services and service-oriented architecture
 * (SOA) towards more direct representational state transfer (REST) style web
 * resources and resource-oriented architecture (ROA). Part of this trend is
 * related to the Semantic Web movement toward Resource Description Framework
 * (RDF), a concept to promote web-based ontology engineering technologies. Web
 * APIs allow the combination of multiple APIs into new applications known as
 * mashups.
 *
 * @see http://en.wikipedia.org/wiki/Application_programming_interface#Web_APIs
 */
class SucuriScanAPI extends SucuriScanOption {

    /**
     * Check whether the SSL certificates will be verified while executing a HTTP
     * request or not. This is only for customization of the administrator, in fact
     * not verifying the SSL certificates can lead to a "Man in the Middle" attack.
     *
     * @return boolean Whether the SSL certs will be verified while sending a request.
     */
    public static function verify_ssl_cert(){
        return ( self::get_option(':verify_ssl_cert') === 'true' );
    }

    /**
     * Seconds before consider a HTTP request as timeout.
     *
     * @return integer Seconds to consider a HTTP request timeout.
     */
    public static function request_timeout(){
        return intval( self::get_option(':request_timeout') );
    }

    /**
     * Generate an user-agent for the HTTP requests.
     *
     * @return string An user-agent for the HTTP requests.
     */
    private static function user_agent(){
        $user_agent = sprintf(
            'WordPress/%s; %s',
            self::site_version(),
            self::get_domain()
        );

        return $user_agent;
    }

    /**
     * Retrieves a URL using a changeable HTTP method, returning results in an
     * array. Results include HTTP headers and content.
     *
     * @see http://codex.wordpress.org/Function_Reference/wp_remote_post
     * @see http://codex.wordpress.org/Function_Reference/wp_remote_get
     *
     * @param  string $url    The target URL where the request will be sent.
     * @param  string $method HTTP method that will be used to send the request.
     * @param  array  $params Parameters for the request defined in an associative array of key-value.
     * @param  array  $args   Request arguments like the timeout, redirections, headers, cookies, etc.
     * @return array          Array of results including HTTP headers or WP_Error if the request failed.
     */
    private static function api_call( $url='', $method='GET', $params=array(), $args=array() ){
        if( !$url ){ return FALSE; }

        $req_args = array(
            'method' => $method,
            'timeout' => self::request_timeout(),
            'redirection' => 2,
            'httpversion' => '1.0',
            'user-agent' => self::user_agent(),
            'blocking' => TRUE,
            'headers' => array(),
            'cookies' => array(),
            'compress' => FALSE,
            'decompress' => FALSE,
            'sslverify' => self::verify_ssl_cert(),
        );

        // Update the request arguments with the values passed tot he function.
        foreach( $args as $arg_name => $arg_value ){
            if( array_key_exists($arg_name, $req_args) ){
                $req_args[$arg_name] = $arg_value;
            }
        }

        if( $method == 'GET' ){
            if( !empty($params) ){
                $url = sprintf( '%s?%s', $url, http_build_query($params) );
            }

            $response = wp_remote_get( $url, $req_args );
        }

        elseif( $method == 'POST' ){
            $req_args['body'] = $params;
            $response = wp_remote_post( $url, $req_args );
        }

        if( isset($response) ){
            if( is_wp_error($response) ){
                SucuriScanInterface::error(sprintf(
                    'Something went wrong with an API call (%s action): %s',
                    ( isset($params['a']) ? $params['a'] : 'unknown' ),
                    $response->get_error_message()
                ));
            } else {
                $response['body_raw'] = $response['body'];

                // Check if the response data is JSON-encoded, then decode it.
                if(
                    isset($response['headers']['content-type'])
                    && $response['headers']['content-type'] == 'application/json'
                ){
                    $assoc = ( isset($args['assoc']) && $args['assoc'] === TRUE ) ? TRUE : FALSE;
                    $response['body'] = @json_decode($response['body_raw'], $assoc);
                }

                // Check if the response data is serialized (which we will consider as insecure).
                elseif( self::is_serialized($response['body']) ){
                    $response['body_raw'] = NULL;
                    $response['body'] = 'ERROR:Serialized data is not supported.';
                }

                return $response;
            }
        } else {
            SucuriScanInterface::error( 'HTTP method not allowed: ' . $method );
        }

        return FALSE;
    }

    /**
     * Store the API key locally.
     *
     * @param  string  $api_key  An unique string of characters to identify this installation.
     * @param  boolean $validate Whether the format of the key should be validated before store it.
     * @return boolean           Either TRUE or FALSE if the key was saved successfully or not respectively.
     */
    public static function set_plugin_key( $api_key='', $validate=FALSE ){
        if( $validate ){
            if( !preg_match('/^[a-z0-9]{32}$/', $api_key) ){
                SucuriScanInterface::error( 'Invalid API key format' );
                return FALSE;
            }
        }

        if( !empty($api_key) ){
            SucuriScanEvent::notify_event( 'plugin_change', 'API key updated successfully: ' . $api_key );
        }

        return self::update_option( ':api_key', $api_key );
    }

    /**
     * Retrieve the API key from the local storage.
     *
     * @return string|boolean The API key or FALSE if it does not exists.
     */
    public static function get_plugin_key(){
        $api_key = self::get_option(':api_key');

        if( $api_key && strlen($api_key) > 10 ){
            return $api_key;
        }

        return FALSE;
    }

    /**
     * Check and return the API key for the plugin.
     *
     * In this plugin the key is a pair of two strings concatenated by a single
     * slash, the first part of it is in fact the key and the second part is the
     * unique identifier of the site in the remote server.
     *
     * @return array|boolean FALSE if the key is invalid or not present, an array otherwise.
     */
    public static function get_cloudproxy_key(){
        $option_name = ':cloudproxy_apikey';
        $api_key = self::get_option($option_name);

        // Check if the cloudproxy-waf plugin was previously installed.
        if( !$api_key ){
            $api_key = self::get_option('sucuriwaf_apikey');

            if( $api_key ){
                self::update_option( $option_name, $api_key );
                self::delete_option('sucuriwaf_apikey');
            }
        }

        // Check the validity of the API key.
        $match = self::is_valid_cloudproxy_key( $api_key, TRUE );

        if( $match ){
            return array(
                'string' => $match[1].'/'.$match[2],
                'k' => $match[1],
                's' => $match[2]
            );
        }

        return FALSE;
    }

    /**
     * Check whether the CloudProxy API key is valid or not.
     *
     * @param  string  $api_key      The CloudProxy API key.
     * @param  boolean $return_match Whether the parts of the API key must be returned or not.
     * @return boolean               TRUE if the API key specified is valid, FALSE otherwise.
     */
    public static function is_valid_cloudproxy_key( $api_key='', $return_match=FALSE ){
        $pattern = '/^([a-z0-9]{32})\/([a-z0-9]{32})$/';

        if( $api_key && preg_match($pattern, $api_key, $match) ){
            if( $return_match ){ return $match; }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Call an action from the remote API interface of our WordPress service.
     *
     * @param  string  $method       HTTP method that will be used to send the request.
     * @param  array   $params       Parameters for the request defined in an associative array of key-value.
     * @param  boolean $send_api_key Whether the API key should be added to the request parameters or not.
     * @param  array   $args         Request arguments like the timeout, redirections, headers, cookies, etc.
     * @return array                 Array of results including HTTP headers or WP_Error if the request failed.
     */
    public static function api_call_wordpress( $method='GET', $params=array(), $send_api_key=TRUE, $args=array() ){
        $url = SUCURISCAN_API;
        $params[SUCURISCAN_API_VERSION] = 1;
        $params['p'] = 'wordpress';

        if( $send_api_key ){
            $api_key = self::get_plugin_key();

            if( !$api_key ){ return FALSE; }

            $params['k'] = $api_key;
        }

        $response = self::api_call( $url, $method, $params, $args );

        return $response;
    }

    /**
     * Call an action from the remote API interface of our CloudProxy service.
     *
     * @param  string $method HTTP method that will be used to send the request.
     * @param  array  $params Parameters for the request defined in an associative array of key-value.
     * @return array          Array of results including HTTP headers or WP_Error if the request failed.
     */
    public static function api_call_cloudproxy( $method='GET', $params=array() ){
        $send_request = FALSE;

        if( isset($params['k']) && isset($params['s']) ){
            $send_request = TRUE;
        } else {
            $api_key = self::get_cloudproxy_key();

            if( $api_key ){
                $send_request = TRUE;
                $params['k'] = $api_key['k'];
                $params['s'] = $api_key['s'];
            }
        }

        if( $send_request ){
            $url = SUCURISCAN_CLOUDPROXY_API;
            $params[SUCURISCAN_CLOUDPROXY_API_VERSION] = 1;

            $response = self::api_call( $url, $method, $params );

            return $response;
        }

        return FALSE;
    }

    /**
     * Determine whether an API response was successful or not checking the expected
     * generic variables and types, in case of an error a notification will appears
     * in the administrator panel explaining the result of the operation.
     *
     * @param  array   $response Array of results including HTTP headers or WP_Error if the request failed.
     * @return boolean           Either TRUE or FALSE in case of success or failure of the API response (respectively).
     */
    private static function handle_response( $response=array() ){
        if( $response ){
            if( $response['body'] instanceof stdClass ){
                if( isset($response['body']->status) ){
                    if( $response['body']->status == 1 ){
                        return TRUE;
                    } else {
                        $action_message = 'Unknown error, there is no more information.';

                        if ( isset($response['body']->messages[0]) ) {
                            $action_message = $response['body']->messages[0];
                        }

                        SucuriScanInterface::error( ucwords($response['body']->action) . ': ' . $action_message );
                    }
                } else {
                    SucuriScanInterface::error( 'Could not determine the status of an API call.' );
                }
            } else {
                SucuriScanInterface::error( 'Unknown API content-type, it was not a JSON-encoded response.' );
            }
        }

        return FALSE;
    }

    /**
     * Send a request to the API to register this site.
     *
     * @return boolean TRUE if the API key was generated, FALSE otherwise.
     */
    public static function register_site(){
        $response = self::api_call_wordpress( 'POST', array(
            'e' => self::get_site_email(),
            's' => self::get_domain(),
            'a' => 'register_site',
        ), FALSE );

        if( self::handle_response($response) ){
            self::set_plugin_key( $response['body']->output->api_key );
            SucuriScanEvent::schedule_task();
            SucuriScanEvent::notify_event( 'plugin_change', 'Site registered and API key generated' );
            SucuriScanInterface::info( 'The API key for your site was successfully generated and saved.');

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Send a request to recover a previously registered API key.
     *
     * @return boolean TRUE if the API key was sent to the administrator email, FALSE otherwise.
     */
    public static function recover_key(){
        $clean_domain = self::get_domain();

        $response = self::api_call_wordpress( 'GET', array(
            'e' => self::get_site_email(),
            's' => $clean_domain,
            'a' => 'recover_key',
        ), FALSE );

        if( self::handle_response($response) ){
            SucuriScanEvent::notify_event( 'plugin_change', 'API key recovered for domain: ' . $clean_domain );
            SucuriScanInterface::info( $response['body']->output->message );

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Send a request to the API to store and analyze the events of the site. An
     * event can be anything from a simple request, an internal modification of the
     * settings or files in the administrator panel, or a notification generated by
     * this plugin.
     *
     * @param  string  $event The information gathered through out the normal functioning of the site.
     * @return boolean        TRUE if the event was logged in the monitoring service, FALSE otherwise.
     */
    public static function send_log( $event='' ){
        if( !empty($event) ){
            $response = self::api_call_wordpress( 'POST', array(
                'a' => 'send_log',
                'm' => $event,
            ), TRUE, array( 'timeout' => 20 ) );

            if( self::handle_response($response) ){
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Retrieve the event logs registered by the API service.
     *
     * @param  integer $lines How many lines from the log file will be retrieved.
     * @return string         The response of the API service.
     */
    public static function get_logs( $lines=50 ){
        $response = self::api_call_wordpress( 'GET', array(
            'a' => 'get_logs',
            'l' => $lines,
        ) );

        if( self::handle_response($response) ){
            $response['body']->output_data = array();
            $log_pattern = '/^([0-9-: ]+) (.*) : (.*)/';
            $extra_pattern = '/(.+ \(multiple entries\):) (.+)/';

            foreach( $response['body']->output as $log ){
                if( preg_match($log_pattern, $log, $log_match) ){
                    $log_data = array(
                        'datetime' => $log_match[1],
                        'timestamp' => strtotime($log_match[1]),
                        'account' => $log_match[2],
                        'message' => $log_match[3],
                        'extra' => FALSE,
                        'extra_total' => 0,
                    );

                    $log_data['message'] = str_replace( ', new size', '; new size', $log_data['message'] );

                    if( preg_match($extra_pattern, $log_data['message'], $log_extra) ){
                        $log_data['message'] = $log_extra[1];
                        $log_data['extra'] = explode(',', $log_extra[2]);
                        $log_data['extra_total'] = count($log_data['extra']);
                    }

                    $response['body']->output_data[] = $log_data;
                }
            }

            return $response['body'];
        }

        return FALSE;
    }

    /**
     * Send a request to the API to store and analyze the file's hashes of the site.
     * This will be the core of the monitoring tools and will enhance the
     * information of the audit logs alerting the administrator of suspicious
     * changes in the system.
     *
     * @param  string  $hashes The information gathered after the scanning of the site's files.
     * @return boolean         TRUE if the hashes were stored, FALSE otherwise.
     */
    public static function send_hashes( $hashes='' ){
        if( !empty($hashes) ){
            $response = self::api_call_wordpress( 'POST', array(
                'a' => 'send_hashes',
                'h' => $hashes,
            ) );

            if( self::handle_response($response) ){
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Retrieve the public settings of the account associated with the API keys
     * registered by the administrator of the site. This function will send a HTTP
     * request to the remote API service and process its response, when successful
     * it will return an array/object containing the public attributes of the site.
     *
     * @param  boolean $api_key The CloudProxy API key.
     * @return array            A hash with the settings of a CloudProxy account.
     */
    public static function get_cloudproxy_settings( $api_key=FALSE ){
        $params = array( 'a' => 'show_settings' );

        if( $api_key ){
            $params = array_merge( $params, $api_key );
        }

        $response = self::api_call_cloudproxy( 'GET', $params );

        if( self::handle_response($response) ){
            return $response['body']->output;
        }

        return FALSE;
    }

    /**
     * Flush the cache of the site(s) associated with the API key.
     *
     * @param  boolean $api_key The CloudProxy API key.
     * @return string           Message explaining the result of the operation.
     */
    public static function clear_cloudproxy_cache( $api_key=FALSE ){
        $params = array( 'a' => 'clear_cache' );

        if( $api_key ){
            $params = array_merge( $params, $api_key );
        }

        $response = self::api_call_cloudproxy( 'GET', $params );

        if( self::handle_response($response) ){
            return $response['body'];
        }

        return FALSE;
    }

    /**
     * Retrieve the audit logs of the account associated with the API keys
     * registered b the administrator of the site. This function will send a HTTP
     * request to the remote API service and process its response, when successful
     * it will return an array/object containing a list of requests blocked by our
     * CloudProxy.
     *
     * By default the logs that will be retrieved are from today, if you need to see
     * the logs of previous days you will need to add a new parameter to the request
     * URL named "date" with format yyyy-mm-dd.
     *
     * @param  boolean $api_key The CloudProxy API key.
     * @param  string  $date    An optional date to filter the result to a specific timespan: yyyy-mm-dd.
     * @return array            A list of objects with the detailed version of each request blocked by our service.
     */
    public static function get_cloudproxy_logs( $api_key=FALSE, $date='' ){
        $params = array(
            'a' => 'audit_trails',
            'date' => date('Y-m-d'),
        );

        if( preg_match('/^[0-9]{4}(\-[0-9]{2}){2}$/', $date) ){
            $params['date'] = $date;
        }

        if( $api_key ){
            $params = array_merge( $params, $api_key );
        }

        $response = self::api_call_cloudproxy( 'GET', $params );

        if( self::handle_response($response) ){
            return $response['body']->output;
        }

        return FALSE;
    }

    /**
     * Scan a website through the public SiteCheck API [1] for known malware,
     * blacklisting status, website errors, and out-of-date software.
     *
     * [1] http://sitecheck.sucuri.net/
     *
     * @param  string $domain The clean version of the website's domain.
     * @return object         Serialized data of the scanning results for the site specified.
     */
    public static function get_sitecheck_results( $domain='' ){
        if( !empty($domain) ){
            $url = 'http://sitecheck.sucuri.net/';
            $response = self::api_call( $url, 'GET', array(
                'scan' => $domain,
                'fromwp' => 2,
                'clear' => 1,
                'json' => 1,
            ), array(
                'assoc' => TRUE
            ));

            if( $response ){
                return $response['body'];
            }
        }

        return FALSE;
    }

    /**
     * Retrieve a new set of keys for the WordPress configuration file using the
     * official API provided by WordPress itself.
     *
     * @return array A list of the new set of keys generated by WordPress API.
     */
    public static function get_new_secret_keys(){
        $pattern = self::secret_key_pattern();
        $response = self::api_call( 'https://api.wordpress.org/secret-key/1.1/salt/', 'GET' );

        if( $response && preg_match_all($pattern, $response['body'], $match) ){
            $new_keys = array();

            foreach( $match[1] as $i => $value ){
                $new_keys[$value] = $match[3][$i];
            }

            return $new_keys;
        }

        return FALSE;
    }

    /**
     * Retrieve a list with the checksums of the files in a specific version of WordPress.
     *
     * @see Release Archive http://wordpress.org/download/release-archive/
     *
     * @param  integer $version Valid version number of the WordPress project.
     * @return object           Associative object with the relative filepath and the checksums of the project files.
     */
    public static function get_official_checksums( $version=0 ){
        $url = 'http://api.wordpress.org/core/checksums/1.0/';
        $language = 'en_US'; /* WPLANG does not works. */
        $response = self::api_call( $url, 'GET', array(
            'version' => $version,
            'locale' => $language,
        ));

        if( $response ){
            if( $response['body'] instanceof stdClass ){
                $json_data = $response['body'];
            } else {
                $json_data = @json_decode($response['body']);
            }

            if(
                isset($json_data->checksums)
                && !empty($json_data->checksums)
            ){
                $checksums = $json_data->checksums;

                // Convert the object list to an array for better handle of the data.
                if( $checksums instanceof stdClass ){
                    $checksums = (array) $checksums;
                }

                return $checksums;
            }
        }

        return FALSE;
    }

    /**
     * Check the plugins directory and retrieve all plugin files with plugin data.
     * This function will also retrieve the URL and name of the repository/page
     * where it is being published at the WordPress plugins market.
     *
     * @return array Key is the plugin file path and the value is an array of the plugin data.
     */
    public static function get_plugins(){
        // Check if the cache library was loaded.
        $can_cache = class_exists('SucuriScanCache');

        if( $can_cache ){
            $cache = new SucuriScanCache('plugindata');
            $cached_data = $cache->get( 'plugins', SUCURISCAN_GET_PLUGINS_LIFETIME, 'array' );

            // Return the previously cached results of this function.
            if( $cached_data !== FALSE ){
                return $cached_data;
            }
        }

        // Get the plugin's basic information from WordPress transient data.
        $plugins = get_plugins();
        $pattern = '/^http(s)?:\/\/wordpress\.org\/plugins\/(.*)\/$/';
        $wp_market = 'https://wordpress.org/plugins/%s/';

        // Loop through each plugin data and complement its information with more attributes.
        foreach( $plugins as $plugin_path => $plugin_data ){
            // Default values for the plugin extra attributes.
            $repository = '';
            $repository_name = '';
            $is_free_plugin = FALSE;

            // If the plugin's info object has already a plugin_uri.
            if(
                isset($plugin_data['PluginURI'])
                && preg_match($pattern, $plugin_data['PluginURI'], $match)
            ){
                $repository = $match[0];
                $repository_name = $match[2];
                $is_free_plugin = TRUE;
            }

            // Retrieve the WordPress plugin page from the plugin's filename.
            else {
                if( strpos($plugin_path, '/') !== FALSE ){
                    $plugin_path_parts = explode('/', $plugin_path, 2);
                } else {
                    $plugin_path_parts = explode('.', $plugin_path, 2);
                }

                if( isset($plugin_path_parts[0]) ){
                    $possible_repository = sprintf($wp_market, $plugin_path_parts[0]);
                    $resp = wp_remote_head($possible_repository);

                    if(
                        !is_wp_error($resp)
                        && $resp['response']['code'] == 200
                    ){
                        $repository = $possible_repository;
                        $repository_name = $plugin_path_parts[0];
                        $is_free_plugin = TRUE;
                    }
                }
            }

            // Complement the plugin's information with these attributes.
            $plugins[$plugin_path]['Repository'] = $repository;
            $plugins[$plugin_path]['RepositoryName'] = $repository_name;
            $plugins[$plugin_path]['IsFreePlugin'] = $is_free_plugin;
            $plugins[$plugin_path]['PluginType'] = ( $is_free_plugin ? 'free' : 'premium' );
            $plugins[$plugin_path]['IsPluginActive'] = FALSE;

            if( is_plugin_active($plugin_path) ){
                $plugins[$plugin_path]['IsPluginActive'] = TRUE;
            }
        }

        if( $can_cache ){
            // Add the information of the plugins to the file-based cache.
            $cache->add( 'plugins', $plugins );
        }

        return $plugins;
    }

    /**
     * Retrieve plugin installer pages from WordPress Plugins API.
     *
     * It is possible for a plugin to override the Plugin API result with three
     * filters. Assume this is for plugins, which can extend on the Plugin Info to
     * offer more choices. This is very powerful and must be used with care, when
     * overriding the filters.
     *
     * The first filter, 'plugins_api_args', is for the args and gives the action as
     * the second parameter. The hook for 'plugins_api_args' must ensure that an
     * object is returned.
     *
     * The second filter, 'plugins_api', is the result that would be returned.
     *
     * @param  string $plugin Frienly name of the plugin.
     * @return object         Object on success, WP_Error on failure.
     */
    public static function get_remote_plugin_data( $plugin='' ){
        if( !empty($plugin) ){
            $url = sprintf( 'http://api.wordpress.org/plugins/info/1.0/%s/', $plugin );
            $response = self::api_call( $url, 'GET' );

            if( $response ){
                if( $response['body'] instanceof stdClass ){
                    return $response['body'];
                }
            }
        }

        return FALSE;
    }

    /**
     * Retrieve a specific file from the official WordPress subversion repository,
     * the content of the file is determined by the tags defined using the site
     * version specified. Only official core files are allowed to fetch.
     *
     * @see http://core.svn.wordpress.org/
     * @see http://i18n.svn.wordpress.org/
     * @see http://core.svn.wordpress.org/tags/VERSION_NUMBER/
     *
     * @param  string $filepath Relative file path of a project core file.
     * @param  string $version  Optional site version, default will be the global version number.
     * @return string           Full content of the official file retrieved, FALSE if the file was not found.
     */
    public static function get_original_core_file( $filepath='', $version=0 ){
        if( !empty($filepath) ){
            if( $version == 0 ){
                $version = self::site_version();
            }

            $url = sprintf( 'http://core.svn.wordpress.org/tags/%s/%s', $version, $filepath );
            $response = self::api_call( $url, 'GET' );

            if( $response ){
                if(
                    isset($response['headers']['content-length'])
                    && $response['headers']['content-length'] > 0
                    && is_string($response['body'])
                ){
                    return $response['body'];
                }
            }
        }

        return FALSE;
    }

}

/**
 * Process and send emails.
 *
 * One of the core features of the plugin is the event alerts, a list of rules
 * will check if the site is being compromised, in which case a notification
 * will be sent to the site email address (an address that can be configured in
 * the settings page).
 */
class SucuriScanMail extends SucuriScanOption {

    /**
     * Check whether the email notifications will be sent in HTML or Plain/Text.
     *
     * @return boolean Whether the emails will be in HTML or Plain/Text.
     */
    public static function prettify_mails(){
        return ( self::get_option(':prettify_mails') === 'enabled' );
    }

    /**
     * Send a message to a specific email address.
     *
     * @param  string  $email    The email address of the recipient that will receive the message.
     * @param  string  $subject  The reason of the message that will be sent.
     * @param  string  $message  Body of the message that will be sent.
     * @param  array   $data_set Optional parameter to add more information to the notification.
     * @return boolean           Whether the email contents were sent successfully.
     */
    public static function send_mail( $email='', $subject='', $message='', $data_set=array() ){
        $headers = array();
        $subject = ucwords(strtolower($subject));
        $force = FALSE;
        $debug = FALSE;

        // Check whether the mail will be printed in the site instead of sent.
        if(
            isset($data_set['Debug'])
            && $data_set['Debug'] == TRUE
        ){
            $debug = TRUE;
            unset($data_set['Debug']);
        }

        // Check whether the mail will be even if the limit per hour was reached or not.
        if(
            isset($data_set['Force'])
            && $data_set['Force'] == TRUE
        ){
            $force = TRUE;
            unset($data_set['Force']);
        }

        // Check whether the email notifications will be sent in HTML or Plain/Text.
        if( self::prettify_mails() ){
            $headers = array( 'content-type: text/html' );
            $data_set['PrettifyType'] = 'pretty';
        } else {
            $message = strip_tags($message);
        }

        if( !self::emails_per_hour_reached() || $force || $debug ){
            $message = self::prettify_mail($subject, $message, $data_set);

            if( $debug ){ die($message); }

            $subject = self::get_email_subject($subject);
            $mail_sent = wp_mail( $email, $subject, $message, $headers );

            if( $mail_sent ){
                $emails_sent_num = (int) self::get_option(':emails_sent');
                self::update_option( ':emails_sent', $emails_sent_num + 1 );
                self::update_option( ':last_email_at', time() );

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Generate a subject for the email alerts.
     *
     * @param  string $event The reason of the message that will be sent.
     * @return string        A text with the subject for the email alert.
     */
    private static function get_email_subject( $event='' ){
        $domain_name = self::get_domain();
        $remote_addr = self::get_remote_addr();
        $email_subject = self::get_option(':email_subject');

        if ( $email_subject ) {
            $email_subject = str_replace(
                array( ':domain', ':event', ':remoteaddr' ),
                array( $domain_name, $event, $remote_addr ),
                strip_tags($email_subject)
            );

            return $email_subject;
        }

        /**
         * Probably a bad value in the options table. Delete the entry from the database
         * and call this function to try again, it will probably fall in an infinite
         * loop, but this is the easiest way to control this procedure.
         */
        else {
            self::delete_option(':email_subject');
            return self::get_email_subject($event);
        }
    }

    /**
     * Generate a HTML version of the message that will be sent through an email.
     *
     * @param  string $subject  The reason of the message that will be sent.
     * @param  string $message  Body of the message that will be sent.
     * @param  array  $data_set Optional parameter to add more information to the notification.
     * @return string           The message formatted in a HTML template.
     */
    private static function prettify_mail( $subject='', $message='', $data_set=array() ){
        $prettify_type = isset($data_set['PrettifyType']) ? $data_set['PrettifyType'] : 'simple';
        $template_name = 'notification-' . $prettify_type;
        $user = wp_get_current_user();
        $display_name = '';

        if(
            $user instanceof WP_User
            && isset($user->user_login)
            && !empty($user->user_login)
        ){
            $display_name = sprintf( 'User: %s (%s)', $user->display_name, $user->user_login );
        }

        $mail_variables = array(
            'TemplateTitle' => 'Sucuri Alert',
            'Subject' => $subject,
            'Website' => self::get_option('siteurl'),
            'RemoteAddress' => self::get_remote_addr(),
            'Message' => $message,
            'User' => $display_name,
            'Time' => SucuriScan::current_datetime(),
        );

        foreach( $data_set as $var_key => $var_value ){
            $mail_variables[$var_key] = $var_value;
        }

        return SucuriScanTemplate::get_section( $template_name, $mail_variables );
    }

    /**
     * Check whether the maximum quantity of emails per hour was reached.
     *
     * @return boolean Whether the quota emails per hour was reached.
     */
    private static function emails_per_hour_reached(){
        $max_per_hour = self::get_option(':emails_per_hour');

        if( $max_per_hour != 'unlimited' ){
            // Check if we are still in that sixty minutes.
            $current_time = time();
            $last_email_at = self::get_option(':last_email_at');
            $diff_time = abs( $current_time - $last_email_at );

            if( $diff_time <= 3600 ){
                // Check if the quantity of emails sent is bigger than the configured.
                $emails_sent = (int) self::get_option(':emails_sent');
                $max_per_hour = intval($max_per_hour);

                if( $emails_sent >= $max_per_hour ){
                    return TRUE;
                }
            } else {
                // Reset the counter of emails sent.
                self::update_option( ':emails_sent', 0 );
            }
        }

        return FALSE;
    }

}

/**
 * Read, parse and handle everything related with the templates.
 *
 * A web template system uses a template processor to combine web templates to
 * form finished web pages, possibly using some data source to customize the
 * pages or present a large amount of content on similar-looking pages. It is a
 * web publishing tool present in content management systems, web application
 * frameworks, and HTML editors.
 *
 * Web templates can be used like the template of a form letter to either
 * generate a large number of "static" (unchanging) web pages in advance, or to
 * produce "dynamic" web pages on demand.
 */
class SucuriScanTemplate extends SucuriScanRequest {

    /**
     * Replace all pseudo-variables from a string of characters.
     *
     * @param  string $content The content of a template file which contains pseudo-variables.
     * @param  array  $params  List of pseudo-variables that will be replaced in the template.
     * @return string          The content of the template with the pseudo-variables replated.
     */
    private static function replace_pseudovars( $content='', $params=array() ){
        if( is_array($params) ){
            foreach( $params as $tpl_key => $tpl_value ){
                $tpl_key = '%%SUCURI.' . $tpl_key . '%%';
                $content = str_replace( $tpl_key, $tpl_value, $content );
            }

            return $content;
        }

        return FALSE;
    }

    /**
     * Gather and generate the information required globally by all the template files.
     *
     * @param  array $params A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return array         A complementary list of pseudo-variables for the template files.
     */
    private static function shared_params( $params=array() ){
        $params = is_array($params) ? $params : array();

        // Base parameters, required to render all the pages.
        $params = self::links_and_navbar($params);

        // Global parameters, used through out all the pages.
        $params['PageTitle'] = isset($params['PageTitle']) ? '('.$params['PageTitle'].')' : '';
        $params['PageNonce'] = wp_create_nonce('sucuriscan_page_nonce');
        $params['PageStyleClass'] = isset($params['PageStyleClass']) ? $params['PageStyleClass'] : 'base';
        $params['CleanDomain'] = self::get_domain();
        $params['AdminEmail'] = self::get_site_email();

        return $params;
    }

    /**
     * Return a string indicating the visibility of a HTML component.
     *
     * @param  boolean $visible Whether the condition executed returned a positive value or not.
     * @return string           A string indicating the visibility of a HTML component.
     */
    public static function visibility( $visible=FALSE ){
        return ( $visible === TRUE ? 'visible' : 'hidden' );
    }

    /**
     * Generate an URL pointing to the page indicated in the function and that must
     * be loaded through the administrator panel.
     *
     * @param  string $page Short name of the page that will be generated.
     * @return string       Full string containing the link of the page.
     */
    public static function get_url( $page='' ){
        $url_path = admin_url('admin.php?page=sucuriscan');

        if( !empty($page) ){
            $url_path .= '_' . strtolower($page);
        }

        return $url_path;
    }

    /**
     * Complement the list of pseudo-variables that will be used in the base
     * template files, this will also generate the navigation bar and detect which
     * items in it are selected by the current page.
     *
     * @param  array  $params A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return array          A complementary list of pseudo-variables for the template files.
     */
    private static function links_and_navbar( $params=array() ){
        global $sucuriscan_pages;

        $params = is_array($params) ? $params : array();
        $sub_pages = is_array($sucuriscan_pages) ? $sucuriscan_pages : array();

        $params['Navbar'] = '';
        $params['CurrentPageFunc'] = '';

        if( $_page = self::get('page', '_page') ){
            $params['CurrentPageFunc'] = $_page;
        }

        foreach( $sub_pages as $sub_page_func => $sub_page_title ){
            if (
                $sub_page_func == 'sucuriscan_scanner'
                && self::is_sitecheck_disabled()
            ) {
                continue;
            }

            $func_parts = explode( '_', $sub_page_func, 2 );

            if( isset($func_parts[1]) ){
                $unique_name = $func_parts[1];
                $pseudo_var = 'URL.' . ucwords($unique_name);
            } else {
                $unique_name = '';
                $pseudo_var = 'URL.Home';
            }

            $params[$pseudo_var] = self::get_url($unique_name);

            $navbar_item_css_class = 'nav-tab';

            if( $params['CurrentPageFunc'] == $sub_page_func ){
                $navbar_item_css_class .= chr(32) . 'nav-tab-active';
            }

            $params['Navbar'] .= sprintf(
                '<a class="%s" href="%s">%s</a>' . "\n",
                $navbar_item_css_class,
                $params[$pseudo_var],
                $sub_page_title
            );
        }

        return $params;
    }

    /**
     * Generate a HTML code using a template and replacing all the pseudo-variables
     * by the dynamic variables provided by the developer through one of the parameters
     * of the function.
     *
     * @param  string $html   The HTML content of a template file with its pseudo-variables parsed.
     * @param  array  $params A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return string         The formatted HTML content of the base template.
     */
    public static function get_base_template( $html='', $params=array() ){
        $params = is_array($params) ? $params : array();

        $params = self::shared_params($params);
        $params['PageContent'] = $html;

        return self::get_template( 'base', $params );
    }

    /**
     * Generate a HTML code using a template and replacing all the pseudo-variables
     * by the dynamic variables provided by the developer through one of the parameters
     * of the function.
     *
     * @param  string  $template Filename of the template that will be used to generate the page.
     * @param  array   $params   A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @param  boolean $type     Either page, section or snippet indicating the type of template that will be retrieved.
     * @return string            The formatted HTML page after replace all the pseudo-variables.
     */
    public static function get_template( $template='', $params=array(), $type='page' ){
        switch( $type ){
            case 'page': /* no_break */
            case 'section':
                $template_path_pattern = '%s/%s/inc/tpl/%s.html.tpl';
                break;
            case 'snippet':
                $template_path_pattern = '%s/%s/inc/tpl/%s.snippet.tpl';
                break;
        }

        $template_content = '';
        $template_path =  sprintf( $template_path_pattern, WP_PLUGIN_DIR, SUCURISCAN_PLUGIN_FOLDER, $template );
        $params = is_array($params) ? $params : array();

        if( file_exists($template_path) && is_readable($template_path) ){
            $template_content = @file_get_contents($template_path);

            $params['SucuriURL'] = SUCURISCAN_URL;

            // Detect the current page URL.
            if( $_page = self::get('page', '_page') ){
                $params['CurrentURL'] = admin_url('admin.php?page=' . $_page);
            } else {
                $params['CurrentURL'] = admin_url();
            }

            // Replace the global pseudo-variables in the section/snippets templates.
            if(
                $template == 'base'
                && isset($params['PageContent'])
                && preg_match('/%%SUCURI\.(.+)%%/', $params['PageContent'])
            ){
                $params['PageContent'] = self::replace_pseudovars( $params['PageContent'], $params );
            }

            $template_content = self::replace_pseudovars( $template_content, $params );
        }

        if( $template == 'base' || $type != 'page' ){
            return $template_content;
        }

        return self::get_base_template( $template_content, $params );
    }

    /**
     * Generate a HTML code using a template and replacing all the pseudo-variables
     * by the dynamic variables provided by the developer through one of the parameters
     * of the function.
     *
     * @param  string $template Filename of the template that will be used to generate the page.
     * @param  array  $params   A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return string           The formatted HTML page after replace all the pseudo-variables.
     */
    public static function get_section($template='', $params=array()){
        $params = self::shared_params($params);

        return self::get_template( $template, $params, 'section' );
    }

    /**
     * Generate a HTML code using a template and replacing all the pseudo-variables
     * by the dynamic variables provided by the developer through one of the parameters
     * of the function.
     *
     * @param  string $template Filename of the template that will be used to generate the page.
     * @param  array  $params   A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return string           The formatted HTML page after replace all the pseudo-variables.
     */
    public static function get_modal($template='', $params=array()){
        $required = array(
            'Title' => 'Lorem ipsum dolor sit amet',
            'CssClass' => '',
            'Content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
        );

        if( !empty($template) && $template != 'none' ){
            $params['Content'] = self::get_section($template);
        }

        foreach( $required as $param_name => $param_value ){
            if( !isset($params[$param_name]) ){
                $params[$param_name] = $param_value;
            }
        }

        $params = self::shared_params($params);

        return self::get_template( 'modalwindow', $params, 'section' );
    }

    /**
     * Generate a HTML code using a template and replacing all the pseudo-variables
     * by the dynamic variables provided by the developer through one of the parameters
     * of the function.
     *
     * @param  string $template Filename of the template that will be used to generate the page.
     * @param  array  $params   A hash containing the pseudo-variable name as the key and the value that will replace it.
     * @return string           The formatted HTML page after replace all the pseudo-variables.
     */
    public static function get_snippet($template='', $params=array()){
        return self::get_template( $template, $params, 'snippet' );
    }

    /**
     * Generate the HTML code necessary to render a list of options in a form.
     *
     * @param  array  $allowed_values List with keys and values allowed for the options.
     * @param  string $selected_val   Value of the option that will be selected by default.
     * @return string                 Option list for a select form field.
     */
    public static function get_select_options( $allowed_values=array(), $selected_val='' ){
        $options = '';

        foreach( $allowed_values as $option_name => $option_label ){
            $selected_str = '';

            if( $option_name == $selected_val ){
                $selected_str = 'selected="selected"';
            }

            $options .= sprintf(
                '<option value="%s" %s>%s</option>',
                $option_name, $selected_str, $option_label
            );
        }

        return $options;
    }

    /**
     * Detect which number in a pagination was clicked.
     *
     * @return integer Page number of the link clicked in a pagination.
     */
    public static function get_page_number(){
        $num = self::get( 'num', '[0-9]{1,2}' );

        return ( $num ? intval($num) : 1 );
    }

    /**
     * Generate the HTML code to display a pagination.
     *
     * @param  string  $base_url     Base URL for the links before the page number.
     * @param  integer $total_items  Total quantity of items retrieved from a query.
     * @param  integer $max_per_page Maximum number of items that will be shown per page.
     * @return string                HTML code for a pagination generated using the provided data.
     */
    public static function get_pagination( $base_url='', $total_items=0, $max_per_page=1 ){
        // Calculate the number of links for the pagination.
        $html_links = '';
        $page_number = self::get_page_number();
        $max_pages = ceil($total_items / $max_per_page);

        // Generate the HTML links for the pagination.
        for( $j=1; $j<=$max_pages; $j++ ){
            $link_class = 'sucuriscan-pagination-link';

            if( $page_number == $j ){
                $link_class .= chr(32) . 'sucuriscan-pagination-active';
            }

            $html_links .= sprintf(
                '<li><a href="%s&num=%d" class="%s">%s</a></li>',
                $base_url, $j, $link_class, $j
            );
        }

        return $html_links;
    }

    /**
     * Check whether the SiteCheck scanner and the malware scan page are disabled.
     *
     * @return boolean TRUE if the SiteCheck scanner and malware scan page are disabled.
     */
    public static function is_sitecheck_disabled(){
        return (bool) ( SucuriScanOption::get_option(':sitecheck_scanner') === 'disabled' );
    }

    /**
     * Check whether the SiteCheck scanner and the malware scan page are enabled.
     *
     * @return boolean TRUE if the SiteCheck scanner and malware scan page are enabled.
     */
    public static function is_sitecheck_enabled(){
        return (bool) ( SucuriScanOption::get_option(':sitecheck_scanner') !== 'disabled' );
    }

}

/**
 * File System Scanner
 *
 * The File System Scanner component performs full and incremental scans over a
 * file system folder, maintaining a snapshot of the filesystem and comparing it
 * with the current content to establish what content has been updated. Updated
 * content is then submitted to the remote server and it is stored for future
 * analysis.
 */
class SucuriScanFSScanner extends SucuriScan {

    /**
     * Retrieve the last time when the filesystem scan was ran.
     *
     * @param  boolean $format Whether the timestamp must be formatted as date/time or not.
     * @return string          The timestamp of the runtime, or an string with the date/time.
     */
    public static function get_filesystem_runtime( $format=FALSE ){
        $runtime = SucuriScanOption::get_option(':runtime');

        if( $runtime > 0 ){
            if( $format ){
                return SucuriScan::datetime($runtime);
            }

            return $runtime;
        }

        if( $format ){
            return '<em>Unknown</em>';
        }

        return FALSE;
    }

    /**
     * Check whether the administrator enabled the feature to ignore some
     * directories during the file system scans. This function is overwritten by a
     * GET parameter in the settings page named no_scan which must be equal to the
     * number one.
     *
     * @return boolean Whether the feature to ignore files is enabled or not.
     */
    public static function will_ignore_scanning(){
        return ( SucuriScanOption::get_option(':ignore_scanning') === 'enabled' );
    }

    /**
     * Add a new directory path to the list of ignored paths.
     *
     * @param  string  $directory_path The (full) absolute path of a directory.
     * @return boolean                 TRUE if the directory path was added to the list, FALSE otherwise.
     */
    public static function ignore_directory( $directory_path='' ){
        $cache = new SucuriScanCache('ignorescanning');

        // Use the checksum of the directory path as the cache key.
        $cache_key = md5($directory_path);
        $cache_value = array(
            'directory_path' => $directory_path,
            'ignored_at' => self::local_time(),
        );
        $cached = $cache->add( $cache_key, $cache_value );

        return $cached;
    }

    /**
     * Remove a directory path from the list of ignored paths.
     *
     * @param  string  $directory_path The (full) absolute path of a directory.
     * @return boolean                 TRUE if the directory path was removed to the list, FALSE otherwise.
     */
    public static function unignore_directory( $directory_path='' ){
        $cache = new SucuriScanCache('ignorescanning');

        // Use the checksum of the directory path as the cache key.
        $cache_key = md5($directory_path);
        $removed = $cache->delete($cache_key);

        return $removed;
    }

    /**
     * Retrieve a list of directories ignored.
     *
     * Retrieve a list of directory paths that will be ignored during the file
     * system scans, any sub-directory and files inside these folders will be
     * skipped automatically and will not be used to detect malware or modifications
     * in the site.
     *
     * The structure of the array returned by the function will always be composed
     * by four (4) indexes which will facilitate the execution of common conditions
     * in the implementation code.
     *
     * <ul>
     * <li>raw: Will contains the raw data retrieved from the built-in cache system.</li>
     * <li>checksums: Will contains the md5 of all the directory paths.</li>
     * <li>directories: Will contains a list of directory paths.</li>
     * <li>ignored_at_list: Will contains a list of timestamps for when the directories were ignored.</li>
     * </ul>
     *
     * @return array List of ignored directory paths.
     */
    public static function get_ignored_directories(){
        $response = array(
            'raw' => array(),
            'checksums' => array(),
            'directories' => array(),
            'ignored_at_list' => array(),
        );

        $cache = new SucuriScanCache('ignorescanning');
        $cache_lifetime = 0; // It is not necessary to expire this cache.
        $ignored_directories = $cache->get_all( $cache_lifetime, 'array' );

        if( $ignored_directories ){
            $response['raw'] = $ignored_directories;

            foreach( $ignored_directories as $checksum => $data ){
                $response['checksums'][] = $checksum;
                $response['directories'][] = $data['directory_path'];
                $response['ignored_at_list'][] = $data['ignored_at'];
            }
        }

        return $response;
    }

    /**
     * Run file system scan and retrieve ignored folders.
     *
     * Run a file system scan and retrieve an array with two indexes, the first
     * containing a list of ignored directory paths and their respective timestamps
     * of when they were added by an administrator user, and the second containing a
     * list of directories that are not being ignored.
     *
     * @return array List of ignored and not ignored directories.
     */
    public static function get_ignored_directories_live(){
        $response = array(
            'is_ignored' => array(),
            'is_not_ignored' => array(),
        );

        // Get the ignored directories from the cache.
        $ignored_directories = self::get_ignored_directories();

        if( $ignored_directories ){
            $response['is_ignored'] = $ignored_directories['raw'];
        }

        // Scan the project and file all directories.
        $sucuri_fileinfo = new SucuriScanFileInfo();
        $sucuri_fileinfo->ignore_files = TRUE;
        $sucuri_fileinfo->ignore_directories = TRUE;
        $sucuri_fileinfo->scan_interface = SucuriScanOption::get_option(':scan_interface');
        $directory_list = $sucuri_fileinfo->get_diretories_only(ABSPATH);

        if( $directory_list ){
            $response['is_not_ignored'] = $directory_list;
        }

        return $response;
    }

    /**
     * Read and parse the lines inside a PHP error log file.
     *
     * @param  array $error_logs The content of an error log file, or an array with the lines.
     * @return array             List of valid error logs with their attributes separated.
     */
    public static function parse_error_logs( $error_logs=array() ){
        $logs_arr = array();
        $pattern = '/^'
            . '(\[(\S+) ([0-9:]{5,8})( \S+)?\] )?'     // Detect date, time, and timezone.
            . '(PHP )?([a-zA-Z ]+):\s'                // Detect PHP error severity.
            . '(.+) in (.+)'                      // Detect error message, and file path.
            . '(:| on line )([0-9]+)'                 // Detect line number.
            . '$/';

        if ( is_string($error_logs) ) {
            $error_logs = explode( "\n", $error_logs );
        }

        foreach ( (array) $error_logs as $line ) {
            if ( !is_string($line) || empty($line) ) { continue; }

            if ( preg_match($pattern, $line, $match) ) {
                $data_set = array(
                    'date' => '',
                    'time' => '',
                    'timestamp' => 0,
                    'date_time' => '',
                    'time_zone' => '',
                    'error_type' => '',
                    'error_code' => 'unknown',
                    'error_message' => '',
                    'file_path' => '',
                    'line_number' => 0,
                );

                // Basic attributes from the scrapping.
                $data_set['date'] = $match[2];
                $data_set['time'] = $match[3];
                $data_set['time_zone'] = trim($match[4]);
                $data_set['error_type'] = trim($match[6]);
                $data_set['error_message'] = trim($match[7]);
                $data_set['file_path'] = trim($match[8]);
                $data_set['line_number'] = (int) $match[10];

                // Additional data from the attributes.
                if ( $data_set['date'] ) {
                    $data_set['date_time'] = $data_set['date']
                        . "\x20" . $data_set['time']
                        . "\x20" . $data_set['time_zone'];
                    $data_set['timestamp'] = strtotime( $data_set['date_time'] );
                }

                if ( $data_set['error_type'] ) {
                    $valid_types = array( 'warning', 'notice', 'error' );

                    foreach ( $valid_types as $valid_type ) {
                        if ( stripos($data_set['error_type'], $valid_type) !== FALSE ) {
                            $data_set['error_code'] = $valid_type;
                            break;
                        }
                    }
                }

                $logs_arr[] = (object) $data_set;
            }
        }

        return $logs_arr;
    }

}

/**
 * Heartbeat library.
 *
 * The purpose of the Heartbeat API is to simulate bidirectional connection
 * between the browser and the server. Initially it was used for autosave, post
 * locking and log-in expiration warning while a user is writing or editing. The
 * idea was to have an API that sends XHR (XML HTTP Request) requests to the
 * server every fifteen seconds and triggers events (or callbacks) on receiving
 * data.
 *
 * @see https://core.trac.wordpress.org/ticket/23216
 */
class SucuriScanHeartbeat extends SucuriScanOption {

    /**
     * Stop execution of the heartbeat API in certain parts of the site.
     *
     * @return void
     */
    public static function register_script(){
        global $pagenow;

        $status = SucuriScanOption::get_option(':heartbeat');

        // Enable heartbeat everywhere.
        if( $status == 'enabled' ){ /* do_nothing */ }

        // Disable heartbeat everywhere.
        elseif( $status == 'disabled' ){
            wp_deregister_script('heartbeat');
        }

        // Disable heartbeat only on the dashboard and home pages.
        elseif(
            $status == 'dashboard'
            && $pagenow == 'index.php'
        ){
            wp_deregister_script('heartbeat');
        }

        // Disable heartbeat everywhere except in post edition.
        elseif(
            $status == 'addpost'
            && $pagenow != 'post.php'
            && $pagenow != 'post-new.php'
        ){
            wp_deregister_script('heartbeat');
        }
    }

    /**
     * Update the settings of the Heartbeat API according to the values set by an
     * administrator. This tool may cause an increase in the CPU usage, a bad
     * configuration may cause low account to run out of resources, but in better
     * cases it may improve the performance of the site by reducing the quantity of
     * requests sent to the server per session.
     *
     * @param  array $settings Heartbeat settings.
     * @return array           Updated version of the heartbeat settings.
     */
    public static function update_settings( $settings=array() ){
        $pulse = SucuriScanOption::get_option(':heartbeat_pulse');
        $autostart = SucuriScanOption::get_option(':heartbeat_autostart');

        if( $pulse < 15 || $pulse > 60 ){
            SucuriScanOption::delete_option(':heartbeat_pulse');
            $pulse = 15;
        }

        $settings['interval'] = $pulse;
        $settings['autostart'] = ( $autostart == 'disabled' ? FALSE : TRUE );

        return $settings;
    }

    /**
     * Respond to the browser according to the data received.
     *
     * @param  array  $response  Response received.
     * @param  array  $data      Data received from the beat.
     * @param  string $screen_id Identifier of the screen the heartbeat occurred on.
     * @return array             Response with new data.
     */
    public static function respond_to_received( $response=array(), $data=array(), $screen_id='' ) {
        $interval = SucuriScanOption::get_option(':heartbeat_interval');

        if(
            $interval == 'slow'
            || $interval == 'fast'
            || $interval == 'standard'
        ){
            $response['heartbeat_interval'] = $interval;
        } else {
            SucuriScanOption::delete_option(':heartbeat_interval');
        }

        return $response;
    }

    /**
     * Respond to the browser according to the data sent.
     *
     * @param  array  $response  Response sent.
     * @param  string $screen_id Identifier of the screen the heartbeat occurred on.
     * @return array             Response with new data.
     */
    public static function respond_to_send( $response=array(), $screen_id='' ) {
        return $response;
    }

    /**
     * Allowed values for the heartbeat status.
     *
     * @return array Allowed values for the heartbeat status.
     */
    public static function statuses_allowed(){
        return array(
            'enabled' => 'Enable everywhere',
            'disabled' => 'Disable everywhere',
            'dashboard' => 'Disable on dashboard page',
            'addpost' => 'Everywhere except post addition',
        );
    }

    /**
     * Allowed values for the heartbeat intervals.
     *
     * @return array Allowed values for the heartbeat intervals.
     */
    public static function intervals_allowed(){
        return array(
            'slow' => 'Slow interval',
            'fast' => 'Fast interval',
            'standard' => 'Standard interval',
        );
    }

    /**
     * Allowed values for the heartbeat pulses.
     *
     * @return array Allowed values for the heartbeat pulses.
     */
    public static function pulses_allowed(){
        $pulses = array();

        for( $i=15; $i<=60; $i++ ){
            $pulses[$i] = sprintf( 'Run every %d seconds', $i );
        }

        return $pulses;
    }

}

/**
 * Plugin initializer.
 *
 * Define all the required variables, script, styles, and basic functions needed
 * when the site is loaded, not even the administrator panel but also the front
 * page, some bug-fixes will/are applied here for sites behind a proxy, and
 * sites with old versions of the premium plugin (that was deprecated at
 * July/2014).
 */
class SucuriScanInterface {

    /**
     * Initialization code for the plugin.
     *
     * The initial variables and information needed by the plugin during the
     * execution of other functions will be generated. Things like the real IP
     * address of the client when it has been forwarded or it's behind an external
     * service like a Proxy.
     *
     * @return void
     */
    public static function initialize(){
        if ( SucuriScan::is_behind_cloudproxy() ) {
            $_SERVER['SUCURIREAL_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
            $_SERVER['REMOTE_ADDR'] = SucuriScan::get_remote_addr();
        }
    }

    /**
     * Define which javascript and css files will be loaded in the header of the
     * plugin pages, only when the administrator panel is accessed.
     *
     * @return void
     */
    public static function enqueue_scripts(){
        $asset_version = '';

        if( strlen(SUCURISCAN_PLUGIN_CHECKSUM) >= 7 ){
            $asset_version = substr(SUCURISCAN_PLUGIN_CHECKSUM, 0, 7);
        }

        wp_register_style( 'sucuriscan', SUCURISCAN_URL . '/inc/css/sucuriscan-default-css.css', array(), $asset_version );
        wp_register_script( 'sucuriscan', SUCURISCAN_URL . '/inc/js/sucuriscan-scripts.js', array(), $asset_version );

        wp_enqueue_style( 'sucuriscan' );
        wp_enqueue_script( 'sucuriscan' );
    }

    /**
     * Generate the menu and submenus for the plugin in the admin interface.
     *
     * @return void
     */
    public static function add_interface_menu(){
        global $sucuriscan_pages;

        if(
            function_exists('add_menu_page')
            && $sucuriscan_pages
        ){
            // Add main menu link.
            add_menu_page(
                'Sucuri Security',
                'Sucuri Security',
                'manage_options',
                'sucuriscan',
                'sucuriscan_page',
                SUCURISCAN_URL . '/inc/images/menu-icon.png'
            );

            $sub_pages = is_array($sucuriscan_pages) ? $sucuriscan_pages : array();

            foreach( $sub_pages as $sub_page_func => $sub_page_title ){
                if (
                    $sub_page_func == 'sucuriscan_scanner'
                    && SucuriScanTemplate::is_sitecheck_disabled()
                ) {
                    continue;
                }

                $page_func = $sub_page_func . '_page';

                add_submenu_page(
                    'sucuriscan',
                    $sub_page_title,
                    $sub_page_title,
                    'manage_options',
                    $sub_page_func,
                    $page_func
                );
            }
        }
    }

    /**
     * Remove the old Sucuri plugins considering that with the new version (after
     * 1.6.0) all the functionality of the others will be merged here, this will
     * remove duplicated functionality, duplicated bugs and/or duplicated
     * maintenance reports allowing us to focus in one unique project.
     *
     * @return void
     */
    public static function handle_old_plugins(){
        if( class_exists('SucuriScanFileInfo') ){
            $sucuri_fileinfo = new SucuriScanFileInfo();
            $sucuri_fileinfo->ignore_files = FALSE;
            $sucuri_fileinfo->ignore_directories = FALSE;

            $plugins = array(
                'sucuri-wp-plugin/sucuri.php',
                'sucuri-cloudproxy-waf/cloudproxy.php',
            );

            foreach( $plugins as $plugin ){
                $plugin_directory = dirname( WP_PLUGIN_DIR . '/' . $plugin );

                if( file_exists($plugin_directory) ){
                    if( is_plugin_active($plugin) ){
                        deactivate_plugins($plugin);
                    }

                    $plugin_removed = $sucuri_fileinfo->remove_directory_tree($plugin_directory);
                }
            }
        }
    }

    /**
     * Create a folder in the WordPress upload directory where the plugin will
     * store all the temporal or dynamic information.
     *
     * @return void
     */
    public static function create_datastore_folder(){
        $plugin_upload_folder = SucuriScan::datastore_folder_path();

        if( !file_exists($plugin_upload_folder) ){
            if( @mkdir($plugin_upload_folder) ){
                // Create last-logins datastore file.
                sucuriscan_lastlogins_datastore_exists();

                // Create a htaccess file to deny access from all.
                @file_put_contents(
                    $plugin_upload_folder . '/.htaccess',
                    "Order Deny,Allow\nDeny from all\n",
                    LOCK_EX
                );

                // Create an index.html to avoid directory listing.
                @file_put_contents(
                    $plugin_upload_folder . '/index.html',
                    '<!-- Attemp to prevent the directory listing. -->',
                    LOCK_EX
                );
            } else {
                SucuriScanInterface::error(
                    'Data folder does not exists and could not be created. You will need to
                    create this folder manually and give it write permissions:<br><br><code>'
                    . $plugin_upload_folder . '</code>'
                );
            }
        }
    }

    /**
     * Check whether a user has the permissions to see a page from the plugin.
     *
     * @return void
     */
    public static function check_permissions(){
        if(
            !function_exists('current_user_can')
            || !current_user_can('manage_options')
        ){
            $page = SucuriScanRequest::get('page', '_page');
            wp_die(__('Access denied by <b>Sucuri</b> to see <code>' . $page . '</code>') );
        }
    }

    /**
     * Verify the nonce of the previous page after a form submission. If the
     * validation fails the execution of the script will be stopped and a dead page
     * will be printed to the client using the official WordPress method.
     *
     * @return boolean Either TRUE or FALSE if the nonce is valid or not respectively.
     */
    public static function check_nonce(){
        if( !empty($_POST) ){
            $nonce_name = 'sucuriscan_page_nonce';
            $nonce_value = SucuriScanRequest::post($nonce_name, '_nonce');

            if( !$nonce_value || !wp_verify_nonce($nonce_value, $nonce_name) ){
                wp_die(__('WordPress Nonce verification failed, try again going back and checking the form.') );

                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Prints a HTML alert in the WordPress admin interface.
     *
     * @param  string $type    The type of alert, it can be either Updated or Error.
     * @param  string $message The message that will be printed in the alert.
     * @return void
     */
    private static function admin_notice( $type='updated', $message='' ){
        $alert_id = rand(100, 999);
        if( !empty($message) ): ?>
            <div id="sucuriscan-alert-<?php echo $alert_id; ?>" class="<?php echo $type; ?> sucuriscan-alert sucuriscan-alert-<?php echo $type; ?>">
                <a href="javascript:void(0)" class="close" onclick="sucuriscan_alert_close('<?php echo $alert_id; ?>')">&times;</a>
                <p><?php _e($message); ?></p>
            </div>
        <?php endif;
    }

    /**
     * Prints a HTML alert of type ERROR in the WordPress admin interface.
     *
     * @param  string $error_msg The message that will be printed in the alert.
     * @return void
     */
    public static function error( $error_msg='' ){
        self::admin_notice( 'error', '<b>Sucuri:</b> ' . $error_msg );
    }

    /**
     * Prints a HTML alert of type INFO in the WordPress admin interface.
     *
     * @param  string $info_msg The message that will be printed in the alert.
     * @return void
     */
    public static function info( $info_msg='' ){
        self::admin_notice( 'updated', '<b>Sucuri:</b> ' . $info_msg );
    }

    /**
     * Display a notice message with instructions to continue the setup of the
     * plugin, this includes the generation of the API key and other steps that need
     * to be done to fully activate this plugin.
     *
     * @return void
     */
    public static function setup_notice(){
        if(
            current_user_can('manage_options')
            && SucuriScan::no_notices_here() === false
            && !SucuriScanAPI::get_plugin_key()
            && SucuriScanRequest::post(':plugin_api_key') === FALSE
            && SucuriScanRequest::post(':recover_key') === FALSE
            && !SucuriScanRequest::post(':manual_api_key')
        ){
            echo SucuriScanTemplate::get_section('setup-notice');
        }
    }

}

/**
 * Display the page with a temporary message explaining the action that will be
 * performed once the hidden form is submitted to retrieve the scanning results
 * from the public SiteCheck API.
 *
 * @return void
 */
function sucuriscan_scanner_page(){
    SucuriScanInterface::check_permissions();

    // Check if the information is already cached.
    $cache = new SucuriScanCache('sitecheck');
    $scan_results = $cache->get( 'scan_results', SUCURISCAN_SITECHECK_LIFETIME, 'array' );

    if(
        (
            $scan_results
            && !empty($scan_results)
        ) || (
            SucuriScanInterface::check_nonce()
            && SucuriScanRequest::post(':malware_scan', '1')
        )
    ){
        sucuriscan_sitecheck_info($scan_results);
    } else {
        echo SucuriScanTemplate::get_template('malwarescan', array(
            'PageTitle' => 'Malware Scan',
            'PageStyleClass' => 'scanner-loading',
        ));
    }
}

/**
 * Display the result of site scan made through SiteCheck.
 *
 * @param  array $res Array with information of the scanning.
 * @return void
 */
function sucuriscan_sitecheck_info( $res=array() ){
    // Will be TRUE only if the scanning results were retrieved from the cache.
    $display_results = (bool) $res;
    $clean_domain = SucuriScan::get_domain();

    // If the results are not cached, then request a new scanning.
    if( $res === FALSE ){
        $res = SucuriScanAPI::get_sitecheck_results($clean_domain);

        // Check for error messages in the request's response.
        if( is_string($res) ){
            if( preg_match('/^ERROR:(.*)/', $res, $error_m) ){
                SucuriScanInterface::error( 'The site <code>' . $clean_domain . '</code> was not scanned: ' . $error_m[1] );
            } else {
                SucuriScanInterface::error( 'SiteCheck error: ' . $res );
            }
        }

        else {
            $cache = new SucuriScanCache('sitecheck');
            $display_results = TRUE;

            // Cache the scanning results to reduce memory lose.
            if( !$cache->add( 'scan_results', $res ) ){
                SucuriScanInterface::error( 'Could not cache the results of the SiteCheck scanning.' );
            }
        }
    }

    // Count the number of scans.
    if ( $display_results === true ) {
        $sitecheck_counter = (int) SucuriScanOption::get_option(':sitecheck_counter');
        SucuriScanOption::update_option( ':sitecheck_counter', $sitecheck_counter + 1 );
    }

    ob_start();
    ?>


    <?php if( $display_results ): ?>

        <?php
        // Check for general warnings, and return the information for Infected/Clean site.
        $malware_warns_exist   = isset($res['MALWARE']['WARN'])   ? TRUE : FALSE;
        $blacklist_warns_exist = isset($res['BLACKLIST']['WARN']) ? TRUE : FALSE;
        $outdated_warns_exist  = isset($res['OUTDATEDSCAN'])      ? TRUE : FALSE;
        $recommendations_exist = isset($res['RECOMMENDATIONS'])   ? TRUE : FALSE;

        // Check whether this WordPress installation needs an update.
        global $wp_version;
        $wordpress_updated = FALSE;
        $updates = function_exists('get_core_updates') ? get_core_updates() : array();

        if( !is_array($updates) || empty($updates) || $updates[0]->response=='latest' ){
            $wordpress_updated = TRUE;
        }

        if( TRUE ){
            // Initialize the CSS classes with default values.
            $sucuriscan_css_blacklist = 'sucuriscan-border-good';
            $sucuriscan_css_malware = 'sucuriscan-border-good';
            $sitecheck_results_tab = '';
            $blacklist_status_tab = '';
            $website_details_tab = '';

            // Generate the CSS classes for the blacklist status.
            if( $blacklist_warns_exist ){
                $sucuriscan_css_blacklist = 'sucuriscan-border-bad';
                $blacklist_status_tab = 'sucuriscan-red-tab';
            }

            // Generate the CSS classes for the SiteCheck scanning results.
            if( $malware_warns_exist ){
                $sucuriscan_css_malware = 'sucuriscan-border-bad';
                $sitecheck_results_tab = 'sucuriscan-red-tab';
            }

            // Generate the CSS classes for the outdated/recommendations panel.
            if( $outdated_warns_exist || $recommendations_exist ){
                $website_details_tab = 'sucuriscan-red-tab';
            }

            $sucuriscan_css_wpupdate = $wordpress_updated ? 'sucuriscan-border-good' : 'sucuriscan-border-bad';
        }
        ?>

        <div id="poststuff">
            <div class="postbox sucuriscan-border sucuriscan-border-info sucuriscan-malwarescan-message">
                <h3>SiteCheck Scanner</h3>

                <div class="inside">
                    <p>
                        If your site was recently hacked, you can see which files were modified to
                        assist with any investigation.
                    </p>
                </div>
            </div>
        </div>


        <div class="sucuriscan-tabs">


            <ul>
                <li class="<?php _e($sitecheck_results_tab) ?>">
                    <a href="#" data-tabname="sitecheck-results">Remote Scanner Results</a>
                </li>
                <li class="<?php _e($website_details_tab) ?>">
                    <a href="#" data-tabname="website-details">Website Details</a>
                </li>
                <li>
                    <a href="#" data-tabname="website-links">IFrames / Links / Scripts</a>
                </li>
                <li class="<?php _e($blacklist_status_tab) ?>">
                    <a href="#" data-tabname="blacklist-status">Blacklist Status</a>
                </li>
                <li>
                    <a href="#" data-tabname="modified-files">Modified Files</a>
                </li>
            </ul>


            <div class="sucuriscan-tab-containers">


                <div id="sucuriscan-sitecheck-results">
                    <div id="poststuff">
                        <div class="postbox sucuriscan-border <?php _e($sucuriscan_css_malware) ?>">
                            <h3>
                                <?php if( $malware_warns_exist ): ?>
                                    Site compromised (malware was identified)
                                <?php else: ?>
                                    Site clean (no malware was identified)
                                <?php endif; ?>
                            </h3>

                            <div class="inside">

                                <?php if( !$malware_warns_exist ): ?>
                                    <p>
                                        <span><strong>Malware:</strong> Clean.</span><br>
                                        <span><strong>Malicious javascript:</strong> Clean.</span><br>
                                        <span><strong>Malicious iframes:</strong> Clean.</span><br>
                                        <span><strong>Suspicious redirections (htaccess):</strong> Clean.</span><br>
                                        <span><strong>Blackhat SEO Spam:</strong> Clean.</span><br>
                                        <span><strong>Anomaly detection:</strong> Clean.</span>
                                    </p>
                                <?php else: ?>
                                    <ul>
                                        <?php
                                        foreach( $res['MALWARE']['WARN'] as $malres ){
                                            if( !is_array($malres) ){
                                                echo '<li>' . htmlspecialchars($malres) . '</li>';
                                            } else {
                                                $mwdetails = explode("\n", htmlspecialchars($malres[1]));
                                                $mw_name_link = isset($mwdetails[0]) ? substr($mwdetails[0], 1) : '';

                                                if( preg_match('/(.*)\. Details: (.*)/', $mw_name_link, $mw_match) ){
                                                    $mw_name_link = sprintf(
                                                        '%s. Details: <a href="%s" target="_blank">%s</a>',
                                                        $mw_match[1], $mw_match[2], $mw_match[2]
                                                    );
                                                }

                                                echo '<li>'. htmlspecialchars($malres[0]) . "\n<br>" . $mw_name_link . "</li>\n";
                                            }
                                        }
                                        ?>
                                    </ul>
                                <?php endif; ?>

                                <p>
                                    <i>
                                        More details here: <a href="http://sitecheck.sucuri.net/results/<?php _e($clean_domain); ?>"
                                        target="_blank">http://sitecheck.sucuri.net/results/<?php _e($clean_domain); ?></a>
                                    </i>
                                </p>

                                <hr />

                                <p>
                                    <i>
                                        If our free scanner did not detect any issue, you may have a more complicated
                                        and hidden problem. You can <a href="http://sucuri.net/signup" target="_blank">
                                        sign up</a> with Sucuri for a complete and in depth scan+cleanup (not included
                                        in the free checks).
                                    </i>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>


                <div id="sucuriscan-website-details">
                    <table class="wp-list-table widefat sucuriscan-table sucuriscan-scanner-details">
                        <thead>
                            <tr>
                                <th colspan="2" class="thead-with-button">
                                    <span>System Information</span>
                                    <?php if( !$wordpress_updated ): ?>
                                        <a href="<?php echo admin_url('update-core.php'); ?>" class="button button-primary thead-topright-action">
                                            Update to <?php _e($updates[0]->version) ?>
                                        </a>
                                    <?php endif; ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- List of generic information from the site. -->
                            <?php
                            $possible_keys = array(
                                'DOMAIN' => 'Domain Scanned',
                                'IP' => 'Site IP Address',
                                'HOSTING' => 'Hosting Company',
                                'CMS' => 'CMS Found',
                            );
                            $possible_url_keys = array(
                                'IFRAME' => 'List of iframes found',
                                'JSEXTERNAL' => 'List of external scripts included',
                                'JSLOCAL' => 'List of scripts included',
                                'URL' => 'List of links found',
                            );
                            ?>

                            <?php foreach( $possible_keys as $result_key=>$result_title ): ?>
                                <?php if( isset($res['SCAN'][$result_key]) ): ?>
                                    <?php $result_value = implode(', ', $res['SCAN'][$result_key]); ?>
                                    <tr>
                                        <td><?php _e($result_title) ?></td>
                                        <td><span class="sucuriscan-monospace"><?php _e($result_value) ?></span></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <tr>
                                <td>WordPress Version</td>
                                <td><span class="sucuriscan-monospace"><?php _e($wp_version) ?></span></td>
                            </tr>
                            <tr>
                                <td>PHP Version</td>
                                <td><span class="sucuriscan-monospace"><?php _e(phpversion()) ?></span></td>
                            </tr>

                            <!-- List of application details from the site. -->
                            <tr>
                                <th colspan="2">Web application details</th>
                            </tr>
                            <?php if( isset($res['WEBAPP']) ): ?>
                                <?php foreach( $res['WEBAPP'] as $webapp_key=>$webapp_details ): ?>
                                    <?php if( is_array($webapp_details) ): ?>
                                        <?php foreach( $webapp_details as $i=>$details ): ?>
                                            <?php if( is_array($details) ){ $details = isset($details[0]) ? $details[0] : ''; } ?>
                                            <tr>
                                                <td colspan="2">
                                                    <span class="sucuriscan-monospace"><?php _e($details) ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if( isset($res['SYSTEM']['NOTICE']) ): ?>
                                <?php foreach( $res['SYSTEM']['NOTICE'] as $j=>$notice ): ?>
                                    <?php if( is_array($notice) ){ $notice = implode(', ', $notice); } ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="sucuriscan-monospace"><?php _e($notice) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ( !isset($res['WEBAPP']) && !isset($res['SYSTEM']['NOTICE']) ): ?>
                                <tr>
                                    <td colspan="2"><em>No more information was found.</em></td>
                                </tr>
                            <?php endif; ?>

                            <!-- Possible recommendations or outdated software on the site. -->
                            <?php if( $outdated_warns_exist || $recommendations_exist ): ?>
                                <tr>
                                    <th colspan="2">Recommendations for the site</th>
                                </tr>
                            <?php endif; ?>

                            <!-- Possible outdated software on the site. -->
                            <?php if( $outdated_warns_exist ): ?>
                                <?php foreach( $res['OUTDATEDSCAN'] as $outdated ): ?>
                                    <?php if( count($outdated) >= 3 ): ?>
                                        <tr>
                                            <td colspan="2" class="sucuriscan-border-bad">
                                                <strong><?php _e($outdated[0]) ?></strong>
                                                <em>(<?php _e($outdated[2]) ?>)</em>
                                                <span><?php _e($outdated[1]) ?></span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Possible recommendations for the site. -->
                            <?php if( $recommendations_exist ): ?>
                                <?php foreach( $res['RECOMMENDATIONS'] as $recommendation ): ?>
                                    <?php if( count($recommendation) >= 3 ): ?>
                                        <tr>
                                            <td colspan="2" class="sucuriscan-border-bad">
                                                <?php printf(
                                                    '<strong>%s</strong><br><span>%s</span><br><a href="%s" target="_blank">%s</a>',
                                                    SucuriScan::escape($recommendation[0]),
                                                    SucuriScan::escape($recommendation[1]),
                                                    SucuriScan::escape($recommendation[2]),
                                                    SucuriScan::escape($recommendation[2])
                                                ); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <div id="sucuriscan-website-links">
                    <table class="wp-list-table widefat sucuriscan-table sucuriscan-scanner-links">
                        <tbody>
                            <?php if ( isset($res['LINKS']) ): ?>

                                <?php foreach( $possible_url_keys as $result_url_key=>$result_url_title ): ?>

                                    <?php if( isset($res['LINKS'][$result_url_key]) ): ?>
                                        <tr>
                                            <th colspan="2">
                                                <?php printf(
                                                    '%s (%d found)',
                                                    __($result_url_title),
                                                    count($res['LINKS'][$result_url_key])
                                                ) ?>
                                            </th>
                                        </tr>

                                        <?php foreach( $res['LINKS'][$result_url_key] as $url_path ): ?>
                                            <tr>
                                                <td colspan="2">
                                                    <span class="sucuriscan-monospace sucuriscan-wraptext"><?php _e($url_path) ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td><em>No iFrames, links, or script files were found.</em></td>
                                </tr>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <div id="sucuriscan-blacklist-status">
                    <div id="poststuff">
                        <div class="postbox sucuriscan-border <?php _e($sucuriscan_css_blacklist) ?>">
                            <h3>
                                <?php if( $blacklist_warns_exist ): ?>
                                    Site blacklisted
                                <?php else: ?>
                                    Site blacklist-free
                                <?php endif; ?>
                            </h3>

                            <div class="inside">
                                <ul>
                                    <?php
                                    foreach(array(
                                        'INFO' => 'CLEAN',
                                        'WARN' => 'WARNING'
                                    ) as $type => $group_title){
                                        if( isset($res['BLACKLIST'][$type]) ){
                                            foreach( $res['BLACKLIST'][$type] as $blres ){
                                                $report_site = SucuriScan::escape($blres[0]);
                                                $report_url = SucuriScan::escape($blres[1]);
                                                printf(
                                                    '<li><b>%s:</b> %s.<br>Details at <a href="%s" target="_blank">%s</a></li>',
                                                    $group_title, $report_site, $report_url, $report_url
                                                );
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="sucuriscan-modified-files">
                    <?php echo sucuriscan_modified_files(); ?>
                </div>


            </div>
        </div>

        <?php if( $malware_warns_exist || $blacklist_warns_exist ): ?>
            <a href="http://sucuri.net/signup/" target="_blank" class="button button-primary button-hero sucuriscan-cleanup-btn">
                Get your site protected with Sucuri
            </a>
        <?php endif; ?>

    <?php endif; ?>


    <?php
    $_html = ob_get_contents();
    ob_end_clean();
    echo SucuriScanTemplate::get_base_template($_html, array(
        'PageTitle' => 'Malware Scan',
        'PageContent' => $_html,
        'PageStyleClass' => 'scanner-results',
    ));
    return;
}

/**
 * CloudProxy monitoring page.
 *
 * It checks whether the WordPress core files are the original ones, and the state
 * of the themes and plugins reporting the availability of updates. It also checks
 * the user accounts under the administrator group.
 *
 * @return void
 */
function sucuriscan_monitoring_page(){
    SucuriScanInterface::check_permissions();

    // Process all form submissions.
    sucuriscan_monitoring_form_submissions();

    // Get the dynamic values for the template variables.
    $api_key = SucuriScanAPI::get_cloudproxy_key();

    // Page pseudo-variables initialization.
    $template_variables = array(
        'PageTitle' => 'Firewall WAF',
        'Monitoring.InstructionsVisibility' => 'visible',
        'Monitoring.Settings' => sucuriscan_monitoring_settings($api_key),
        'Monitoring.Logs' => sucuriscan_monitoring_logs($api_key),

        /* Pseudo-variables for the monitoring logs. */
        'AuditLogs.List' => '',
        'AuditLogs.CountText' => '',
        'AuditLogs.DenialTypeOptions' => '',
        'AuditLogs.NoItemsVisibility' => '',
        'AuditLogs.PaginationVisibility' => '',
        'AuditLogs.AuditPagination' => '',
    );

    if( $api_key ){
        $template_variables['Monitoring.InstructionsVisibility'] = 'hidden';
    }

    echo SucuriScanTemplate::get_template('monitoring', $template_variables);
}

/**
 * Process the requests sent by the form submissions originated in the monitoring
 * page, all forms must have a nonce field that will be checked against the one
 * generated in the template render function.
 *
 * @return void
 */
function sucuriscan_monitoring_form_submissions(){

    if( SucuriScanInterface::check_nonce() ){

        // Add and/or Update the Sucuri WAF API Key (do it before anything else).
        $option_name = ':cloudproxy_apikey';
        $api_key = SucuriScanRequest::post($option_name);

        if( $api_key !== FALSE ){
            if( SucuriScanAPI::is_valid_cloudproxy_key($api_key) ){
                SucuriScanOption::update_option($option_name, $api_key);
                SucuriScanInterface::info( 'CloudProxy API key saved successfully' );
            } elseif( empty($api_key) ){
                SucuriScanOption::delete_option($option_name);
                SucuriScanInterface::info( 'CloudProxy API key removed successfully' );
            } else {
                SucuriScanInterface::error( 'Invalid CloudProxy API key, check your settings and try again.' );
            }
        }

        // Flush the cache of the site(s) associated with the API key.
        if( SucuriScanRequest::post(':clear_cache', '1') ){
            $clear_cache_resp = SucuriScanAPI::clear_cloudproxy_cache();

            if( $clear_cache_resp ){
                if( isset($clear_cache_resp->messages[0]) ){
                    // Clear W3 Total Cache if it is installed.
                    if( function_exists('w3tc_flush_all') ){ w3tc_flush_all(); }

                    SucuriScanInterface::info($clear_cache_resp->messages[0]);
                } else {
                    SucuriScanInterface::error('Could not clear the cache of your site, try later again.');
                }
            } else {
                SucuriScanInterface::error( 'CloudProxy is not enabled on your site, or your API key is invalid.' );
            }
        }

    }

}

/**
 * Generate the HTML code for the monitoring settings panel.
 *
 * @param  string $api_key The CloudProxy API key.
 * @return string          The parsed-content of the monitoring settings panel.
 */
function sucuriscan_monitoring_settings( $api_key='' ){
    $template_variables = array(
        'Monitoring.APIKey' => '',
        'Monitoring.SettingsVisibility' => 'hidden',
        'Monitoring.SettingOptions' => '',
    );

    if( $api_key ){
        $settings = SucuriScanAPI::get_cloudproxy_settings($api_key);

        $template_variables['Monitoring.APIKey'] = $api_key['string'];

        if( $settings ){
            $counter = 0;
            $template_variables['Monitoring.SettingsVisibility'] = 'visible';
            $settings = sucuriscan_explain_monitoring_settings($settings);

            foreach( $settings as $option_name => $option_value ){
                // Change the name of some options.
                if( $option_name == 'internal_ip' ){
                    $option_name = 'hosting_ip';
                }

                $css_class = ( $counter % 2 == 0 ) ? 'alternate' : '';
                $option_title = ucwords(str_replace('_', chr(32), $option_name));

                // Generate a HTML list when the option's value is an array.
                if( is_array($option_value) ){
                    $css_scrollable = count($option_value) > 10 ? 'sucuriscan-list-as-table-scrollable' : '';
                    $html_list  = '<ul class="sucuriscan-list-as-table ' . $css_scrollable . '">';

                    foreach( $option_value as $single_value ){
                        $html_list .= '<li>' . $single_value . '</li>';
                    }

                    $html_list .= '</ul>';
                    $option_value = $html_list;
                }

                // Parse the snippet template and replace the pseudo-variables.
                $template_variables['Monitoring.SettingOptions'] .= SucuriScanTemplate::get_snippet('monitoring-settings', array(
                    'Monitoring.OptionCssClass' => $css_class,
                    'Monitoring.OptionName' => $option_title,
                    'Monitoring.OptionValue' => $option_value,
                ));
                $counter += 1;
            }
        }
    }

    return SucuriScanTemplate::get_section( 'monitoring-settings', $template_variables );
}

/**
 * Converts the value of some of the monitoring settings into a human-readable
 * text, for example changing numbers or variable names into a more explicit
 * text so the administrator can understand the meaning of these settings.
 *
 * @param  array $settings A hash with the settings of a CloudProxy account.
 * @return array           The explained version of the CloudProxy settings.
 */
function sucuriscan_explain_monitoring_settings( $settings=array() ){
    if( $settings ){
        foreach( $settings as $option_name => $option_value ){
            switch( $option_name ){
                case 'security_level':
                    $new_value = ucwords($option_value);
                    break;
                case 'proxy_active':
                    $new_value = ( $option_value == 1 ) ? 'Active' : 'not active';
                    break;
                case 'cache_mode':
                    $new_value = sucuriscan_cache_mode_title($option_value);
                    break;
            }

            if( isset($new_value) ){
                $settings->{$option_name} = $new_value;
            }
        }

        return $settings;
    }

    return FALSE;
}

/**
 * Get an explanation of the meaning of the value set for the account's attribute cache_mode.
 *
 * @param  string $mode The value set for the cache settings of the site.
 * @return string       Explanation of the meaning of the cache_mode value.
 */
function sucuriscan_cache_mode_title( $mode='' ){
    $title = '';

    switch( $mode ){
        case 'docache':      $title = 'Enabled (recommended)'; break;
        case 'sitecache':    $title = 'Site caching (using your site headers)'; break;
        case 'nocache':      $title = 'Minimal (only for a few minutes)'; break;
        case 'nocacheatall': $title = 'Caching disabled (use with caution)'; break;
        default:             $title = 'Unknown'; break;
    }

    return $title;
}

/**
 * Generate the HTML code for the monitoring logs panel.
 *
 * @param  string $api_key The CloudProxy API key.
 * @return string          The parsed-content of the monitoring logs panel.
 */
function sucuriscan_monitoring_logs( $api_key='' ){
    $template_variables = array(
        'AuditLogs.List' => '',
        'AuditLogs.CountText' => 0,
        'AuditLogs.DenialTypeOptions' => '',
        'AuditLogs.NoItemsVisibility' => 'visible',
        'AuditLogs.PaginationVisibility' => 'hidden',
        'AuditLogs.AuditPagination' => '',
        'AuditLogs.TargetDate' => '',
        'AuditLogs.DateYears' => '',
        'AuditLogs.DateMonths' => '',
        'AuditLogs.DateDays' => '',
    );

    $date = date('Y-m-d');

    if( $api_key ){
        // Retrieve the date filter from the GET request (if any).
        if( $date_by_get = SucuriScanRequest::get('date', '_yyyymmdd') ){
            $date = $date_by_get;
        }

        // Retrieve the date filter from the POST request (if any).
        $year = SucuriScanRequest::post(':year');
        $month = SucuriScanRequest::post(':month');
        $day = SucuriScanRequest::post(':day');

        if( $year && $month && $day ){
            $date = sprintf( '%s-%s-%s', $year, $month, $day );
        }

        $logs_data = SucuriScanAPI::get_cloudproxy_logs( $api_key, $date );

        if( $logs_data ){
            add_thickbox(); /* Include the Thickbox library. */
            $template_variables['AuditLogs.NoItemsVisibility'] = 'hidden';
            $template_variables['AuditLogs.CountText'] = $logs_data->limit . '/' . $logs_data->total_lines;
            $template_variables['AuditLogs.List'] = sucuriscan_monitoring_access_logs($logs_data->access_logs);
            $template_variables['AuditLogs.DenialTypeOptions'] = sucuriscan_monitoring_denial_types($logs_data->access_logs);
        }
    }

    $template_variables['AuditLogs.TargetDate'] = SucuriScan::escape($date);
    $template_variables['AuditLogs.DateYears'] = sucuriscan_monitoring_dates('years', $date);
    $template_variables['AuditLogs.DateMonths'] = sucuriscan_monitoring_dates('months', $date);
    $template_variables['AuditLogs.DateDays'] = sucuriscan_monitoring_dates('days', $date);

    return SucuriScanTemplate::get_section( 'monitoring-logs', $template_variables );
}

/**
 * Generate the HTML code to show the table with the access-logs.
 *
 * @param  array  $access_logs The logs retrieved from the remote API service.
 * @return string              The HTML code to show the access-logs in the page as a table.
 */
function sucuriscan_monitoring_access_logs( $access_logs=array() ){
    $logs_html = '';

    if( $access_logs && !empty($access_logs) ){
        $counter = 0;
        $needed_attrs = array(
            'request_date',
            'request_time',
            'request_timezone',
            'request_timestamp',
            'local_request_time',
            'remote_addr',
            'sucuri_block_reason',
            'resource_path',
            'request_method',
            'http_protocol',
            'http_status',
            'http_status_title',
            'http_bytes_sent',
            'http_referer',
            'http_user_agent',
        );

        $filter_by_denial_type = FALSE;
        $filter_by_keyword = FALSE;
        $filter_query = FALSE;

        if( $q = SucuriScanRequest::post(':monitoring_denial_type') ){
            $filter_by_denial_type = TRUE;
            $filter_query = $q;
        }

        if( $q = SucuriScanRequest::post(':monitoring_log_filter') ){
            $filter_by_keyword = TRUE;
            $filter_query = $q;
        }

        foreach( $access_logs as $access_log ){
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
            $audit_log_snippet = array(
                'AuditLog.Id' => $counter,
                'AuditLog.CssClass' => $css_class,
            );

            // If there is a filter, check the access_log data and break the operation if needed.
            if( $filter_query ){
                if( $filter_by_denial_type ){
                    $denial_type_slug = SucuriScan::human2var($access_log->sucuri_block_reason);

                    if( $denial_type_slug != $filter_query ){ continue; }
                }

                if(
                    $filter_by_keyword
                    && strpos($access_log->remote_addr, $filter_query) === FALSE
                    && strpos($access_log->resource_path, $filter_query) === FALSE
                ){
                    continue;
                }
            }

            // Generate (dynamically) the pseudo-variables for the template.
            foreach( $needed_attrs as $attr_name ){
                $attr_value = '';

                $attr_title = str_replace('_', chr(32), $attr_name);
                $attr_title = ucwords($attr_title);
                $attr_title = str_replace(chr(32), '', $attr_title);
                $attr_title = 'AuditLog.' . $attr_title;

                if( isset($access_log->{$attr_name}) ){
                    $attr_value = $access_log->{$attr_name};

                    if(
                        empty($attr_value)
                        && $attr_name == 'sucuri_block_reason'
                    ){
                        $attr_value = 'Unknown';
                    }
                }

                elseif( $attr_name == 'local_request_time' ){
                    $attr_value = SucuriScan::datetime($access_log->request_timestamp);
                }

                $audit_log_snippet[$attr_title] = SucuriScan::escape($attr_value);
            }

            $logs_html .= SucuriScanTemplate::get_snippet('monitoring-logs', $audit_log_snippet);
            $counter += 1;
        }
    }

    return $logs_html;
}

/**
 * Get a list of denial types using the reason of the blocking of a request from
 * the from the audit logs. Examples of denial types can be: "Bad bot access
 * denied", "Access to restricted folder", "Blocked by IDS", etc.
 *
 * @param  array   $access_logs A list of objects with the detailed version of each request blocked by our service.
 * @param  boolean $in_html     Whether the list should be converted to a HTML select options or not.
 * @return array                Either a list of unique blocking types, or a HTML code.
 */
function sucuriscan_monitoring_denial_types( $access_logs=array(), $in_html=TRUE ){
    $types = array();

    if( $access_logs && !empty($access_logs) ){
        foreach( $access_logs as $access_log ){
            if( !array_key_exists($access_log->sucuri_block_reason, $types) ){
                $denial_type_k = SucuriScan::human2var($access_log->sucuri_block_reason);
                $denial_type_v = $access_log->sucuri_block_reason;
                if( empty($denial_type_v) ){ $denial_type_v = 'Unknown'; }
                $types[$denial_type_k] = $denial_type_v;
            }
        }
    }

    if( $in_html ){
        $html_types = '<option value="">Filter</option>';
        $selected = SucuriScanRequest::post(':monitoring_denial_type', '.+');

        foreach( $types as $type_key => $type_value ){
            $selected_tag = ( $type_key === $selected ) ? 'selected="selected"' : '';
            $html_types .= sprintf(
                '<option value="%s" %s>%s</option>',
                SucuriScan::escape($type_key),
                $selected_tag,
                SucuriScan::escape($type_value)
            );
        }

        return $html_types;
    }

    return $types;
}

/**
 * Get a list of years, months or days depending of the type specified.
 *
 * @param  string  $type    Either years, months or days.
 * @param  string  $date    Year, month and day selected from the request.
 * @param  boolean $in_html Whether the list should be converted to a HTML select options or not.
 * @return array            Either an array with the expected values, or a HTML code.
 */
function sucuriscan_monitoring_dates( $type='', $date='', $in_html=TRUE ){
    $options = array();
    $selected = '';

    if( preg_match('/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/', $date, $date_m) ){
        $s_year = $date_m[1];
        $s_month = $date_m[2];
        $s_day = $date_m[3];
    } else {
        $s_year = '';
        $s_month = '';
        $s_day = '';
    }

    switch( $type ){
        case 'years':
            $selected = $s_year;
            $current_year = (int) date('Y');
            $max_years = 5; /* Maximum number of years to keep the logs. */
            $options = range( ($current_year - $max_years), $current_year );
            break;
        case 'months':
            $selected = $s_month;
            $options = array(
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December'
            );
            break;
        case 'days':
            $options = range(1, 31);
            $selected = $s_day;
            break;
    }

    if( $in_html ){
        $html_options = '';

        foreach( $options as $key => $value ){
            if( is_numeric($value) ){ $value = str_pad($value, 2, 0, STR_PAD_LEFT); }

            if( $type != 'months' ){ $key = $value; }

            $selected_tag = ( $key == $selected ) ? 'selected="selected"' : '';
            $html_options .= sprintf( '<option value="%s" %s>%s</option>', $key, $selected_tag, $value );
        }

        return $html_options;
    }

    return $options;
}

/**
 * Sucuri one-click hardening page.
 *
 * It loads all the functions defined in /lib/hardening.php and shows the forms
 * that the administrator can use to harden multiple parts of the site.
 *
 * @return void
 */
function sucuriscan_hardening_page(){
    SucuriScanInterface::check_permissions();

    if(
        SucuriScanRequest::post(':run_hardening')
        && !SucuriScanInterface::check_nonce()
    ){
        unset($_POST['sucuriscan_run_hardening']);
    }

    ob_start();
    ?>

    <div id="poststuff">
        <form method="post">
            <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
            <input type="hidden" name="sucuriscan_run_hardening" value="1" />

            <?php
            sucuriscan_harden_version();
            sucuriscan_cloudproxy_enabled();
            sucuriscan_harden_removegenerator();
            sucuriscan_harden_upload();
            sucuriscan_harden_wpcontent();
            sucuriscan_harden_wpincludes();
            sucuriscan_harden_phpversion();
            sucuriscan_harden_secretkeys();
            sucuriscan_harden_readme();
            sucuriscan_harden_adminuser();
            sucuriscan_harden_fileeditor();
            sucuriscan_harden_dbtables();
            sucuriscan_harden_errorlog();
            ?>
        </form>
    </div>

    <?php
    $_html = ob_get_contents();
    ob_end_clean();
    echo SucuriScanTemplate::get_base_template($_html, array(
        'PageTitle' => 'Hardening',
        'PageContent' => $_html,
        'PageStyleClass' => 'hardening'
    ));
    return;
}

/**
 * Generate the HTML code necessary to show a form with the options to harden
 * a specific part of the WordPress installation, if the Status variable is
 * set as a positive integer the button is shown as "unharden".
 *
 * @param  string  $title       Title of the panel.
 * @param  integer $status      Either one or zero representing the state of the hardening, one for secure, zero for insecure.
 * @param  string  $type        Name of the hardening option, this will be used through out the form generation.
 * @param  string  $messageok   Message that will be shown if the hardening was executed.
 * @param  string  $messagewarn Message that will be shown if the hardening is not executed.
 * @param  string  $desc        Optional description of the hardening.
 * @param  string  $updatemsg   Optional explanation of the hardening after the submission of the form.
 * @return void
 */
function sucuriscan_harden_status( $title='', $status=0, $type='', $messageok='', $messagewarn='', $desc=NULL, $updatemsg=NULL ){ ?>
    <div class="postbox">
        <h3><?php _e($title) ?></h3>

        <div class="inside">
            <?php if( $desc != NULL ): ?>
                <p><?php _e($desc) ?></p>
            <?php endif; ?>

            <div class="sucuriscan-hstatus sucuriscan-hstatus-<?php _e($status) ?>">
                <?php if( $type != NULL ): ?>
                    <?php if( $status == 1 ): ?>
                        <input type="submit" name="<?php _e($type) ?>_unharden" value="Revert hardening" class="button-secondary" />
                    <?php else: ?>
                        <input type="submit" name="<?php _e($type) ?>" value="Harden" class="button-primary" />
                    <?php endif; ?>
                <?php endif; ?>

                <span>
                    <?php if( $status == 1 ): ?>
                        <?php _e($messageok) ?>
                    <?php else: ?>
                        <?php _e($messagewarn) ?>
                    <?php endif; ?>
                </span>
            </div>

            <?php if( $updatemsg != NULL ): ?>
                <p><?php _e($updatemsg) ?></p>
            <?php endif; ?>
        </div>
    </div>

<?php }

/**
 * Check whether the version number of the WordPress installed is the latest
 * version available officially.
 *
 * @return void
 */
function sucuriscan_harden_version(){
    $site_version = SucuriScan::site_version();
    $updates = get_core_updates();
    $cp = ( !is_array($updates) || empty($updates) ? 1 : 0 );

    if( isset($updates[0]) && $updates[0] instanceof stdClass ){
        if(
            $updates[0]->response == 'latest'
            || $updates[0]->response == 'development'
        ){
            $cp = 1;
        }
    }

    if( strcmp($site_version, '3.7') < 0 ){
        $cp = 0;
    }

    $initial_msg = 'Why keep your site updated? WordPress is an open-source
        project which means that with every update the details of the changes made
        to the source code are made public, if there were security fixes then
        someone with malicious intent can use this information to attack any site
        that has not been upgraded.';
    $messageok = sprintf('Your WordPress installation (%s) is current.', $site_version);
    $messagewarn = sprintf(
        'Your current version (%s) is not current.<br>
        <a href="update-core.php" class="button-primary">Update now!</a>',
        $site_version
    );

    sucuriscan_harden_status( 'Verify WordPress version', $cp, NULL, $messageok, $messagewarn, $initial_msg );
}

/**
 * Notify the state of the hardening for the removal of the Generator tag in
 * HTML code printed by WordPress to show the current version number of the
 * installation.
 *
 * @return void
 */
function sucuriscan_harden_removegenerator(){
    sucuriscan_harden_status(
        'Remove WordPress version',
        1,
        NULL,
        'WordPress version properly hidden',
        NULL,
        'It checks if your WordPress version is being hidden from being displayed '
        .'in the generator tag (enabled by default with this plugin).'
    );
}

/**
 * Check whether the WordPress upload folder is protected or not.
 *
 * A htaccess file is placed in the upload folder denying the access to any php
 * file that could be uploaded through a vulnerability in a Plugin, Theme or
 * WordPress itself.
 *
 * @return void
 */
function sucuriscan_harden_upload(){
    $cp = 1;
    $upmsg = NULL;
    $datastore_path = SucuriScan::datastore_folder_path();
    $htaccess_upload = dirname($datastore_path) . '/.htaccess';

    if( !is_readable($htaccess_upload) ){
        $cp = 0;
    } else {
        $cp = 0;
        $fcontent = SucuriScanFileInfo::file_lines($htaccess_upload);

        foreach( $fcontent as $fline ){
            if( stripos($fline, 'deny from all') !== FALSE ){
                $cp = 1;
                break;
            }
        }
    }

    if( SucuriScanRequest::post(':run_hardening') ){
        if( SucuriScanRequest::post(':harden_upload') && $cp == 0 ){
            if( @file_put_contents($htaccess_upload, "\n<Files *.php>\ndeny from all\n</Files>") === FALSE ){
                $upmsg = SucuriScanInterface::error('Unable to create <code>.htaccess</code> file, folder destination is not writable.');
            } else {
                $upmsg = SucuriScanInterface::info('Hardening applied successfully to upload directory');
                $cp = 1;
            }
        }

        elseif( SucuriScanRequest::post(':harden_upload_unharden') ){
            $htaccess_upload_writable = ( file_exists($htaccess_upload) && is_writable($htaccess_upload) ) ? TRUE : FALSE;
            $htaccess_content = $htaccess_upload_writable ? file_get_contents($htaccess_upload) : '';

            if( $htaccess_upload_writable ){
                $cp = 0;

                if( preg_match('/<Files \*\.php>\ndeny from all\n<\/Files>/', $htaccess_content, $match) ){
                    $htaccess_content = str_replace("<Files *.php>\ndeny from all\n</Files>", '', $htaccess_content);
                    @file_put_contents($htaccess_upload, $htaccess_content, LOCK_EX);
                }

                SucuriScanInterface::info('Hardening reverted for upload directory.');
            } else {
                SucuriScanInterface::error(
                    'File <code>/wp-content/uploads/.htaccess</code> does not exists or
                    is not writable, you will need to remove the following code (manually):
                    <code>&lt;Files *.php&gt;deny from all&lt;/Files&gt;</code>'
                );
            }
        }
    }

    sucuriscan_harden_status(
        'Protect uploads directory',
        $cp,
        'sucuriscan_harden_upload',
        'Upload directory properly hardened',
        'Upload directory not hardened',
        'It checks if your upload directory allows PHP execution or if it is browsable.',
        $upmsg
    );
}

/**
 * Check whether the WordPress content folder is protected or not.
 *
 * A htaccess file is placed in the content folder denying the access to any php
 * file that could be uploaded through a vulnerability in a Plugin, Theme or
 * WordPress itself.
 *
 * @return void
 */
function sucuriscan_harden_wpcontent(){
    $cp = 1;
    $upmsg = NULL;
    $htaccess_upload = WP_CONTENT_DIR . '/.htaccess';

    if( !is_readable($htaccess_upload) ){
        $cp = 0;
    } else {
        $cp = 0;
        $fcontent = SucuriScanFileInfo::file_lines($htaccess_upload);

        foreach( $fcontent as $fline ){
            if( stripos($fline, 'deny from all') !== FALSE ){
                $cp = 1;
                break;
            }
        }
    }

    if( SucuriScanRequest::post(':run_hardening') ){
        if( SucuriScanRequest::post(':harden_wpcontent') && $cp == 0 ){
            if( @file_put_contents($htaccess_upload, "\n<Files *.php>\ndeny from all\n</Files>") === FALSE ){
                $upmsg = SucuriScanInterface::error('Unable to create <code>.htaccess</code> file, folder destination is not writable.');
            } else {
                $upmsg = SucuriScanInterface::info('Hardening applied successfully to content directory.');
                $cp = 1;
            }
        }

        elseif( SucuriScanRequest::post(':harden_wpcontent_unharden') ){
            $htaccess_upload_writable = ( file_exists($htaccess_upload) && is_writable($htaccess_upload) ) ? TRUE : FALSE;
            $htaccess_content = $htaccess_upload_writable ? file_get_contents($htaccess_upload) : '';

            if( $htaccess_upload_writable ){
                $cp = 0;

                if( preg_match('/<Files \*\.php>\ndeny from all\n<\/Files>/', $htaccess_content, $match) ){
                    $htaccess_content = str_replace("<Files *.php>\ndeny from all\n</Files>", '', $htaccess_content);
                    @file_put_contents($htaccess_upload, $htaccess_content, LOCK_EX);
                }

                SucuriScanInterface::info('Hardening reverted for content directory.');
            } else {
                SucuriScanInterface::info(
                    'File <code>' . WP_CONTENT_DIR . '/.htaccess</code> does not exists or is not
                    writable, you will need to remove the following code manually from there:
                    <code>&lt;Files *.php&gt;deny from all&lt;/Files&gt;</code>'
                );
            }
        }
    }

    $description = 'This option blocks direct PHP access to any file inside wp-content. If you experience '
        . 'any issue after this with a theme or plugin in your site, like for example images not displaying, '
        . 'remove the <code>.htaccess</code> file located in the content directory.'
        . '</p><p><b>Note:</b> Many <em>(insecure)</em> themes and plugins use a PHP file in this directory '
        . 'to generate images like thumbnails and captcha codes, this is intentional so it is recommended '
        . 'to check your site once this option is enabled.';

    sucuriscan_harden_status(
        'Restrict wp-content access',
        $cp,
        'sucuriscan_harden_wpcontent',
        'WP-content directory properly hardened',
        'WP-content directory not hardened',
        $description,
        $upmsg
    );
}

/**
 * Check whether the WordPress includes folder is protected or not.
 *
 * A htaccess file is placed in the includes folder denying the access to any php
 * file that could be uploaded through a vulnerability in a Plugin, Theme or
 * WordPress itself, there are some exceptions for some specific files that must
 * be available publicly.
 *
 * @return void
 */
function sucuriscan_harden_wpincludes(){
    $cp = 1;
    $upmsg = NULL;
    $htaccess_upload = ABSPATH . '/wp-includes/.htaccess';

    if( !is_readable($htaccess_upload) ){
        $cp = 0;
    } else {
        $cp = 0;
        $fcontent = SucuriScanFileInfo::file_lines($htaccess_upload);

        foreach( $fcontent as $fline ){
            if( stripos($fline, 'deny from all') !== FALSE ){
                $cp = 1;
                break;
            }
        }
    }

    if( SucuriScanRequest::post(':run_hardening') ){
        if( SucuriScanRequest::post(':harden_wpincludes') && $cp == 0 ){
            if( @file_put_contents($htaccess_upload, "\n<Files *.php>\ndeny from all\n</Files>\n<Files wp-tinymce.php>\nallow from all\n</Files>\n")===FALSE ){
                $upmsg = SucuriScanInterface::error('Unable to create <code>.htaccess</code> file, folder destination is not writable.');
            } else {
                $upmsg = SucuriScanInterface::info('Hardening applied successfully to library\'s directory.');
                $cp = 1;
            }
        }

        elseif( SucuriScanRequest::post(':harden_wpincludes_unharden') ){
            $htaccess_upload_writable = ( file_exists($htaccess_upload) && is_writable($htaccess_upload) ) ? TRUE : FALSE;
            $htaccess_content = $htaccess_upload_writable ? file_get_contents($htaccess_upload) : '';

            if( $htaccess_upload_writable ){
                $cp = 0;
                if( preg_match_all('/<Files (\*|wp-tinymce|ms-files)\.php>\n(deny|allow) from all\n<\/Files>/', $htaccess_content, $match) ){
                    foreach($match[0] as $restriction){
                        $htaccess_content = str_replace($restriction, '', $htaccess_content);
                    }

                    @file_put_contents($htaccess_upload, $htaccess_content, LOCK_EX);
                }
                SucuriScanInterface::info('Hardening reverted for library\'s directory.');
            } else {
                SucuriScanInterface::error(
                    'File <code>wp-includes/.htaccess</code> does not exists or is not
                    writable, you will need to remove the following code manually from
                    there: <code>&lt;Files *.php&gt;deny from all&lt;/Files&gt;</code>'
                );
            }
        }
    }

    sucuriscan_harden_status(
        'Restrict wp-includes access',
        $cp,
        'sucuriscan_harden_wpincludes',
        'WP-Includes directory properly hardened',
        'WP-Includes directory not hardened',
        'This option blocks direct PHP access to any file inside <code>wp-includes</code>.',
        $upmsg
    );
}

/**
 * Check the version number of the PHP interpreter set to work with the site,
 * is considered that old versions of the PHP interpreter are insecure.
 *
 * @return void
 */
function sucuriscan_harden_phpversion(){
    $phpv = phpversion();
    $cp = ( strncmp($phpv, '5.', 2) < 0 ) ? 0 : 1;

    sucuriscan_harden_status(
        'Verify PHP version',
        $cp,
        NULL,
        'Using an updated version of PHP (' . $phpv . ')',
        'The version of PHP you are using (' . $phpv . ') is not current, not recommended, and/or not supported',
        'This checks if you have the latest version of PHP installed.',
        NULL
    );
}

/**
 * Check whether the site is behind a secure proxy server or not.
 *
 * @return void
 */
function sucuriscan_cloudproxy_enabled(){
    $btn_string = '';
    $proxy_info = SucuriScan::is_behind_cloudproxy();
    $status = 1;

    $description = 'A WAF is a protection layer for your web site, blocking all sort of attacks (brute force attempts, '
        . 'DDoS, SQL injections, etc) and helping it remain malware and blacklist free. This test checks if your site is '
        . 'using <a href="http://cloudproxy.sucuri.net/" target="_blank">Sucuri\'s CloudProxy WAF</a> to protect your site.';

    if( $proxy_info === FALSE ){
        $status = 0;
        $btn_string = '<a href="http://cloudproxy.sucuri.net/" target="_blank" class="button button-primary">Harden</a>';
    }

    sucuriscan_harden_status(
        'Website Firewall protection',
        $status,
        NULL,
        'Your website is protected by a Website Firewall (WAF)',
        $btn_string . 'Your website is not protected by a Website Firewall (WAF)',
        $description,
        NULL
    );
}

/**
 * Check whether the Wordpress configuration file has the security keys recommended
 * to avoid any unauthorized access to the interface.
 *
 * WordPress Security Keys is a set of random variables that improve encryption of
 * information stored in the user’s cookies. There are a total of four security
 * keys: AUTH_KEY, SECURE_AUTH_KEY, LOGGED_IN_KEY, and NONCE_KEY.
 *
 * @return void
 */
function sucuriscan_harden_secretkeys(){
    $wp_config_path = SucuriScan::get_wpconfig_path();
    $current_keys = SucuriScanOption::get_security_keys();

    if( $wp_config_path ){
        $cp = 1;
        $message = 'The main configuration file was found at: <code>'.$wp_config_path.'</code><br>';

        if(
            !empty($current_keys['bad'])
            || !empty($current_keys['missing'])
        ){
            $cp = 0;
        }
    }else{
        $cp = 0;
        $message = 'The <code>wp-config.php</code> file was not found.<br>';
    }

    $message .= '<br>It checks whether you have proper random keys/salts created for WordPress. A
        <a href="http://codex.wordpress.org/Editing_wp-config.php#Security_Keys" target="_blank">
        secret key</a> makes your site harder to hack and access harder to crack by adding
        random elements to the password. In simple terms, a secret key is a password with
        elements that make it harder to generate enough options to break through your
        security barriers.';
    $messageok = 'Security keys and salts not set, we recommend creating them for security reasons'
        . '<a href="' . SucuriScanTemplate::get_url('posthack') . '" class="button button-primary">'
        . 'Harden</a>';

    sucuriscan_harden_status(
        'Security keys',
        $cp,
        NULL,
        'Security keys and salts properly created',
        $messageok,
        $message,
        NULL
    );
}

/**
 * Check whether the "readme.html" file is still available in the root of the
 * site or not, which can lead to an attacker to know which version number of
 * Wordpress is being used and search for possible vulnerabilities.
 *
 * @return void
 */
function sucuriscan_harden_readme(){
    $upmsg = NULL;
    $cp = is_readable(ABSPATH.'/readme.html') ? 0 : 1;

    // TODO: After hardening create an option to automatically remove this after WP upgrade.
    if( SucuriScanRequest::post(':run_hardening') ){
        if( SucuriScanRequest::post(':harden_readme') && $cp == 0 ){
            if( @unlink(ABSPATH.'/readme.html') === FALSE ){
                $upmsg = SucuriScanInterface::error('Unable to remove <code>readme.html</code> file.');
            } else {
                $cp = 1;
                $upmsg = SucuriScanInterface::info('<code>readme.html</code> file removed successfully.');
            }
        }

        elseif( SucuriScanRequest::post(':harden_readme_unharden') ){
            SucuriScanInterface::error('We can not revert this action, you must create the <code>readme.html</code> file by yourself.');
        }
    }

    sucuriscan_harden_status(
        'Information leakage (readme.html)',
        $cp,
        ( $cp == 0 ? 'sucuriscan_harden_readme' : NULL ),
        '<code>readme.html</code> file properly deleted',
        '<code>readme.html</code> not deleted and leaking the WordPress version',
        'It checks whether you have the <code>readme.html</code> file available that leaks your WordPress version',
        $upmsg
    );
}

/**
 * Check whether the main administrator user still has the default name "admin"
 * or not, which can lead to an attacker to perform a brute force attack.
 *
 * @return void
 */
function sucuriscan_harden_adminuser(){
    global $wpdb;

    $upmsg = NULL;
    $user_query = new WP_User_Query(array(
        'search' => 'admin',
        'fields' => array( 'ID', 'user_login' ),
        'search_columns' => array( 'user_login' ),
    ));
    $results = $user_query->get_results();
    $account_removed = ( count($results) === 0 ? 1 : 0 );

    if( $account_removed === 0 ){
        $upmsg = '<i><strong>Notice.</strong> We do not offer an option to automatically change the user name.
        Go to the <a href="'.admin_url('users.php').'" target="_blank">user list</a> and create a new
        administrator user. Once created, log in as that user and remove the default <code>admin</code>
        (make sure to assign all the admin posts to the new user too).</i>';
    }

    sucuriscan_harden_status(
        'Default admin account',
        $account_removed,
        NULL,
        'Default admin user account (admin) not being used',
        'Default admin user account (admin) being used. Not recommended',
        'It checks whether you have the default <code>admin</code> account enabled, security guidelines recommend creating a new admin user name.',
        $upmsg
    );
}

/**
 * Enable or disable the user of the built-in Wordpress file editor.
 *
 * @return void
 */
function sucuriscan_harden_fileeditor(){
    $file_editor_disabled = defined('DISALLOW_FILE_EDIT') ? DISALLOW_FILE_EDIT : FALSE;

    if( SucuriScanRequest::post(':run_hardening') ){
        $current_time = date('r');
        $wp_config_path = SucuriScan::get_wpconfig_path();

        $wp_config_writable = ( file_exists($wp_config_path) && is_writable($wp_config_path) ) ? TRUE : FALSE;
        $new_wpconfig = $wp_config_writable ? file_get_contents($wp_config_path) : '';

        if( SucuriScanRequest::post(':harden_fileeditor') ){
            if( $wp_config_writable ){
                if( preg_match('/(.*define\(.DB_COLLATE..*)/', $new_wpconfig, $match) ){
                    $disallow_fileedit_definition = "\n\ndefine('DISALLOW_FILE_EDIT', TRUE); // Sucuri Security: {$current_time}\n";
                    $new_wpconfig = str_replace($match[0], $match[0].$disallow_fileedit_definition, $new_wpconfig);
                }

                @file_put_contents($wp_config_path, $new_wpconfig, LOCK_EX);
                SucuriScanInterface::info( 'Configuration file updated successfully, the plugin and theme editor were disabled.' );
                $file_editor_disabled = TRUE;
            } else {
                SucuriScanInterface::error( 'The <code>wp-config.php</code> file is not in the default location
                    or is not writable, you will need to put the following code manually there:
                    <code>define("DISALLOW_FILE_EDIT", TRUE);</code>' );
            }
        }

        elseif( SucuriScanRequest::post(':harden_fileeditor_unharden') ){
            if( preg_match("/(.*define\('DISALLOW_FILE_EDIT', TRUE\);.*)/", $new_wpconfig, $match) ){
                if( $wp_config_writable ){
                    $new_wpconfig = str_replace("\n{$match[1]}", '', $new_wpconfig);
                    file_put_contents($wp_config_path, $new_wpconfig, LOCK_EX);
                    SucuriScanInterface::info( 'Configuration file updated successfully, the plugin and theme editor were enabled.' );
                    $file_editor_disabled = FALSE;
                } else {
                    SucuriScanInterface::error( 'The <code>wp-config.php</code> file is not in the default location
                        or is not writable, you will need to remove the following code manually from there:
                        <code>define("DISALLOW_FILE_EDIT", TRUE);</code>' );
                }
            } else {
                SucuriScanInterface::error( 'The theme and plugin editor are not disabled from the configuration file.' );
            }
        }
    }

    $message = 'Occasionally you may wish to disable the plugin or theme editor to prevent overzealous
        users from being able to edit sensitive files and potentially crash the site. Disabling these
        also provides an additional layer of security if a hacker gains access to a well-privileged
        user account.';

    sucuriscan_harden_status(
        'Plugin &amp; Theme editor',
        ( $file_editor_disabled === FALSE ? 0 : 1 ),
        'sucuriscan_harden_fileeditor',
        'File editor for Plugins and Themes is disabled',
        'File editor for Plugins and Themes is enabled',
        $message,
        NULL
    );
}

/**
 * Check whether the prefix of each table in the database designated for the site
 * is the same as the default prefix defined by Wordpress "_wp", in that case the
 * "harden" button will generate randomly a new prefix and rename all those tables.
 *
 * @return void
 */
function sucuriscan_harden_dbtables(){
    global $table_prefix;

    $hardened = ( $table_prefix == 'wp_' ? 0 : 1 );

    sucuriscan_harden_status(
        'Database table prefix',
        $hardened,
        NULL,
        'Database table prefix properly modified',
        'Database table set to the default value <code>wp_</code>.',
        'It checks whether your database table prefix has been changed from the default <code>wp_</code>',
        '<strong>Be aware that this hardening procedure can cause your site to go down</strong>'
    );
}

/**
 * Check whether an error_log file exists in the project.
 *
 * @return void
 */
function sucuriscan_harden_errorlog(){
    $hardened = 1;
    $log_filename = SucuriScan::ini_get('error_log');
    $scan_errorlogs = SucuriScanOption::get_option(':scan_errorlogs');

    $description = 'PHP uses files named as <code>' . $log_filename . '</code> to log errors found in '
        . 'the code, these files may leak sensitive information of your project allowing an attacker '
        . 'to find vulnerabilities in the code. You must use these files to fix any bug while using '
        . 'a development environment, and remove them in production mode.';

    // Search error log files in the project.
    if( $scan_errorlogs != 'disabled' ){
        $sucuri_fileinfo = new SucuriScanFileInfo();
        $sucuri_fileinfo->ignore_files = FALSE;
        $sucuri_fileinfo->ignore_directories = FALSE;
        $error_logs = $sucuri_fileinfo->find_file('error_log');
        $total_log_files = count($error_logs);
    } else {
        $error_logs = array();
        $total_log_files = 0;
        $description .= '<div class="sucuriscan-inline-alert-error"><p>The filesystem scan for error '
            . 'log files is disabled, so even if there are logs in your project they will be not '
            . 'shown here. You can enable the scanner again from the plugin <em>Settings</em> '
            . 'page.</p></div>';
    }

    // Remove every error log file found in the filesystem scan.
    if( SucuriScanRequest::post(':run_hardening') ){
        if( SucuriScanRequest::post(':harden_errorlog') ){
            $removed_logs = 0;

            foreach( $error_logs as $i => $error_log_path ){
                if( unlink($error_log_path) ){
                    unset($error_logs[$i]);
                    $removed_logs += 1;
                }
            }

            SucuriScanInterface::info( 'Error log files removed <code>' . $removed_logs . ' out of ' . $total_log_files . '</code>' );
        }
    }

    // List the error log files in a HTML table.
    if( !empty($error_logs) ){
        $hardened = 0;
        $description .= '</p><ul class="sucuriscan-list-as-table">';

        foreach( $error_logs as $error_log_path ){
            $description .= '<li>' . $error_log_path . '</li>';
        }

        $description .= '</ul><p>';
    }

    sucuriscan_harden_status(
        'Error logs',
        $hardened,
        ( $hardened == 0 ? 'sucuriscan_harden_errorlog' : NULL ),
        'There are no error log files in your project.',
        'There are ' . $total_log_files . ' error log files in your project.',
        $description,
        NULL
    );
}

/**
 * WordPress core integrity page.
 *
 * It checks whether the WordPress core files are the original ones, and the state
 * of the themes and plugins reporting the availability of updates. It also checks
 * the user accounts under the administrator group.
 *
 * @return void
 */
function sucuriscan_page(){
    SucuriScanInterface::check_permissions();

    // Process all form submissions.
    sucuriscan_integrity_form_submissions();

    $template_variables = array(
        'WordpressVersion' => sucuriscan_wordpress_outdated(),
        'AuditLogs' => sucuriscan_auditlogs(),
        'CoreFiles' => sucuriscan_core_files(),
    );

    echo SucuriScanTemplate::get_template('integrity', $template_variables);
}

/**
 * Process the requests sent by the form submissions originated in the integrity
 * page, all forms must have a nonce field that will be checked against the one
 * generated in the template render function.
 *
 * @return void
 */
function sucuriscan_integrity_form_submissions(){
    if( SucuriScanInterface::check_nonce() ){

        // Force the execution of the filesystem scanner.
        if( SucuriScanRequest::post(':force_scan') !== false ){
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scan forced at: ' . date('r') );
            SucuriScanEvent::filesystem_scan(TRUE);
        }

        // Restore, Remove, Mark as fixed the core files.
        $allowed_actions = '(restore|remove|fixed)';
        $integrity_action = SucuriScanRequest::post(':integrity_action', $allowed_actions);

        if( $integrity_action !== FALSE ){
            $cache = new SucuriScanCache('integrity');
            $integrity_files = SucuriScanRequest::post(':integrity_files', '_array');
            $integrity_types = SucuriScanRequest::post(':integrity_types', '_array');
            $files_selected = count($integrity_files);
            $files_processed = 0;

            foreach( $integrity_files as $i => $file_path ){
                $full_path = ABSPATH . $file_path;
                $status_type = $integrity_types[$i];

                switch( $integrity_action ){
                    case 'restore':
                        $file_content = SucuriScanAPI::get_original_core_file($file_path);
                        if( $file_content ){
                            $restored = @file_put_contents( $full_path, $file_content, LOCK_EX );
                            $files_processed += ( $restored ? 1 : 0 );
                        }
                        break;
                    case 'remove':
                        if( @unlink($full_path) ){
                            $files_processed += 1;
                        }
                        break;
                    case 'fixed':
                        $cache_key = md5($file_path);
                        $cache_value = array(
                            'file_path' => $file_path,
                            'file_status' => $status_type,
                            'ignored_at' => time(),
                        );
                        $cached = $cache->add( $cache_key, $cache_value );
                        $files_processed += ( $cached ? 1 : 0 );
                        break;
                }
            }

            SucuriScanInterface::info(sprintf(
                '<code>%d</code> out of <code>%d</code> files were successfully processed.',
                $files_selected,
                $files_processed
            ));
        }

    }
}

/**
 * Retrieve a list of md5sum and last modification time of all the files in the
 * folder specified. This is a recursive function.
 *
 * @param  string  $dir       The base path where the scanning will start.
 * @param  boolean $recursive Either TRUE or FALSE if the scan should be performed recursively.
 * @return array              List of arrays containing the md5sum and last modification time of the files found.
 */
function sucuriscan_get_integrity_tree( $dir='./', $recursive=FALSE ){
    $abs_path = rtrim( ABSPATH, '/' );

    $sucuri_fileinfo = new SucuriScanFileInfo();
    $sucuri_fileinfo->ignore_files = FALSE;
    $sucuri_fileinfo->ignore_directories = FALSE;
    $sucuri_fileinfo->run_recursively = $recursive;
    $sucuri_fileinfo->scan_interface = 'opendir';
    $integrity_tree = $sucuri_fileinfo->get_directory_tree_md5( $dir, TRUE );

    if( !$integrity_tree ){
        $integrity_tree = array();
    }

    return $integrity_tree;
}

/**
 * Print a HTML code with the content of the logs audited by the remote Sucuri
 * API service, this page is part of the monitoring tool.
 *
 * @return void
 */
function sucuriscan_auditlogs(){

    // Initialize the values for the pagination.
    $max_per_page = SUCURISCAN_AUDITLOGS_PER_PAGE;
    $page_number = SucuriScanTemplate::get_page_number();
    $logs_limit = $page_number * $max_per_page;
    $audit_logs = SucuriScanAPI::get_logs($logs_limit);

    $template_variables = array(
        'PageTitle' => 'Audit Logs',
        'AuditLogs.List' => '',
        'AuditLogs.Count' => 0,
        'AuditLogs.MaxPerPage' => $max_per_page,
        'AuditLogs.NoItemsVisibility' => 'visible',
        'AuditLogs.PaginationVisibility' => 'hidden',
        'AuditLogs.PaginationLinks' => '',
    );

    if( $audit_logs ){
        $counter_i = 0;
        $total_items = count($audit_logs->output_data);
        $offset = 0; // The initial position to start counting the data.

        if( $logs_limit == $total_items ){
            $offset = $logs_limit - ( $max_per_page + 1 );
        }

        for( $i=$offset; $i<$total_items; $i++ ){
            if( $counter_i > $max_per_page ){ break; }

            if( isset($audit_logs->output_data[$i]) ){
                $audit_log = $audit_logs->output_data[$i];

                $css_class = ( $counter_i % 2 == 0 ) ? '' : 'alternate';
                $snippet_data = array(
                    'AuditLog.CssClass' => $css_class,
                    'AuditLog.DateTime' => SucuriScan::datetime($audit_log['timestamp']),
                    'AuditLog.Account' => SucuriScan::escape($audit_log['account']),
                    'AuditLog.Message' => SucuriScan::escape($audit_log['message']),
                    'AuditLog.Extra' => '',
                );

                // Print every extra information item in a separate table.
                if( $audit_log['extra'] ){
                    $css_scrollable = $audit_log['extra_total'] > 10 ? 'sucuriscan-list-as-table-scrollable' : '';
                    $snippet_data['AuditLog.Extra'] .= '<ul class="sucuriscan-list-as-table ' . $css_scrollable . '">';
                    foreach( $audit_log['extra'] as $log_extra ){
                        $snippet_data['AuditLog.Extra'] .= '<li>' . SucuriScan::escape($log_extra) . '</li>';
                    }
                    $snippet_data['AuditLog.Extra'] .= '</ul>';
                }

                $template_variables['AuditLogs.List'] .= SucuriScanTemplate::get_snippet('integrity-auditlogs', $snippet_data);
                $counter_i += 1;
            }
        }

        $template_variables['AuditLogs.Count'] = $counter_i;
        $template_variables['AuditLogs.NoItemsVisibility'] = 'hidden';

        if( $total_items > 1 ){
            $max_pages = ceil( $audit_logs->total_entries / $max_per_page );

            if( $max_pages > SUCURISCAN_MAX_PAGINATION_BUTTONS ){
                $max_pages = SUCURISCAN_MAX_PAGINATION_BUTTONS;
            }

            if ( $max_pages > 1 ) {
                $template_variables['AuditLogs.PaginationVisibility'] = 'visible';
                $template_variables['AuditLogs.PaginationLinks'] = SucuriScanTemplate::get_pagination(
                    '%%SUCURI.URL.Home%%',
                    $max_per_page * $max_pages,
                    $max_per_page
                );
            }
        }
    }

    return SucuriScanTemplate::get_section('integrity-auditlogs', $template_variables);
}

/**
 * Check whether the WordPress version is outdated or not.
 *
 * @return string Panel with a warning advising that WordPress is outdated.
 */
function sucuriscan_wordpress_outdated(){
    $site_version = SucuriScan::site_version();
    $updates = get_core_updates();
    $cp = ( !is_array($updates) || empty($updates) ? 1 : 0 );

    $template_variables = array(
        'WordPress.Version' => $site_version,
        'WordPress.UpgradeURL' => admin_url('update-core.php'),
        'WordPress.UpdateVisibility' => 'hidden',
        'WordPressBeta.Visibility' => 'hidden',
        'WordPressBeta.Version' => '0.0.0',
        'WordPressBeta.UpdateURL' => admin_url('update-core.php'),
        'WordPressBeta.DownloadURL' => '#',
    );

    if( isset($updates[0]) && $updates[0] instanceof stdClass ){
        if( $updates[0]->response == 'latest' ){
            $cp = 1;
        }

        elseif( $updates[0]->response == 'development' ){
            $cp = 1;
            $template_variables['WordPressBeta.Visibility'] = 'visible';
            $template_variables['WordPressBeta.Version'] = $updates[0]->version;
            $template_variables['WordPressBeta.DownloadURL'] = $updates[0]->download;
        }
    }

    if( strcmp($site_version, '3.7') < 0 ){
        $cp = 0;
    }

    if( $cp == 0 ){
        $template_variables['WordPress.UpdateVisibility'] = 'visible';
    }

    return SucuriScanTemplate::get_section('integrity-wpoutdate', $template_variables);
}

/**
 * Compare the md5sum of the core files in the current site with the hashes hosted
 * remotely in Sucuri servers. These hashes are updated every time a new version
 * of WordPress is released.
 *
 * @return void
 */
function sucuriscan_core_files(){
    $site_version = SucuriScan::site_version();

    $template_variables = array(
        'CoreFiles.List' => '',
        'CoreFiles.ListCount' => 0,
        'CoreFiles.GoodVisibility' => 'visible',
        'CoreFiles.BadVisibility' => 'hidden',
    );

    if( $site_version && SucuriScanOption::get_option(':scan_checksums') == 'enabled' ){
        // Check if there are added, removed, or modified files.
        $latest_hashes = sucuriscan_check_core_integrity($site_version);

        if( $latest_hashes ){
            $cache = new SucuriScanCache('integrity');
            $ignored_files = $cache->get_all();
            $counter = 0;

            foreach( $latest_hashes as $list_type => $file_list ){
                if(
                    $list_type == 'stable'
                    || empty($file_list)
                ){
                    continue;
                }

                foreach( $file_list as $file_path ){
                    // Skip files that were marked as fixed.
                    if( $ignored_files ){
                        $file_path_checksum = md5($file_path);

                        if( array_key_exists($file_path_checksum, $ignored_files) ){
                            continue;
                        }
                    }

                    // Generate the HTML code from the snippet template for this file.
                    $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
                    $template_variables['CoreFiles.List'] .= SucuriScanTemplate::get_snippet('integrity-corefiles', array(
                        'CoreFiles.CssClass' => $css_class,
                        'CoreFiles.StatusType' => $list_type,
                        'CoreFiles.StatusAbbr' => substr($list_type, 0, 1),
                        'CoreFiles.FilePath' => $file_path,
                    ));
                    $counter += 1;
                }
            }

            if( $counter > 0 ){
                $template_variables['CoreFiles.ListCount'] = $counter;
                $template_variables['CoreFiles.GoodVisibility'] = 'hidden';
                $template_variables['CoreFiles.BadVisibility'] = 'visible';
            }
        } else {
            SucuriScanInterface::error( 'Error retrieving the WordPress core hashes, try again.' );
        }
    }

    return SucuriScanTemplate::get_section('integrity-corefiles', $template_variables);
}

/**
 * Check whether the core WordPress files where modified, removed or if any file
 * was added to the core folders. This function returns an associative array with
 * these keys:
 *
 * <ul>
 *   <li>modified: Files with a different checksum according to the official files of the WordPress version filtered,</li>
 *   <li>stable: Files with the same checksums than the official files,</li>
 *   <li>removed: Official files which are not present in the local project,</li>
 *   <li>added: Files present in the local project but not in the official WordPress packages.</li>
 * </ul>
 *
 * @param  integer $version Valid version number of the WordPress project.
 * @return array            Associative array with these keys: modified, stable, removed, added.
 */
function sucuriscan_check_core_integrity( $version=0 ){
    $latest_hashes = SucuriScanAPI::get_official_checksums($version);

    if( !$latest_hashes ){ return FALSE; }

    $output = array(
        'added' => array(),
        'removed' => array(),
        'modified' => array(),
        'stable' => array(),
    );

    // Get current filesystem tree.
    $wp_top_hashes = sucuriscan_get_integrity_tree( ABSPATH , false);
    $wp_admin_hashes = sucuriscan_get_integrity_tree( ABSPATH . 'wp-admin', true);
    $wp_includes_hashes = sucuriscan_get_integrity_tree( ABSPATH . 'wp-includes', true);
    $wp_core_hashes = array_merge( $wp_top_hashes, $wp_admin_hashes, $wp_includes_hashes );

    // Compare remote and local checksums and search removed files.
    foreach( $latest_hashes as $file_path => $remote_checksum ){
        if( sucuriscan_ignore_integrity_filepath($file_path) ){ continue; }

        $full_filepath = sprintf('%s/%s', ABSPATH, $file_path);

        if( file_exists($full_filepath) ){
            $local_checksum = @md5_file($full_filepath);

            if( $local_checksum && $local_checksum == $remote_checksum ){
                $output['stable'][] = $file_path;
            } else {
                $output['modified'][] = $file_path;
            }
        } else {
            $output['removed'][] = $file_path;
        }
    }

    // Search added files (files not common in a normal wordpress installation).
    foreach( $wp_core_hashes as $file_path => $extra_info ){
        $file_path = preg_replace('/^\.\/(.*)/', '$1', $file_path);

        if( sucuriscan_ignore_integrity_filepath($file_path) ){ continue; }

        if( !isset($latest_hashes[$file_path]) ){
            $output['added'][] = $file_path;
        }
    }

    return $output;
}

/**
 * Ignore irrelevant files and directories from the integrity checking.
 *
 * @param  string  $file_path File path that will be compared.
 * @return boolean            TRUE if the file should be ignored, FALSE otherwise.
 */
function sucuriscan_ignore_integrity_filepath( $file_path='' ){
    global $wp_local_package;

    // List of files that will be ignored from the integrity checking.
    $ignore_files = array(
        '^sucuri-[0-9a-z]+\.php$',
        '^favicon\.ico$',
        '^php\.ini$',
        '^\.htaccess$',
        '^wp-includes\/\.htaccess$',
        '^wp-admin\/setup-config\.php$',
        '^wp-(config|pass|rss|feed|register|atom|commentsrss2|rss2|rdf)\.php$',
        '^wp-content\/(themes|plugins)\/.+', // TODO: Add the popular themes/plugins integrity checks.
        '^sitemap\.xml($|\.gz)$',
        '^readme\.html$',
        '^(503|404)\.php$',
        '^500\.(shtml|php)$',
        '^40[0-9]\.shtml$',
        '^([^\/]*)\.(pdf|css|txt)$',
        '^google[0-9a-z]{16}\.html$',
        '^pinterest-[0-9a-z]{5}\.html$',
        '(^|\/)error_log$',
    );

    /**
     * Ignore i18n files.
     *
     * Sites with i18n have differences compared with the official English version
     * of the project, basically they have files with new variables specifying the
     * language that will be used in the admin panel, site options, and emails.
     */
    if(
        isset($wp_local_package)
        && $wp_local_package != 'en_US'
    ){
        $ignore_files[] = 'wp-includes\/version\.php';
        $ignore_files[] = 'wp-config-sample\.php';
    }

    // Determine whether a file must be ignored from the integrity checks or not.
    foreach( $ignore_files as $ignore_pattern ){
        if( preg_match('/'.$ignore_pattern.'/', $file_path) ){
            return TRUE;
        }
    }

    return FALSE;
}

/**
 * List all files inside wp-content that have been modified in the last days.
 *
 * @return void
 */
function sucuriscan_modified_files(){
    $valid_day_ranges = array( 1, 3, 7, 30, 60 );
    $template_variables = array(
        'ModifiedFiles.List' => '',
        'ModifiedFiles.SelectOptions' => '',
        'ModifiedFiles.NoFilesVisibility' => 'visible',
        'ModifiedFiles.Days' => 0,
    );

    // Find files modified in the last days.
    $back_days = 7;

    // Set the ranges of the search to be between one and sixty days.
    if( SucuriScanInterface::check_nonce() ){
        $back_days = (int) SucuriScanRequest::post(':last_days', '[0-9]+');
        if    ( $back_days <= 0  ){ $back_days = 1;  }
        elseif( $back_days >= 60 ){ $back_days = 60; }
    }

    // Generate the options for the select field of the page form.
    foreach( $valid_day_ranges as $day ){
        $selected_option = ($back_days == $day) ? 'selected="selected"' : '';
        $template_variables['ModifiedFiles.SelectOptions'] .= sprintf(
            '<option value="%d" %s>%d</option>',
            $day, $selected_option, $day
        );
    }

    // The scanner for modified files can be disabled from the settings page.
    if( SucuriScanOption::get_option(':scan_modfiles') == 'enabled' ){
        // Search modified files among the project's files.
        $content_hashes = sucuriscan_get_integrity_tree( ABSPATH.'wp-content', true );

        if( !empty($content_hashes) ){
            $template_variables['ModifiedFiles.Days'] = $back_days;
            $back_days = current_time('timestamp') - ( $back_days * 86400);
            $counter = 0;

            foreach( $content_hashes as $file_path => $file_info ){
                if(
                    isset($file_info['modified_at'])
                    && $file_info['modified_at'] >= $back_days
                ){
                    $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
                    $mod_date = SucuriScan::datetime($file_info['modified_at']);

                    $template_variables['ModifiedFiles.List'] .= SucuriScanTemplate::get_snippet('integrity-modifiedfiles', array(
                        'ModifiedFiles.CssClass' => $css_class,
                        'ModifiedFiles.CheckSum' => $file_info['checksum'],
                        'ModifiedFiles.FilePath' => $file_path,
                        'ModifiedFiles.DateTime' => $mod_date,
                    ));
                    $counter += 1;
                }
            }

            if( $counter > 0 ){
                $template_variables['ModifiedFiles.NoFilesVisibility'] = 'hidden';
            }
        }
    }

    return SucuriScanTemplate::get_section('integrity-modifiedfiles', $template_variables);
}

/**
 * Generate and print the HTML code for the Post-Hack page.
 *
 * @return void
 */
function sucuriscan_posthack_page(){
    SucuriScanInterface::check_permissions();

    $process_form = sucuriscan_posthack_process_form();

    // Page pseudo-variables initialization.
    $template_variables = array(
        'PageTitle' => 'Post-Hack',
        'UpdateSecretKeys' => sucuriscan_update_secret_keys($process_form),
        'ResetPassword' => sucuriscan_posthack_users($process_form),
        'ResetPlugins' => sucuriscan_posthack_plugins($process_form),
    );

    echo SucuriScanTemplate::get_template('posthack', $template_variables);
}

/**
 * Check whether the "I understand this operation" checkbox was marked or not.
 *
 * @return boolean TRUE if a form submission should be processed, FALSE otherwise.
 */
function sucuriscan_posthack_process_form(){
    $process_form = SucuriScanRequest::post(':process_form', '(0|1)');

    if(
        SucuriScanInterface::check_nonce()
        && $process_form !== FALSE
    ){
        if( $process_form === '1' ){
            return TRUE;
        } else {
            SucuriScanInterface::error('You need to confirm that you understand the risk of this operation.');
        }
    }

    return FALSE;
}

/**
 * Update the WordPress secret keys.
 *
 * @param  $process_form Whether a form was submitted or not.
 * @return string        HTML code with the information of the process.
 */
function sucuriscan_update_secret_keys( $process_form=FALSE ){
    $template_variables = array(
        'WPConfigUpdate.Visibility' => 'hidden',
        'WPConfigUpdate.NewConfig' => '',
        'SecurityKeys.List' => '',
    );

    // Update all WordPress secret keys.
    if( $process_form && SucuriScanRequest::post(':update_wpconfig', '1') ){
        $wpconfig_process = SucuriScanEvent::set_new_config_keys();

        if( $wpconfig_process ){
            $template_variables['WPConfigUpdate.Visibility'] = 'visible';

            if( $wpconfig_process['updated'] === TRUE ){
                SucuriScanInterface::info( 'Secret keys updated successfully (summary of the operation bellow).' );
                $template_variables['WPConfigUpdate.NewConfig'] .= "// Old Keys\n";
                $template_variables['WPConfigUpdate.NewConfig'] .= $wpconfig_process['old_keys_string'];
                $template_variables['WPConfigUpdate.NewConfig'] .= "//\n";
                $template_variables['WPConfigUpdate.NewConfig'] .= "// New Keys\n";
                $template_variables['WPConfigUpdate.NewConfig'] .= $wpconfig_process['new_keys_string'];
            } else {
                SucuriScanInterface::error(
                    '<code>wp-config.php</code> file is not writable, replace the '
                    . 'old configuration file with the new values shown bellow.'
                );
                $template_variables['WPConfigUpdate.NewConfig'] = $wpconfig_process['new_wpconfig'];
            }
        } else {
            SucuriScanInterface::error('<code>wp-config.php</code> file was not found in the default location.' );
        }
    }

    // Display the current status of the security keys.
    $current_keys = SucuriScanOption::get_security_keys();
    $counter = 0;

    foreach( $current_keys as $key_status => $key_list ){
        foreach( $key_list as $key_name => $key_value ){
            $css_class = ( $counter %2 == 0 ) ? '' : 'alternate';
            $key_value = SucuriScan::excerpt( $key_value, 50 );

            switch( $key_status ){
                case 'good':
                    $key_status_text = 'good';
                    $key_status_css_class = 'success';
                    break;
                case 'bad':
                    $key_status_text = 'not randomized';
                    $key_status_css_class = 'warning';
                    break;
                case 'missing':
                    $key_value = '';
                    $key_status_text = 'not set';
                    $key_status_css_class = 'danger';
                    break;
            }

            if( isset($key_status_text) ){
                $template_variables['SecurityKeys.List'] .= SucuriScanTemplate::get_snippet('posthack-updatesecretkeys', array(
                    'SecurityKey.CssClass' => $css_class,
                    'SecurityKey.KeyName' => SucuriScan::escape($key_name),
                    'SecurityKey.KeyValue' => SucuriScan::escape($key_value),
                    'SecurityKey.KeyStatusText' => $key_status_text,
                    'SecurityKey.KeyStatusCssClass' => $key_status_css_class,
                ));
                $counter += 1;
            }
        }
    }

    return SucuriScanTemplate::get_section('posthack-updatesecretkeys', $template_variables);
}

/**
 * Display a list of users in a table that will be used to select the accounts
 * where a password reset action will be executed.
 *
 * @param  $process_form Whether a form was submitted or not.
 * @return string        HTML code for a table where a list of user accounts will be shown.
 */
function sucuriscan_posthack_users( $process_form=FALSE ){
    $template_variables = array(
        'ResetPassword.UserList' => '',
    );

    // Process the form submission (if any).
    sucuriscan_reset_user_password($process_form);

    // Fill the user list for ResetPassword action.
    $user_list = get_users();

    if( $user_list ){
        $counter = 0;

        foreach( $user_list as $user ){
            $user->user_registered_timestamp = strtotime($user->user_registered);
            $user->user_registered_formatted = SucuriScan::datetime($user->user_registered_timestamp);
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';

            $template_variables['ResetPassword.UserList'] .= SucuriScanTemplate::get_snippet('posthack-resetpassword', array(
                'ResetPassword.UserId' => $user->ID,
                'ResetPassword.Username' => SucuriScan::escape($user->user_login),
                'ResetPassword.Displayname' => SucuriScan::escape($user->display_name),
                'ResetPassword.Email' => SucuriScan::escape($user->user_email),
                'ResetPassword.Registered' => $user->user_registered_formatted,
                'ResetPassword.Roles' => implode(', ', $user->roles),
                'ResetPassword.CssClass' => $css_class,
            ));

            $counter += 1;
        }
    }

    return SucuriScanTemplate::get_section('posthack-resetpassword', $template_variables);
}

/**
 * Update the password of the user accounts specified.
 *
 * @param  $process_form Whether a form was submitted or not.
 * @return void
 */
function sucuriscan_reset_user_password( $process_form=FALSE ){
    if( $process_form && SucuriScanRequest::post(':reset_password') ){
        $user_identifiers = SucuriScanRequest::post('user_ids', '_array');
        $pwd_changed = array();
        $pwd_not_changed = array();

        if( is_array($user_identifiers) && !empty($user_identifiers) ){
            arsort($user_identifiers);

            foreach( $user_identifiers as $user_id ){
                if( SucuriScanEvent::set_new_password($user_id) ){
                    $pwd_changed[] = $user_id;
                } else {
                    $pwd_not_changed[] = $user_id;
                }
            }

            if( !empty($pwd_changed) ){
                SucuriScanInterface::info( 'Password changed successfully for users: ' . implode(', ',$pwd_changed) );
            }

            if( !empty($pwd_not_changed) ){
                SucuriScanInterface::error( 'Password change failed for users: ' . implode(', ',$pwd_not_changed) );
            }
        } else {
            SucuriScanInterface::error( 'You did not select a user from the list.' );
        }
    }
}

/**
 * Reset all the FREE plugins, even if they are not activated.
 *
 * @param  boolean $process_form Whether a form was submitted or not.
 * @return void
 */
function sucuriscan_posthack_plugins( $process_form=FALSE ){
    $template_variables = array(
        'ResetPlugin.PluginList' => '',
    );

    sucuriscan_posthack_reinstall_plugins($process_form);
    $all_plugins = SucuriScanAPI::get_plugins();
    $counter = 0;

    foreach( $all_plugins as $plugin_path => $plugin_data ){
        $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
        $plugin_type_class = ( $plugin_data['PluginType'] == 'free' ) ? 'primary' : 'warning';
        $input_disabled = ( $plugin_data['PluginType'] == 'free' ) ? '' : 'disabled="disabled"';
        $plugin_status = $plugin_data['IsPluginActive'] ? 'active' : 'not active';
        $plugin_status_class = $plugin_data['IsPluginActive'] ? 'success' : 'default';

        $template_variables['ResetPlugin.PluginList'] .= SucuriScanTemplate::get_snippet('posthack-resetplugins', array(
            'ResetPlugin.CssClass' => $css_class,
            'ResetPlugin.Disabled' => $input_disabled,
            'ResetPlugin.PluginPath' => SucuriScan::escape($plugin_path),
            'ResetPlugin.Plugin' => SucuriScan::excerpt($plugin_data['Name'], 35),
            'ResetPlugin.Version' => $plugin_data['Version'],
            'ResetPlugin.Type' => $plugin_data['PluginType'],
            'ResetPlugin.TypeClass' => $plugin_type_class,
            'ResetPlugin.Status' => $plugin_status,
            'ResetPlugin.StatusClass' => $plugin_status_class,
        ));

        $counter += 1;
    }

    return SucuriScanTemplate::get_section('posthack-resetplugins', $template_variables);
}

/**
 * Process the request that will start the execution of the plugin
 * reinstallation, it will check if the plugins submitted are (in fact)
 * installed in the system, then check if they are free download from the
 * WordPress market place, and finally download and install them.
 *
 * @param  boolean $process_form Whether a form was submitted or not.
 * @return void
 */
function sucuriscan_posthack_reinstall_plugins( $process_form=FALSE ){
    if( $process_form && isset($_POST['sucuriscan_reset_plugins']) ){
        include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
        include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); // For plugins_api.

        if( $plugin_list = SucuriScanRequest::post('plugin_path', '_array') ){
            // Create an instance of the FileInfo interface.
            $sucuri_fileinfo = new SucuriScanFileInfo();
            $sucuri_fileinfo->ignore_files = FALSE;
            $sucuri_fileinfo->ignore_directories = FALSE;

            // Get (possible) cached information from the installed plugins.
            $all_plugins = SucuriScanAPI::get_plugins();

            // Loop through all the installed plugins.
            foreach( $_POST['plugin_path'] as $plugin_path ){
                if( array_key_exists($plugin_path, $all_plugins) ){
                    $plugin_data = $all_plugins[$plugin_path];

                    // Check if the plugin can be downloaded from the free market.
                    if( $plugin_data['IsFreePlugin'] === TRUE ){
                        $plugin_info = SucuriScanAPI::get_remote_plugin_data($plugin_data['RepositoryName']);

                        if( $plugin_info ){
                            // First, remove all files/sub-folders from the plugin's directory.
                            $plugin_directory = dirname( WP_PLUGIN_DIR . '/' . $plugin_path );
                            $sucuri_fileinfo->remove_directory_tree($plugin_directory);

                            // Install a fresh copy of the plugin's files.
                            $upgrader_skin = new Plugin_Installer_Skin();
                            $upgrader = new Plugin_Upgrader($upgrader_skin);
                            $upgrader->install($plugin_info->download_link);
                        } else {
                            SucuriScanInterface::error( 'Could not establish a stable connection with the WordPress plugins market.' );
                        }
                    }
                }
            }
        } else {
            SucuriScanInterface::error( 'You did not select a free plugin to reinstall.' );
        }
    }
}

/**
 * Generate and print the HTML code for the Last Logins page.
 *
 * This page will contains information of all the logins of the registered users.
 *
 * @return string Last-logings for the administrator accounts.
 */
function sucuriscan_lastlogins_page(){
    SucuriScanInterface::check_permissions();

    // Reset the file with the last-logins logs.
    if(
        SucuriScanInterface::check_nonce()
        && SucuriScanRequest::post(':reset_lastlogins') !== FALSE
    ){
        $file_path = sucuriscan_lastlogins_datastore_filepath();

        if( unlink($file_path) ){
            sucuriscan_lastlogins_datastore_exists();
            SucuriScanInterface::info( 'Last-Logins logs were reset successfully.' );
        } else {
            SucuriScanInterface::error( 'Could not reset the last-logins logs.' );
        }
    }

    // Page pseudo-variables initialization.
    $template_variables = array(
        'PageTitle' => 'Last Logins',
        'LastLogins.Admins' => sucuriscan_lastlogins_admins(),
        'LastLogins.AllUsers' => sucuriscan_lastlogins_all(),
        'LoggedInUsers' => sucuriscan_loggedin_users_panel(),
        'FailedLogins' => sucuriscan_failed_logins_panel(),
    );

    echo SucuriScanTemplate::get_template('lastlogins', $template_variables);
}

/**
 * List all the user administrator accounts.
 *
 * @see http://codex.wordpress.org/Class_Reference/WP_User_Query
 *
 * @return void
 */
function sucuriscan_lastlogins_admins(){
    // Page pseudo-variables initialization.
    $template_variables = array(
        'AdminUsers.List' => ''
    );

    $user_query = new WP_User_Query(array( 'role' => 'Administrator' ));
    $admins = $user_query->get_results();

    foreach( (array) $admins as $admin ){
        $last_logins = sucuriscan_get_logins(5, 0, $admin->ID);
        $admin->lastlogins = $last_logins['entries'];

        $user_snippet = array(
            'AdminUsers.Username' => SucuriScan::escape($admin->user_login),
            'AdminUsers.Email' => SucuriScan::escape($admin->user_email),
            'AdminUsers.LastLogins' => '',
            'AdminUsers.RegisteredAt' => 'Undefined',
            'AdminUsers.UserURL' => admin_url('user-edit.php?user_id='.$admin->ID),
            'AdminUsers.NoLastLogins' => 'visible',
            'AdminUsers.NoLastLoginsTable' => 'hidden',
        );

        if( !empty($admin->lastlogins) ){
            $user_snippet['AdminUsers.NoLastLogins'] = 'hidden';
            $user_snippet['AdminUsers.NoLastLoginsTable'] = 'visible';
            $user_snippet['AdminUsers.RegisteredAt'] = 'Unknown';
            $counter = 0;

            foreach( $admin->lastlogins as $i => $lastlogin ){
                if( $i == 0 ){
                    $user_snippet['AdminUsers.RegisteredAt'] = SucuriScan::datetime($lastlogin->user_registered_timestamp);
                }

                $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
                $user_snippet['AdminUsers.LastLogins'] .= SucuriScanTemplate::get_snippet('lastlogins-admins-lastlogin', array(
                    'AdminUsers.RemoteAddr' => SucuriScan::escape($lastlogin->user_remoteaddr),
                    'AdminUsers.Datetime' => SucuriScan::datetime($lastlogin->user_lastlogin_timestamp),
                    'AdminUsers.CssClass' => $css_class,
                ));
                $counter += 1;
            }
        }

        $template_variables['AdminUsers.List'] .= SucuriScanTemplate::get_snippet('lastlogins-admins', $user_snippet);
    }

    return SucuriScanTemplate::get_section('lastlogins-admins', $template_variables);
}

/**
 * List the last-logins for all user accounts in the site.
 *
 * This page will contains information of all the logins of the registered users.
 *
 * @return string Last-logings for all user accounts.
 */
function sucuriscan_lastlogins_all(){
    $max_per_page = SUCURISCAN_LASTLOGINS_USERSLIMIT;
    $page_number = SucuriScanTemplate::get_page_number();
    $offset = ($max_per_page * $page_number) - $max_per_page;

    $template_variables = array(
        'UserList' => '',
        'UserList.Limit' => $max_per_page,
        'UserList.Total' => 0,
        'UserList.Pagination' => '',
        'UserList.PaginationVisibility' => 'hidden',
        'UserList.NoItemsVisibility' => 'visible',
    );

    if( !sucuriscan_lastlogins_datastore_is_writable() ){
        SucuriScanInterface::error( 'Last-logins datastore file is not writable: <code>'.sucuriscan_lastlogins_datastore_filepath().'</code>' );
    }

    $counter = 0;
    $last_logins = sucuriscan_get_logins( $max_per_page, $offset );
    $template_variables['UserList.Total'] = $last_logins['total'];

    if( $last_logins['total'] > $max_per_page ){
        $template_variables['UserList.PaginationVisibility'] = 'visible';
    }

    if( $last_logins['total'] > 0 ){
        $template_variables['UserList.NoItemsVisibility'] = 'hidden';
    }

    foreach( $last_logins['entries'] as $user ){
        $counter += 1;
        $css_class = ( $counter % 2 == 0 ) ? 'alternate' : '';

        $user_dataset = array(
            'UserList.Number' => $user->line_num,
            'UserList.UserId' => $user->user_id,
            'UserList.Username' => '<em>Unknown</em>',
            'UserList.Displayname' => '',
            'UserList.Email' => '',
            'UserList.Registered' => '',
            'UserList.RemoteAddr' => SucuriScan::escape($user->user_remoteaddr),
            'UserList.Hostname' => SucuriScan::escape($user->user_hostname),
            'UserList.Datetime' => SucuriScan::escape($user->user_lastlogin),
            'UserList.TimeAgo' => SucuriScan::time_ago($user->user_lastlogin),
            'UserList.UserURL' => admin_url('user-edit.php?user_id='.$user->user_id),
            'UserList.CssClass' => $css_class,
        );

        if( $user->user_exists ){
            $user_dataset['UserList.Username'] = SucuriScan::escape($user->user_login);
            $user_dataset['UserList.Displayname'] = SucuriScan::escape($user->display_name);
            $user_dataset['UserList.Email'] = SucuriScan::escape($user->user_email);
            $user_dataset['UserList.Registered'] = SucuriScan::escape($user->user_registered);
        }

        $template_variables['UserList'] .= SucuriScanTemplate::get_snippet('lastlogins-all', $user_dataset);
    }

    // Generate the pagination for the list.
    $template_variables['UserList.Pagination'] = SucuriScanTemplate::get_pagination(
        '%%SUCURI.URL.Lastlogins%%',
        $last_logins['total'],
        $max_per_page
    );

    return SucuriScanTemplate::get_section('lastlogins-all', $template_variables);
}

/**
 * Get the filepath where the information of the last logins of all users is stored.
 *
 * @return string Absolute filepath where the user's last login information is stored.
 */
function sucuriscan_lastlogins_datastore_filepath(){
    return SucuriScan::datastore_folder_path( 'sucuri-lastlogins.php' );
}

/**
 * Check whether the user's last login datastore file exists or not, if not then
 * we try to create the file and check again the success of the operation.
 *
 * @return string Absolute filepath where the user's last login information is stored.
 */
function sucuriscan_lastlogins_datastore_exists(){
    $datastore_filepath = sucuriscan_lastlogins_datastore_filepath();

    if( !file_exists($datastore_filepath) ){
        if( @file_put_contents($datastore_filepath, "<?php exit(0); ?>\n", LOCK_EX) ){
            @chmod($datastore_filepath, 0644);
        }
    }

    return file_exists($datastore_filepath) ? $datastore_filepath : FALSE;
}

/**
 * Check whether the user's last login datastore file is writable or not, if not
 * we try to set the right permissions and check again the success of the operation.
 *
 * @return boolean Whether the user's last login datastore file is writable or not.
 */
function sucuriscan_lastlogins_datastore_is_writable(){
    $datastore_filepath = sucuriscan_lastlogins_datastore_exists();

    if($datastore_filepath){
        if( !is_writable($datastore_filepath) ){
            @chmod($datastore_filepath, 0644);
        }

        if( is_writable($datastore_filepath) ){
            return $datastore_filepath;
        }
    }

    return FALSE;
}

/**
 * Check whether the user's last login datastore file is readable or not, if not
 * we try to set the right permissions and check again the success of the operation.
 *
 * @return boolean Whether the user's last login datastore file is readable or not.
 */
function sucuriscan_lastlogins_datastore_is_readable(){
    $datastore_filepath = sucuriscan_lastlogins_datastore_exists();

    if( $datastore_filepath && is_readable($datastore_filepath) ){
        return $datastore_filepath;
    }

    return FALSE;
}

if( !function_exists('sucuri_set_lastlogin') ){
    /**
     * Add a new user session to the list of last user logins.
     *
     * @param  string $user_login The name of the user account involved in the operation.
     * @return void
     */
    function sucuriscan_set_lastlogin($user_login=''){
        $datastore_filepath = sucuriscan_lastlogins_datastore_is_writable();

        if($datastore_filepath){
            $current_user = get_user_by('login', $user_login);
            $remote_addr = SucuriScan::get_remote_addr();

            $login_info = array(
                'user_id' => $current_user->ID,
                'user_login' => $current_user->user_login,
                'user_remoteaddr' => $remote_addr,
                'user_hostname' => @gethostbyaddr($remote_addr),
                'user_lastlogin' => current_time('mysql')
            );

            @file_put_contents($datastore_filepath, json_encode($login_info)."\n", FILE_APPEND);
        }
    }
    add_action('wp_login', 'sucuriscan_set_lastlogin', 50);
}

/**
 * Retrieve the list of all the user logins from the datastore file.
 *
 * The results of this operation can be filtered by specific user identifiers,
 * or limiting the quantity of entries.
 *
 * @param  integer $limit   How many entries will be returned from the operation.
 * @param  integer $offset  Initial point where the logs will be start counting.
 * @param  integer $user_id Optional user identifier to filter the results.
 * @return array            The list of all the user logins, and total of entries registered.
 */
function sucuriscan_get_logins( $limit=10, $offset=0, $user_id=0 ){
    $datastore_filepath = sucuriscan_lastlogins_datastore_is_readable();
    $last_logins = array(
        'total' => 0,
        'entries' => array(),
    );

    if( $datastore_filepath ){
        $parsed_lines = 0;
        $data_lines = SucuriScanFileInfo::file_lines($datastore_filepath);

        if( $data_lines ){
            /**
             * This count will not be 100% accurate considering that we are checking the
             * syntax of each line in the loop bellow, there may be some lines without the
             * right syntax which will differ from the total entries returned, but there's
             * not other EASY way to do this without affect the performance of the code.
             *
             * @var integer
             */
            $total_lines = count($data_lines);
            $last_logins['total'] = $total_lines;

            // Get a list with the latest entries in the first positions.
            $reversed_lines = array_reverse($data_lines);

            /**
             * Only the user accounts with administrative privileges can see the logs of all
             * the users, for the rest of the accounts they will only see their own logins.
             *
             * @var object
             */
            $current_user = wp_get_current_user();
            $is_admin_user = (bool) current_user_can('manage_options');

            for( $i=$offset; $i<$total_lines; $i++ ){
                $line = $reversed_lines[$i] ? trim($reversed_lines[$i]) : '';

                // Check if the data is serialized (which we will consider as insecure).
                if( SucuriScan::is_serialized($line) ){
                    $last_login = @unserialize($line); // TODO: Remove after version 1.7.5
                } else {
                    $last_login = @json_decode($line, TRUE);
                }

                if( $last_login ){
                    $last_login['user_lastlogin_timestamp'] = strtotime($last_login['user_lastlogin']);
                    $last_login['user_registered_timestamp'] = 0;

                    // Only administrators can see all login stats.
                    if( !$is_admin_user && $current_user->user_login != $last_login['user_login'] ){
                        continue;
                    }

                    // Filter the user identifiers using the value passed tot his function.
                    if( $user_id > 0 && $last_login['user_id'] != $user_id ){
                        continue;
                    }

                    // Get the WP_User object and add extra information from the last-login data.
                    $last_login['user_exists'] = FALSE;
                    $user_account = get_userdata($last_login['user_id']);

                    if( $user_account ){
                        $last_login['user_exists'] = TRUE;

                        foreach( $user_account->data as $var_name=>$var_value ){
                            $last_login[$var_name] = $var_value;

                            if( $var_name == 'user_registered' ){
                                $last_login['user_registered_timestamp'] = strtotime($var_value);
                            }
                        }
                    }

                    $last_login['line_num'] = $i + 1;
                    $last_logins['entries'][] = (object) $last_login;
                    $parsed_lines += 1;
                }

                else {
                    $last_logins['total'] -= 1;
                }

                if( preg_match('/^[0-9]+$/', $limit) && $limit>0 ){
                    if( $parsed_lines >= $limit ){ break; }
                }
            }
        }
    }

    return $last_logins;
}

if( !function_exists('sucuri_login_redirect') ){
    /**
     * Hook for the wp-login action to redirect the user to a specific URL after
     * his successfully login to the administrator interface.
     *
     * @param  string  $redirect_to URL where the browser must be originally redirected to, set by WordPress itself.
     * @param  object  $request     Optional parameter set by WordPress itself through the event triggered.
     * @param  boolean $user        WordPress user object with the information of the account involved in the operation.
     * @return string               URL where the browser must be redirected to.
     */
    function sucuriscan_login_redirect( $redirect_to='', $request=NULL, $user=FALSE ){
        $login_url = !empty($redirect_to) ? $redirect_to : admin_url();

        if( $user instanceof WP_User && $user->ID ){
            $login_url = add_query_arg( 'sucuriscan_lastlogin', 1, $login_url );
        }

        return $login_url;
    }

    if( SucuriScanOption::get_option(':lastlogin_redirection') == 'enabled' ){
        add_filter('login_redirect', 'sucuriscan_login_redirect', 10, 3);
    }
}

if( !function_exists('sucuri_get_user_lastlogin') ){
    /**
     * Display the last user login at the top of the admin interface.
     *
     * @return void
     */
    function sucuriscan_get_user_lastlogin(){
        if(
            current_user_can('manage_options')
            && SucuriScanRequest::get(':lastlogin', '1')
        ){
            $current_user = wp_get_current_user();

            // Select the penultimate entry, not the last one.
            $last_logins = sucuriscan_get_logins(2, 0, $current_user->ID);

            if( isset($last_logins['entries'][1]) ){
                $row = $last_logins['entries'][1];

                $lastlogin_message = sprintf(
                    'Last time you logged in was at <code>%s</code> from <code>%s</code> - <code>%s</code>',
                    SucuriScan::datetime($row->user_lastlogin_timestamp),
                    $row->user_remoteaddr,
                    $row->user_hostname
                );
                $lastlogin_message .= chr(32).'(<a href="'.SucuriScanTemplate::get_url('lastlogins').'">view all logs</a>)';
                SucuriScanInterface::info( $lastlogin_message );
            }
        }
    }

    add_action('admin_notices', 'sucuriscan_get_user_lastlogin');
}

/**
 * Print a list of all the registered users that are currently in session.
 *
 * @return string The HTML code displaying a list of all the users logged in at the moment.
 */
function sucuriscan_loggedin_users_panel(){
    // Get user logged in list.
    $template_variables = array(
        'LoggedInUsers.List' => '',
        'LoggedInUsers.Total' => 0,
    );

    $logged_in_users = sucuriscan_get_online_users(TRUE);

    if( is_array($logged_in_users) && !empty($logged_in_users) ){
        $template_variables['LoggedInUsers.Total'] = count($logged_in_users);
        $counter = 0;

        foreach( (array) $logged_in_users as $logged_in_user ){
            $counter += 1;
            $logged_in_user['last_activity_datetime'] = SucuriScan::datetime($logged_in_user['last_activity']);
            $logged_in_user['user_registered_datetime'] = SucuriScan::datetime( strtotime($logged_in_user['user_registered']) );

            $template_variables['LoggedInUsers.List'] .= SucuriScanTemplate::get_snippet('lastlogins-loggedin', array(
                'LoggedInUsers.Id' => SucuriScan::escape($logged_in_user['user_id']),
                'LoggedInUsers.UserURL' => admin_url('user-edit.php?user_id='.$logged_in_user['user_id']),
                'LoggedInUsers.UserLogin' => SucuriScan::escape($logged_in_user['user_login']),
                'LoggedInUsers.UserEmail' => SucuriScan::escape($logged_in_user['user_email']),
                'LoggedInUsers.LastActivity' => SucuriScan::escape($logged_in_user['last_activity_datetime']),
                'LoggedInUsers.Registered' => SucuriScan::escape($logged_in_user['user_registered_datetime']),
                'LoggedInUsers.RemoveAddr' => SucuriScan::escape($logged_in_user['remote_addr']),
                'LoggedInUsers.CssClass' => ( $counter % 2 == 0 ) ? '' : 'alternate'
            ));
        }
    }

    return SucuriScanTemplate::get_section('lastlogins-loggedin', $template_variables);
}

/**
 * Get a list of all the registered users that are currently in session.
 *
 * @param  boolean $add_current_user Whether the current user should be added to the list or not.
 * @return array                     List of registered users currently in session.
 */
function sucuriscan_get_online_users( $add_current_user=FALSE ){
    $users = array();

    if( SucuriScan::is_multisite() ){
        $users = get_site_transient('online_users');
    } else {
        $users = get_transient('online_users');
    }

    // If not online users but current user is logged in, add it to the list.
    if( empty($users) && $add_current_user ){
        $current_user = wp_get_current_user();

        if( $current_user->ID > 0 ){
            sucuriscan_set_online_user( $current_user->user_login, $current_user );

            return sucuriscan_get_online_users();
        }
    }

    return $users;
}

/**
 * Update the list of the registered users currently in session.
 *
 * Useful when you are removing users and need the list of the remaining users.
 *
 * @param  array   $logged_in_users List of registered users currently in session.
 * @return boolean                  Either TRUE or FALSE representing the success or fail of the operation.
 */
function sucuriscan_save_online_users( $logged_in_users=array() ){
    $expiration = 30 * 60;

    if( SucuriScan::is_multisite() ){
        return set_site_transient('online_users', $logged_in_users, $expiration);
    } else {
        return set_transient('online_users', $logged_in_users, $expiration);
    }
}

if( !function_exists('sucuriscan_unset_online_user_on_logout') ){
    /**
     * Remove a logged in user from the list of registered users in session when
     * the logout page is requested.
     *
     * @return void
     */
    function sucuriscan_unset_online_user_on_logout(){
        $remote_addr = SucuriScan::get_remote_addr();
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        sucuriscan_unset_online_user($user_id, $remote_addr);
    }

    add_action('wp_logout', 'sucuriscan_unset_online_user_on_logout');
}

/**
 * Remove a logged in user from the list of registered users in session using
 * the user identifier and the ip address of the last computer used to login.
 *
 * @param  integer $user_id     User identifier of the account that will be logged out.
 * @param  integer $remote_addr IP address of the computer where the user logged in.
 * @return boolean              Either TRUE or FALSE representing the success or fail of the operation.
 */
function sucuriscan_unset_online_user( $user_id=0, $remote_addr=0 ){
    $logged_in_users = sucuriscan_get_online_users();

    // Remove the specified user identifier from the list.
    if( is_array($logged_in_users) && !empty($logged_in_users) ){
        foreach( $logged_in_users as $i => $user ){
            if(
                $user['user_id']==$user_id
                && strcmp($user['remote_addr'], $remote_addr) == 0
            ){
                unset($logged_in_users[$i]);
                break;
            }
        }
    }

    return sucuriscan_save_online_users($logged_in_users);
}

if( !function_exists('sucuriscan_set_online_user') ){
    /**
     * Add an user account to the list of registered users in session.
     *
     * @param  string  $user_login The name of the user account that just logged in the site.
     * @param  boolean $user       The WordPress object containing all the information associated to the user.
     * @return void
     */
    function sucuriscan_set_online_user( $user_login='', $user=FALSE ){
        if( $user ){
            // Get logged in user information.
            $current_user = ($user instanceof WP_User) ? $user : wp_get_current_user();
            $current_user_id = $current_user->ID;
            $remote_addr = SucuriScan::get_remote_addr();
            $current_time = current_time('timestamp');
            $logged_in_users = sucuriscan_get_online_users();

            // Build the dataset array that will be stored in the transient variable.
            $current_user_info = array(
                'user_id' => $current_user_id,
                'user_login' => $current_user->user_login,
                'user_email' => $current_user->user_email,
                'user_registered' => $current_user->user_registered,
                'last_activity' => $current_time,
                'remote_addr' => $remote_addr,
            );

            if( !is_array($logged_in_users) || empty($logged_in_users) ){
                $logged_in_users = array( $current_user_info );
                sucuriscan_save_online_users($logged_in_users);
            } else {
                $do_nothing = FALSE;
                $update_existing = FALSE;
                $item_index = 0;

                // Check if the user is already in the logged-in-user list and update it if is necessary.
                foreach( $logged_in_users as $i => $user ){
                    if(
                        $user['user_id'] == $current_user_id
                        && strcmp($user['remote_addr'], $remote_addr) == 0
                    ){
                        if( $user['last_activity'] < ($current_time - (15 * 60)) ){
                            $update_existing = TRUE;
                            $item_index = $i;
                            break;
                        } else {
                            $do_nothing = TRUE;
                            break;
                        }
                    }
                }

                if( $update_existing ){
                    $logged_in_users[$item_index] = $current_user_info;
                    sucuriscan_save_online_users($logged_in_users);
                } elseif($do_nothing){
                    // Do nothing.
                } else {
                    $logged_in_users[] = $current_user_info;
                    sucuriscan_save_online_users($logged_in_users);
                }
            }
        }
    }

    add_action('wp_login', 'sucuriscan_set_online_user', 10, 2);
}

/**
 * Print a list with the failed logins occurred during the last hour.
 *
 * @return string A list with the failed logins occurred during the last hour.
 */
function sucuriscan_failed_logins_panel(){
    $template_variables = array(
        'FailedLogins.List' => '',
        'FailedLogins.Total' => '',
        'FailedLogins.MaxFailedLogins' => 0,
        'FailedLogins.NoItemsVisibility' => 'visible',
        'FailedLogins.WarningVisibility' => 'visible',
        'FailedLogins.CollectPasswordsVisibility' => 'visible',
    );

    $max_failed_logins = SucuriScanOption::get_option(':maximum_failed_logins');
    $notify_bruteforce_attack = SucuriScanOption::get_option(':notify_bruteforce_attack');
    $failed_logins = sucuriscan_get_failed_logins();
    $old_failed_logins = sucuriscan_get_failed_logins(true);

    // Merge the new and old failed logins.
    if (
        is_array($old_failed_logins)
        && !empty($old_failed_logins)
    ) {
        if (
            is_array($failed_logins)
            && !empty($failed_logins)
        ) {
            $failed_logins = array_merge( $failed_logins, $old_failed_logins );
        } else {
            $failed_logins = $old_failed_logins;
        }
    }

    if( $failed_logins ){
        $counter = 0;

        foreach( $failed_logins['entries'] as $login_data ){
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
            $wrong_user_password = '<span class="sucuriscan-label-default">hidden</span>';

            if ( sucuriscan_collect_wrong_passwords() === true ) {
                if (
                    isset($login_data['user_password'])
                    && !empty($login_data['user_password'])
                ) {
                    $wrong_user_password = SucuriScan::escape($login_data['user_password']);
                }

                else {
                    $wrong_user_password = '<span class="sucuriscan-label-info">empty</span>';
                }
            }

            $template_variables['FailedLogins.List'] .= SucuriScanTemplate::get_snippet('lastlogins-failedlogins', array(
                'FailedLogins.CssClass' => $css_class,
                'FailedLogins.Num' => ($counter + 1),
                'FailedLogins.Username' => SucuriScan::escape($login_data['user_login']),
                'FailedLogins.Password' => $wrong_user_password,
                'FailedLogins.RemoteAddr' => SucuriScan::escape($login_data['remote_addr']),
                'FailedLogins.Datetime' => SucuriScan::datetime($login_data['attempt_time']),
                'FailedLogins.UserAgent' => SucuriScan::escape($login_data['user_agent']),
            ));

            $counter += 1;
        }

        if( $counter > 0 ){
            $template_variables['FailedLogins.NoItemsVisibility'] = 'hidden';
        }
    }

    $template_variables['FailedLogins.MaxFailedLogins'] = $max_failed_logins;

    if( $notify_bruteforce_attack == 'enabled' ){
        $template_variables['FailedLogins.WarningVisibility'] = 'hidden';
    }

    if( sucuriscan_collect_wrong_passwords() !== true ){
        $template_variables['FailedLogins.CollectPasswordsVisibility'] = 'hidden';
    }

    return SucuriScanTemplate::get_section('lastlogins-failedlogins', $template_variables);
}

/**
 * Whether or not to collect the password of failed logins.
 *
 * @return boolean TRUE if the password must be collected, FALSE otherwise.
 */
function sucuriscan_collect_wrong_passwords(){
    return (bool) ( SucuriScanOption::get_option(':collect_wrong_passwords') === 'enabled' );
}

/**
 * Find the full path of the file where the information of the failed logins
 * will be stored, it will be created automatically if does not exists (and if
 * the destination folder has permissions to write). This function can also be
 * used to reset the content of the datastore file.
 *
 * @see sucuriscan_reset_failed_logins()
 *
 * @param  boolean $get_old_logs Whether the old logs will be retrieved or not.
 * @param  boolean $reset        Whether the file will be resetted or not.
 * @return string                The full (relative) path where the file is located.
 */
function sucuriscan_failed_logins_datastore_path( $get_old_logs=false, $reset=false ){
    $file_name = $get_old_logs ? 'sucuri-oldfailedlogins.php' : 'sucuri-failedlogins.php';
    $datastore_path = SucuriScan::datastore_folder_path($file_name);
    $default_content = sucuriscan_failed_logins_default_content();

    // Create the file if it does not exists.
    if( !file_exists($datastore_path) || $reset ){
        @file_put_contents( $datastore_path, $default_content, LOCK_EX );
    }

    // Return the datastore path if the file exists (or was created).
    if(
        file_exists($datastore_path)
        && is_readable($datastore_path)
    ){
        return $datastore_path;
    }

    return FALSE;
}

/**
 * Default content of the datastore file where the failed logins are being kept.
 *
 * @return string Default content of the file.
 */
function sucuriscan_failed_logins_default_content(){
    $default_content = "<?php exit(0); ?>\n";

    return $default_content;
}

/**
 * Read and parse the content of the datastore file where the failed logins are
 * being kept. This function will also calculate the difference in time between
 * the first and last login attempt registered in the file to later decide if
 * there is a brute-force attack in progress (and send an email notification
 * with the report) or reset the file after considering it a normal behavior of
 * the site.
 *
 * @param  boolean $get_old_logs Whether the old logs will be retrieved or not.
 * @return array                 Information and entries gathered from the failed logins datastore file.
 */
function sucuriscan_get_failed_logins( $get_old_logs=false ){
    $datastore_path = sucuriscan_failed_logins_datastore_path($get_old_logs);
    $default_content = sucuriscan_failed_logins_default_content();
    $default_content_n = substr_count($default_content, "\n");

    if( $datastore_path ){
        $lines = SucuriScanFileInfo::file_lines($datastore_path);

        if( $lines ){
            $failed_logins = array(
                'count' => 0,
                'first_attempt' => 0,
                'last_attempt' => 0,
                'diff_time' => 0,
                'entries' => array(),
            );

            // Read and parse all the entries found in the datastore file.
            foreach( $lines as $i => $line ){
                if( $i >= $default_content_n ){
                    $login_data = @json_decode( trim($line), TRUE );
                    $login_data['attempt_date'] = date('r', $login_data['attempt_time']);

                    if( !$login_data['user_agent'] ){
                        $login_data['user_agent'] = 'Unknown';
                    }

                    if ( !isset($login_data['user_password'])) {
                        $login_data['user_password'] = '';
                    }

                    $failed_logins['entries'][] = $login_data;
                    $failed_logins['count'] += 1;
                }
            }

            // Calculate the different time between the first and last attempt.
            if( $failed_logins['count'] > 0 ){
                $z = abs($failed_logins['count'] - 1);
                $failed_logins['last_attempt'] = $failed_logins['entries'][$z]['attempt_time'];
                $failed_logins['first_attempt'] = $failed_logins['entries'][0]['attempt_time'];
                $failed_logins['diff_time'] = abs( $failed_logins['last_attempt'] - $failed_logins['first_attempt'] );

                return $failed_logins;
            }
        }
    }

    return FALSE;
}


/**
 * Add a new entry in the datastore file where the failed logins are being kept,
 * this entry will contain the username, timestamp of the login attempt, remote
 * address of the computer sending the request, and the user-agent.
 *
 * @param  string  $user_login     Information from the current failed login event.
 * @param  string  $wrong_password Wrong password used during the supposed attack.
 * @return boolean                 Whether the information of the current failed login event was stored or not.
 */
function sucuriscan_log_failed_login( $user_login='', $wrong_password='' ){
    $datastore_path = sucuriscan_failed_logins_datastore_path();

    // Do not collect wrong passwords if it is not necessary.
    if ( sucuriscan_collect_wrong_passwords() !== true ) {
        $wrong_password = '';
    }

    if( $datastore_path ){
        $login_data = json_encode(array(
            'user_login' => $user_login,
            'user_password' => $wrong_password,
            'attempt_time' => time(),
            'remote_addr' => SucuriScan::get_remote_addr(),
            'user_agent' => SucuriScan::get_user_agent(),
        ));

        $logged = @file_put_contents( $datastore_path, $login_data . "\n", FILE_APPEND );

        return $logged;
    }

    return FALSE;
}

/**
 * Read and parse all the entries in the datastore file where the failed logins
 * are being kept, this will loop through all these items and generate a table
 * in HTML code to send as a report via email according to the plugin settings
 * for the email notifications.
 *
 * @param  array   $failed_logins Information and entries gathered from the failed logins datastore file.
 * @return boolean                Whether the report was sent via email or not.
 */
function sucuriscan_report_failed_logins( $failed_logins=array() ){
    if( $failed_logins && $failed_logins['count'] > 0 ){
        $prettify_mails = SucuriScanMail::prettify_mails();
        $collect_wrong_passwords = sucuriscan_collect_wrong_passwords();
        $mail_content = '';

        if( $prettify_mails ){
            $table_html  = '<table border="1" cellspacing="0" cellpadding="0">';

            // Add the table headers.
            $table_html .= '<thead>';
            $table_html .= '<tr>';
            $table_html .= '<th>Username</th>';

            if ( $collect_wrong_passwords === true ) {
                $table_html .= '<th>Password</th>';
            }

            $table_html .= '<th>IP Address</th>';
            $table_html .= '<th>Attempt Timestamp</th>';
            $table_html .= '<th>Attempt Date/Time</th>';
            $table_html .= '</tr>';
            $table_html .= '</thead>';

            $table_html .= '<tbody>';
        }

        foreach( $failed_logins['entries'] as $login_data ){
            if( $prettify_mails ){
                $table_html .= '<tr>';
                $table_html .= '<td>' . esc_attr($login_data['user_login']) . '</td>';

                if ( $collect_wrong_passwords === true ) {
                    $table_html .= '<td>' . esc_attr($login_data['user_password']) . '</td>';
                }

                $table_html .= '<td>' . esc_attr($login_data['remote_addr']) . '</td>';
                $table_html .= '<td>' . $login_data['attempt_time'] . '</td>';
                $table_html .= '<td>' . $login_data['attempt_date'] . '</td>';
                $table_html .= '</tr>';
            } else {
                $mail_content .= "\n";
                $mail_content .= 'Username: ' . $login_data['user_login'] . "\n";

                if ( $collect_wrong_passwords === true ) {
                    $mail_content .= 'Password: ' . $login_data['user_password'] . "\n";
                }

                $mail_content .= 'IP Address: ' . $login_data['remote_addr'] . "\n";
                $mail_content .= 'Attempt Timestamp: ' . $login_data['attempt_time'] . "\n";
                $mail_content .= 'Attempt Date/Time: ' . $login_data['attempt_date'] . "\n";
            }
        }

        if( $prettify_mails ){
            $table_html .= '</tbody>';
            $table_html .= '</table>';
            $mail_content = $table_html;
        }

        if( SucuriScanEvent::notify_event( 'bruteforce_attack', $mail_content ) ){
            sucuriscan_reset_failed_logins();

            return TRUE;
        }
    }

    return FALSE;
}

/**
 * Remove all the entries in the datastore file where the failed logins are
 * being kept. The execution of this function will not delete the file (which is
 * likely the best move) but rather will clean its content and append the
 * default code defined by another function above.
 *
 * @return boolean Whether the datastore file was resetted or not.
 */
function sucuriscan_reset_failed_logins(){
    $datastore_path = SucuriScan::datastore_folder_path('sucuri-failedlogins.php');
    $datastore_backup_path = sucuriscan_failed_logins_datastore_path(true, false);
    $default_content = sucuriscan_failed_logins_default_content();
    $current_content = @file_get_contents($datastore_path);
    $current_content = str_replace( $default_content, '', $current_content );

    @file_put_contents(
        $datastore_backup_path,
        $current_content,
        FILE_APPEND
    );

    return (bool) sucuriscan_failed_logins_datastore_path(false, true);
}

/**
 * Print a HTML code with the settings of the plugin.
 *
 * @return void
 */
function sucuriscan_settings_page(){
    SucuriScanInterface::check_permissions();

    $template_variables = array(
        'PageTitle' => 'Settings',
        'Settings.General' => sucuriscan_settings_general(),
        'Settings.Scanner' => sucuriscan_settings_scanner(),
        'Settings.IgnoreScanning' => sucuriscan_settings_ignorescanning(),
        'Settings.Notifications' => sucuriscan_settings_notifications(),
        'Settings.IgnoreRules' => sucuriscan_settings_ignore_rules(),
        'Settings.TrustIP' => sucuriscan_settings_trust_ip(),
        'Settings.Heartbeat' => sucuriscan_settings_heartbeat(),
    );

    echo SucuriScanTemplate::get_template('settings', $template_variables);
}

/**
 * Process the requests sent by the form submissions originated in the settings
 * page, all forms must have a nonce field that will be checked against the one
 * generated in the template render function.
 *
 * @param  boolean $page_nonce True if the nonce is valid, False otherwise.
 * @return void
 */
function sucuriscan_settings_form_submissions( $page_nonce=NULL ){
    global $sucuriscan_schedule_allowed,
        $sucuriscan_interface_allowed,
        $sucuriscan_notify_options,
        $sucuriscan_emails_per_hour,
        $sucuriscan_maximum_failed_logins,
        $sucuriscan_email_subjects,
        $sucuriscan_verify_ssl_cert;

    // Use this conditional to avoid double checking.
    if( is_null($page_nonce) ){
        $page_nonce = SucuriScanInterface::check_nonce();
    }

    if( $page_nonce ){

        // Recover API key through the email registered previously.
        if( SucuriScanRequest::post(':recover_key') !== FALSE ){
            SucuriScanAPI::recover_key();
        }

        // Save API key after it was recovered by the administrator.
        if( $api_key = SucuriScanRequest::post(':manual_api_key') ){
            SucuriScanAPI::set_plugin_key( $api_key, TRUE );
            SucuriScanEvent::schedule_task();
        }

        // Remove API key from the local storage.
        if( SucuriScanRequest::post(':remove_api_key') !== FALSE ){
            SucuriScanAPI::set_plugin_key('');
            wp_clear_scheduled_hook('sucuriscan_scheduled_scan');
            SucuriScanEvent::notify_event( 'plugin_change', 'Sucuri API key removed' );
        }

        // Enable or disable the filesystem scanner.
        if( $fs_scanner = SucuriScanRequest::post(':fs_scanner', '(en|dis)able') ){
            $action_d = $fs_scanner . 'd';
            SucuriScanOption::update_option(':fs_scanner', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanner was: ' . $action_d );
            SucuriScanInterface::info( 'Filesystem scanner was <code>' . $action_d . '</code>' );
        }

        // Enable or disable the filesystem scanner for modified files.
        if( $scan_modfiles = SucuriScanRequest::post(':scan_modfiles', '(en|dis)able') ){
            $action_d = $scan_modfiles . 'd';
            SucuriScanOption::update_option(':scan_modfiles', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanner for modified files was: ' . $action_d );
            SucuriScanInterface::info( 'Filesystem scanner for modified files was <code>' . $action_d . '</code>' );
        }

        // Enable or disable the filesystem scanner for file integrity.
        if( $scan_checksums = SucuriScanRequest::post(':scan_checksums', '(en|dis)able') ){
            $action_d = $scan_checksums . 'd';
            SucuriScanOption::update_option(':scan_checksums', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanner for file integrity was: ' . $action_d );
            SucuriScanInterface::info( 'Filesystem scanner for file integrity was <code>' . $action_d . '</code>' );
        }

        // Enable or disable the filesystem scanner for error logs.
        if( $ignore_scanning = SucuriScanRequest::post(':ignore_scanning', '(en|dis)able') ){
            $action_d = $ignore_scanning . 'd';
            SucuriScanOption::update_option(':ignore_scanning', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanner rules to ignore directories was: ' . $action_d );
            SucuriScanInterface::info( 'Filesystem scanner rules to ignore directories was <code>' . $action_d . '</code>' );
        }

        // Enable or disable the filesystem scanner for error logs.
        if( $scan_errorlogs = SucuriScanRequest::post(':scan_errorlogs', '(en|dis)able') ){
            $action_d = $scan_errorlogs . 'd';
            SucuriScanOption::update_option(':scan_errorlogs', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanner for error logs was: ' . $action_d );
            SucuriScanInterface::info( 'Filesystem scanner for error logs was <code>' . $action_d . '</code>' );
        }

        // Enable or disable the error logs parsing.
        if( $parse_errorlogs = SucuriScanRequest::post(':parse_errorlogs', '(en|dis)able') ){
            $action_d = $parse_errorlogs . 'd';
            SucuriScanOption::update_option(':parse_errorlogs', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'Analysis of error logs was: ' . $action_d );
            SucuriScanInterface::info( 'Analysis of error logs was <code>' . $action_d . '</code>' );
        }

        // Update the limit of error log lines to parse.
        if( $errorlogs_limit = SucuriScanRequest::post(':errorlogs_limit', '[0-9]+') ){
            if ( $errorlogs_limit > 1000 ) {
                SucuriScanInterface::error( 'Analyze more than 1,000 lines will take too much time.' );
            } else {
                SucuriScanOption::update_option(':errorlogs_limit', $errorlogs_limit);
                SucuriScanInterface::info( 'Analyze last <code>' . $errorlogs_limit . '</code> entries encountered in the error logs.' );

                if ( $errorlogs_limit == 0 ) {
                    SucuriScanOption::update_option(':parse_errorlogs', 'disabled');
                }
            }
        }

        // Enable or disable the SiteCheck scanner and the malware scan page.
        if( $sitecheck_scanner = SucuriScanRequest::post(':sitecheck_scanner', '(en|dis)able') ){
            $action_d = $sitecheck_scanner . 'd';
            SucuriScanOption::update_option(':sitecheck_scanner', $action_d);
            SucuriScanEvent::notify_event( 'plugin_change', 'SiteCheck scanner and malware scan page were: ' . $action_d );
            SucuriScanInterface::info( 'SiteCheck scanner and malware scan page were <code>' . $action_d . '</code>' );
        }

        // Modify the schedule of the filesystem scanner.
        if( $frequency = SucuriScanRequest::post(':scan_frequency') ){
            if( array_key_exists($frequency, $sucuriscan_schedule_allowed) ){
                SucuriScanOption::update_option(':scan_frequency', $frequency);
                wp_clear_scheduled_hook('sucuriscan_scheduled_scan');

                if( $frequency != '_oneoff' ){
                    wp_schedule_event( time()+10, $frequency, 'sucuriscan_scheduled_scan' );
                }

                $frequency_title = $sucuriscan_schedule_allowed[$frequency];
                SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanning frequency changed to: ' . $frequency_title );
                SucuriScanInterface::info( 'Filesystem scan scheduled to run <code>'.$frequency_title.'</code>' );
            }
        }

        // Set the method (aka. interface) that will be used to scan the site.
        if( $interface = SucuriScanRequest::post(':scan_interface') ){
            $allowed_values = array_keys($sucuriscan_interface_allowed);

            if( in_array($interface, $allowed_values) ){
                SucuriScanOption::update_option(':scan_interface', $interface);
                SucuriScanEvent::notify_event( 'plugin_change', 'Filesystem scanning interface changed to: ' . $interface );
                SucuriScanInterface::info( 'Filesystem scan interface set to <code>'.$interface.'</code>' );
            }
        }

        // Update the value for the maximum emails per hour.
        if( $per_hour = SucuriScanRequest::post(':emails_per_hour') ){
            if( array_key_exists($per_hour, $sucuriscan_emails_per_hour) ){
                $per_hour_label = $sucuriscan_emails_per_hour[$per_hour];
                SucuriScanOption::update_option( ':emails_per_hour', $per_hour );
                SucuriScanEvent::notify_event( 'plugin_change', 'Maximum email notifications per hour changed' );
                SucuriScanInterface::info( 'E-mail notifications: <code>' . $per_hour_label . '</code>' );
            } else {
                SucuriScanInterface::error( 'Invalid value for the maximum emails per hour.' );
            }
        }

        // Update the email where the event notifications will be sent.
        if( $new_email = SucuriScanRequest::post(':notify_to') ){
            $valid_email = SucuriScan::get_valid_email($new_email);

            if( $valid_email ){
                SucuriScanOption::update_option( ':notify_to', $valid_email );
                SucuriScanEvent::notify_event( 'plugin_change', 'Email address to get the event notifications was changed' );
                SucuriScanInterface::info( 'All the event notifications will be sent to the email specified.' );
            } else {
                SucuriScanInterface::error( 'Email format not supported.' );
            }
        }

        // Update the maximum failed logins per hour before consider it a brute-force attack.
        if( $failed_logins = SucuriScanRequest::post(':maximum_failed_logins') ){
            if( array_key_exists($failed_logins, $sucuriscan_maximum_failed_logins) ){
                SucuriScanOption::update_option( ':maximum_failed_logins', $failed_logins );
                $message = 'You will receive an email with a report containing information of the failed
                    logins occurred during the last hour if its quantity is bigger than the value you just
                    selected, which is <code>' . $failed_logins . '</code>. The information collected per
                    hour will be resetted if the quantity of failed logins is lower.';
                SucuriScanEvent::notify_event( 'plugin_change', $message );
                SucuriScanInterface::info($message);
            } else {
                SucuriScanInterface::error( 'Invalid value for the maximum failed logins per hour before consider it a brute-force attack.' );
            }
        }

        // Update the configuration for the SSL certificate verification.
        if( $verify_ssl_cert = SucuriScanRequest::post(':verify_ssl_cert') ){
            if( array_key_exists($verify_ssl_cert, $sucuriscan_verify_ssl_cert) ){
                SucuriScanOption::update_option( ':verify_ssl_cert', $verify_ssl_cert );
                $message = 'SSL certificates will not be verified when executing a HTTP request '
                    . 'while communicating with the Sucuri API service, nor the official '
                    . 'WordPress API.';
                SucuriScanEvent::notify_event( 'plugin_change', $message );
                SucuriScanInterface::info( $message );
            } else {
                SucuriScanInterface::error( 'Invalid value for the SSL certificate verification.' );
            }
        }

        // Update the API request timeout.
        if( $request_timeout = SucuriScanRequest::post(':request_timeout', '[0-9]+') ){
            SucuriScanOption::update_option(':request_timeout', $request_timeout);
            SucuriScanInterface::info( 'API request timeout set to <code>' . $request_timeout . '</code> seconds.' );
        }

        // Update the collection of failed passwords settings.
        if( $collect_wrong_passwords = SucuriScanRequest::post(':collect_wrong_passwords') ){
            $collect_wrong_passwords = strtolower($collect_wrong_passwords);
            $collect_action = 'disabled';

            if ( $collect_wrong_passwords == 'yes' ) {
                $collect_action = 'enabled';
            }

            SucuriScanOption::update_option(':collect_wrong_passwords', $collect_action);
            SucuriScanInterface::info( 'Option to collection wrong passwords updated to <code>' . $collect_action . '</code>' );
        }

        // Update the datastore path (if the new directory exists).
        if( $datastore_path = SucuriScanRequest::post(':datastore_path') ){
            $current_datastore_path = SucuriScanOption::datastore_folder_path();

            if ( file_exists($datastore_path) ) {
                if ( is_writable($datastore_path) ) {
                    SucuriScanOption::update_option(':datastore_path', $datastore_path);
                    SucuriScanInterface::info( 'Datastore path changed to <code>' . $datastore_path . '</code>' );

                    if ( file_exists($current_datastore_path) ) {
                        $new_datastore_path = SucuriScanOption::datastore_folder_path();
                        @rename( $current_datastore_path, $new_datastore_path );
                    }
                }

                else {
                    SucuriScanInterface::error( 'The new directory path is not writable.' );
                }
            }

            else {
                SucuriScanInterface::error( 'The directory path specified does not exists.' );
            }
        }

        // Update the notification settings.
        if( SucuriScanRequest::post(':save_notification_settings') !== FALSE ){
            $options_updated_counter = 0;

            foreach( $sucuriscan_notify_options as $alert_type => $alert_label ){
                $option_value = SucuriScanRequest::post($alert_type, '(1|0)');

                if( $option_value !== FALSE ){
                    $option_value = ( $option_value == '1' ) ? 'enabled' : 'disabled';
                    SucuriScanOption::update_option( $alert_type, $option_value );
                    $options_updated_counter += 1;
                }
            }

            if( $options_updated_counter > 0 ){
                SucuriScanEvent::notify_event( 'plugin_change', 'Email notification settings changed' );
                SucuriScanInterface::info( 'Notification settings updated.' );
            }
        }

        // Update the subject format for the email alerts.
        if ( $email_subject = SucuriScanRequest::post(':email_subject') ) {
            $new_email_subject = false;

            // Validate the custom subject format.
            if ( $email_subject == 'custom' ) {
                $format_pattern = '/^[0-9a-zA-Z:,\s]+$/';
                $custom_email_subject = SucuriScanRequest::post(':custom_email_subject');

                if (
                    $custom_email_subject !== false
                    && !empty($custom_email_subject)
                    && preg_match( $format_pattern, $custom_email_subject )
                ) {
                    $new_email_subject = trim($custom_email_subject);
                } else {
                    SucuriScanInterface::error( 'Invalid characters found in the email alert subject format.' );
                }
            }

            // Check if the email subject format is allowed.
            elseif (
                is_array($sucuriscan_email_subjects)
                && in_array( $email_subject, $sucuriscan_email_subjects )
            ) {
                $new_email_subject = $email_subject;
            }

            // Proceed with the operation saving the new subject.
            if ( $new_email_subject !== false ) {
                SucuriScanOption::update_option( ':email_subject', $new_email_subject );
                SucuriScanInterface::info( 'New email alert subject format saved successfully.' );
            }
        }

        // Reset all the plugin's options.
        if( SucuriScanRequest::post(':reset_options') !== FALSE ){
            // Notify the event before the API key is removed.
            $event_msg = 'All plugin\'s options were resetted.';
            SucuriScanEvent::report_event( 1, 'core', $event_msg );
            SucuriScanEvent::notify_event( 'plugin_change', $event_msg );

            // Remove all plugin's options from the database.
            $options = SucuriScanOption::get_options_from_db('all_plugin_options');

            foreach( $options as $option ){
                SucuriScanOption::delete_option( $option->option_name );
            }

            // Remove the scheduled tasks.
            wp_clear_scheduled_hook('sucuriscan_scheduled_scan');

            SucuriScanInterface::info( 'All plugin options were resetted successfully' );
        }

        // Ignore a new event for email notifications.
        if( $action = SucuriScanRequest::post(':ignorerule_action', '(add|remove)') ){
            $ignore_rule = SucuriScanRequest::post(':ignorerule');

            if( $action == 'add' ){
                if( SucuriScanOption::add_ignored_event($ignore_rule) ){
                    SucuriScanInterface::info( 'Post-type ignored successfully.' );
                } else {
                    SucuriScanInterface::error( 'The post-type is invalid or it may be already ignored.' );
                }
            }

            elseif( $action == 'remove' ) {
                SucuriScanOption::remove_ignored_event($ignore_rule);
                SucuriScanInterface::info( 'Post-type removed from the list successfully.' );
            }
        }

        // Ignore a new directory path for the file system scans.
        if( $action = SucuriScanRequest::post(':ignorescanning_action', '(ignore|unignore)') ){
            $ignore_directories = SucuriScanRequest::post(':ignorescanning_dirs', '_array');

            if( empty($ignore_directories) ){
                SucuriScanInterface::error( 'You did not choose a directory path from the list.' );
            }

            elseif( $action == 'ignore' ){
                foreach( $ignore_directories as $directory_path ){
                    SucuriScanFSScanner::ignore_directory($directory_path);
                }

                SucuriScanInterface::info( 'Directories selected from the list will be ignored in future scans.' );
            }

            elseif( $action == 'unignore' ) {
                foreach( $ignore_directories as $directory_path ){
                    SucuriScanFSScanner::unignore_directory($directory_path);
                }

                SucuriScanInterface::info( 'Directories selected from the list will not be ignored anymore.' );
            }
        }

        // Trust and IP address to ignore notifications for a subnet.
        if( $trust_ip = SucuriScanRequest::post(':trust_ip') ){
            if(
                SucuriScan::is_valid_ip($trust_ip)
                || SucuriScan::is_valid_cidr($trust_ip)
            ){
                $cache = new SucuriScanCache('trustip');
                $ip_info = SucuriScan::get_ip_info($trust_ip);
                $ip_info['added_at'] = SucuriScan::local_time();
                $cache_key = md5($ip_info['remote_addr']);

                if ( $cache->exists($cache_key) ) {
                    SucuriScanInterface::error( 'The IP address specified was already trusted.' );
                } elseif ( $cache->add( $cache_key, $ip_info ) ) {
                    SucuriScanInterface::info( 'The IP address specified was trusted successfully.' );
                } else {
                    SucuriScanInterface::error( 'The new entry was not saved in the datastore file.' );
                }
            }
        }

        // Trust and IP address to ignore notifications for a subnet.
        if( $del_trust_ip = SucuriScanRequest::post(':del_trust_ip', '_array') ){
            $cache = new SucuriScanCache('trustip');

            foreach ( $del_trust_ip as $cache_key ) {
                $cache->delete($cache_key);
            }

            SucuriScanInterface::info( 'The IP addresses selected were deleted successfully.' );
        }

        // Update the settings for the heartbeat API.
        if( $heartbeat_status = SucuriScanRequest::post(':heartbeat_status') ){
            $statuses_allowed = SucuriScanHeartbeat::statuses_allowed();

            if( array_key_exists($heartbeat_status, $statuses_allowed) ){
                SucuriScanOption::update_option(':heartbeat', $heartbeat_status);
                SucuriScanInterface::info( 'Heartbeat status set to <code>' . $heartbeat_status . '</code>' );
            } else {
                SucuriScanInterface::error( 'Heartbeat status not allowed.' );
            }
        }

        // Update the value of the heartbeat pulse.
        if( $heartbeat_pulse = SucuriScanRequest::post(':heartbeat_pulse') ){
            $pulses_allowed = SucuriScanHeartbeat::pulses_allowed();

            if( array_key_exists($heartbeat_pulse, $pulses_allowed) ){
                SucuriScanOption::update_option(':heartbeat_pulse', $heartbeat_pulse);
                SucuriScanInterface::info( 'Heartbeat pulse set to <code>' . $heartbeat_pulse . '</code> seconds.' );
            } else {
                SucuriScanInterface::error( 'Heartbeat pulse not allowed.' );
            }
        }

        // Update the value of the heartbeat interval.
        if( $heartbeat_interval = SucuriScanRequest::post(':heartbeat_interval') ){
            $intervals_allowed = SucuriScanHeartbeat::intervals_allowed();

            if( array_key_exists($heartbeat_interval, $intervals_allowed) ){
                SucuriScanOption::update_option(':heartbeat_interval', $heartbeat_interval);
                SucuriScanInterface::info( 'Heartbeat interval set to <code>' . $heartbeat_interval . '</code>' );
            } else {
                SucuriScanInterface::error( 'Heartbeat interval not allowed.' );
            }
        }

        // Enable or disable the auto-start execution of heartbeat.
        if( $heartbeat_autostart = SucuriScanRequest::post(':heartbeat_autostart', '(en|dis)able') ){
            $action_d = $heartbeat_autostart . 'd';
            SucuriScanOption::update_option(':heartbeat_autostart', $action_d);
            SucuriScanInterface::info( 'Heartbeat auto-start was <code>' . $action_d . '</code>' );
        }
    }
}

/**
 * Read and parse the content of the general settings template.
 *
 * @return string Parsed HTML code for the general settings panel.
 */
function sucuriscan_settings_general(){

    global $sucuriscan_emails_per_hour,
        $sucuriscan_maximum_failed_logins,
        $sucuriscan_verify_ssl_cert;

    // Check the nonce here to populate the value through other functions.
    $page_nonce = SucuriScanInterface::check_nonce();

    // Process all form submissions.
    sucuriscan_settings_form_submissions($page_nonce);

    // Register the site, get its API key, and store it locally for future usage.
    $api_registered_modal = '';

    // Whether the form to manually add the API key should be shown or not.
    $display_manual_key_form = (bool) ( SucuriScanRequest::post(':recover_key') !== FALSE );

    if( $page_nonce && SucuriScanRequest::post(':plugin_api_key') !== FALSE ){
        $registered = SucuriScanAPI::register_site();

        if( $registered ){
            $api_registered_modal = SucuriScanTemplate::get_modal('settings-apiregistered', array(
                'Title' => 'Site registered successfully',
                'CssClass' => 'sucuriscan-apikey-registered',
            ));
        } else {
            $display_manual_key_form = TRUE;
        }
    }

    // Get initial variables to decide some things bellow.
    $api_key = SucuriScanAPI::get_plugin_key();
    $emails_per_hour = SucuriScanOption::get_option(':emails_per_hour');
    $maximum_failed_logins = SucuriScanOption::get_option(':maximum_failed_logins');
    $verify_ssl_cert = SucuriScanOption::get_option(':verify_ssl_cert');
    $invalid_domain = false;

    // Check whether the domain name is valid or not.
    if( !$api_key ){
        $clean_domain = SucuriScan::get_domain();
        $domain_address = @gethostbyname($clean_domain);
        $invalid_domain = ( $domain_address == $clean_domain ) ? TRUE : FALSE;
    }

    // Generate the HTML code for the option list in the form select fields.
    $emails_per_hour_options = SucuriScanTemplate::get_select_options( $sucuriscan_emails_per_hour, $emails_per_hour );
    $maximum_failed_logins_options = SucuriScanTemplate::get_select_options( $sucuriscan_maximum_failed_logins, $maximum_failed_logins );
    $verify_ssl_cert_options = SucuriScanTemplate::get_select_options( $sucuriscan_verify_ssl_cert, $verify_ssl_cert );

    $template_variables = array(
        'APIKey' => ( !$api_key ? '<em>(not set)</em>' : $api_key ),
        'APIKey.RecoverVisibility' => SucuriScanTemplate::visibility( !$api_key && !$display_manual_key_form ),
        'APIKey.ManualKeyFormVisibility' => SucuriScanTemplate::visibility($display_manual_key_form),
        'APIKey.RemoveVisibility' => SucuriScanTemplate::visibility($api_key),
        'InvalidDomainVisibility' => SucuriScanTemplate::visibility($invalid_domain),
        'NotifyTo' => SucuriScanOption::get_option(':notify_to'),
        'EmailsPerHour' => 'Undefined',
        'EmailsPerHourOptions' => $emails_per_hour_options,
        'MaximumFailedLogins' => 'Undefined',
        'MaximumFailedLoginsOptions' => $maximum_failed_logins_options,
        'VerifySSLCert' => 'Undefined',
        'VerifySSLCertOptions' => $verify_ssl_cert_options,
        'RequestTimeout' => SucuriScanOption::get_option(':request_timeout') . ' seconds',
        'DatastorePath' => SucuriScanOption::get_option(':datastore_path'),
        'CollectWrongPasswords' => 'No collect passwords',
        'ModalWhenAPIRegistered' => $api_registered_modal,
    );

    if( array_key_exists($emails_per_hour, $sucuriscan_emails_per_hour) ){
        $template_variables['EmailsPerHour'] = $sucuriscan_emails_per_hour[$emails_per_hour];
    }

    if( array_key_exists($maximum_failed_logins, $sucuriscan_maximum_failed_logins) ){
        $template_variables['MaximumFailedLogins'] = $sucuriscan_maximum_failed_logins[$maximum_failed_logins];
    }

    if( array_key_exists($verify_ssl_cert, $sucuriscan_verify_ssl_cert) ){
        $template_variables['VerifySSLCert'] = $sucuriscan_verify_ssl_cert[$verify_ssl_cert];
    }

    if ( sucuriscan_collect_wrong_passwords() === true ) {
        $template_variables['CollectWrongPasswords'] = '<span class="sucuriscan-label-error">Yes, collect passwords</span>';
    }

    return SucuriScanTemplate::get_section('settings-general', $template_variables);
}

/**
 * Read and parse the content of the scanner settings template.
 *
 * @return string Parsed HTML code for the scanner settings panel.
 */
function sucuriscan_settings_scanner(){

    global $sucuriscan_schedule_allowed,
        $sucuriscan_interface_allowed;

    // Get initial variables to decide some things bellow.
    $fs_scanner = SucuriScanOption::get_option(':fs_scanner');
    $scan_freq = SucuriScanOption::get_option(':scan_frequency');
    $scan_interface = SucuriScanOption::get_option(':scan_interface');
    $scan_modfiles = SucuriScanOption::get_option(':scan_modfiles');
    $scan_checksums = SucuriScanOption::get_option(':scan_checksums');
    $scan_errorlogs = SucuriScanOption::get_option(':scan_errorlogs');
    $parse_errorlogs = SucuriScanOption::get_option(':parse_errorlogs');
    $errorlogs_limit = SucuriScanOption::get_option(':errorlogs_limit');
    $ignore_scanning = SucuriScanOption::get_option(':ignore_scanning');
    $sitecheck_scanner = SucuriScanOption::get_option(':sitecheck_scanner');
    $sitecheck_counter = SucuriScanOption::get_option(':sitecheck_counter');
    $runtime_scan_human = SucuriScanFSScanner::get_filesystem_runtime(TRUE);

    // Generate the HTML code for the option list in the form select fields.
    $scan_freq_options = SucuriScanTemplate::get_select_options( $sucuriscan_schedule_allowed, $scan_freq );
    $scan_interface_options = SucuriScanTemplate::get_select_options( $sucuriscan_interface_allowed, $scan_interface );

    $template_variables = array(
        /* Filesystem scanner */
        'FsScannerStatus' => 'Enabled',
        'FsScannerSwitchText' => 'Disable',
        'FsScannerSwitchValue' => 'disable',
        'FsScannerSwitchCssClass' => 'button-danger',
        /* Scan modified files. */
        'ScanModfilesStatus' => 'Enabled',
        'ScanModfilesSwitchText' => 'Disable',
        'ScanModfilesSwitchValue' => 'disable',
        'ScanModfilesSwitchCssClass' => 'button-danger',
        /* Scan files checksum. */
        'ScanChecksumsStatus' => 'Enabled',
        'ScanChecksumsSwitchText' => 'Disable',
        'ScanChecksumsSwitchValue' => 'disable',
        'ScanChecksumsSwitchCssClass' => 'button-danger',
        /* Ignore scanning. */
        'IgnoreScanningStatus' => 'Enabled',
        'IgnoreScanningSwitchText' => 'Disable',
        'IgnoreScanningSwitchValue' => 'disable',
        'IgnoreScanningSwitchCssClass' => 'button-danger',
        /* Scan error logs. */
        'ScanErrorlogsStatus' => 'Enabled',
        'ScanErrorlogsSwitchText' => 'Disable',
        'ScanErrorlogsSwitchValue' => 'disable',
        'ScanErrorlogsSwitchCssClass' => 'button-danger',
        /* Parse error logs. */
        'ParseErrorLogsStatus' => 'Enabled',
        'ParseErrorLogsSwitchText' => 'Disable',
        'ParseErrorLogsSwitchValue' => 'disable',
        'ParseErrorLogsSwitchCssClass' => 'button-danger',
        /* SiteCheck scanner. */
        'SiteCheckScannerStatus' => 'Enabled',
        'SiteCheckScannerSwitchText' => 'Disable',
        'SiteCheckScannerSwitchValue' => 'disable',
        'SiteCheckScannerSwitchCssClass' => 'button-danger',
        /* Filsystem scanning frequency. */
        'ScanningFrequency' => 'Undefined',
        'ScanningFrequencyOptions' => $scan_freq_options,
        'ScanningInterface' => ( $scan_interface ? $sucuriscan_interface_allowed[$scan_interface] : 'Undefined' ),
        'ScanningInterfaceOptions' => $scan_interface_options,
        /* Filesystem scanning runtime. */
        'ScanningRuntimeHuman' => $runtime_scan_human,
        'SiteCheckCounter' => $sitecheck_counter,
        'ErrorLogsLimit' => $errorlogs_limit,
    );

    if( $fs_scanner == 'disabled' ){
        $template_variables['FsScannerStatus'] = 'Disabled';
        $template_variables['FsScannerSwitchText'] = 'Enable';
        $template_variables['FsScannerSwitchValue'] = 'enable';
        $template_variables['FsScannerSwitchCssClass'] = 'button-success';
    }

    if( $scan_modfiles == 'disabled' ){
        $template_variables['ScanModfilesStatus'] = 'Disabled';
        $template_variables['ScanModfilesSwitchText'] = 'Enable';
        $template_variables['ScanModfilesSwitchValue'] = 'enable';
        $template_variables['ScanModfilesSwitchCssClass'] = 'button-success';
    }

    if( $scan_checksums == 'disabled' ){
        $template_variables['ScanChecksumsStatus'] = 'Disabled';
        $template_variables['ScanChecksumsSwitchText'] = 'Enable';
        $template_variables['ScanChecksumsSwitchValue'] = 'enable';
        $template_variables['ScanChecksumsSwitchCssClass'] = 'button-success';
    }

    if( $ignore_scanning == 'disabled' ){
        $template_variables['IgnoreScanningStatus'] = 'Disabled';
        $template_variables['IgnoreScanningSwitchText'] = 'Enable';
        $template_variables['IgnoreScanningSwitchValue'] = 'enable';
        $template_variables['IgnoreScanningSwitchCssClass'] = 'button-success';
    }

    if( $scan_errorlogs == 'disabled' ){
        $template_variables['ScanErrorlogsStatus'] = 'Disabled';
        $template_variables['ScanErrorlogsSwitchText'] = 'Enable';
        $template_variables['ScanErrorlogsSwitchValue'] = 'enable';
        $template_variables['ScanErrorlogsSwitchCssClass'] = 'button-success';
    }

    if( $parse_errorlogs == 'disabled' ){
        $template_variables['ParseErrorLogsStatus'] = 'Disabled';
        $template_variables['ParseErrorLogsSwitchText'] = 'Enable';
        $template_variables['ParseErrorLogsSwitchValue'] = 'enable';
        $template_variables['ParseErrorLogsSwitchCssClass'] = 'button-success';
    }

    if( $sitecheck_scanner == 'disabled' ){
        $template_variables['SiteCheckScannerStatus'] = 'Disabled';
        $template_variables['SiteCheckScannerSwitchText'] = 'Enable';
        $template_variables['SiteCheckScannerSwitchValue'] = 'enable';
        $template_variables['SiteCheckScannerSwitchCssClass'] = 'button-success';
    }

    if( array_key_exists($scan_freq, $sucuriscan_schedule_allowed) ){
        $template_variables['ScanningFrequency'] = $sucuriscan_schedule_allowed[$scan_freq];
    }

    return SucuriScanTemplate::get_section('settings-scanner', $template_variables);
}

/**
 * Read and parse the content of the notification settings template.
 *
 * @return string Parsed HTML code for the notification settings panel.
 */
function sucuriscan_settings_notifications(){
    global $sucuriscan_notify_options,
        $sucuriscan_email_subjects;

    $template_variables = array(
        'NotificationOptions' => '',
        'EmailSubjectOptions' => '',
        'EmailSubjectCustom.Checked' => '',
        'EmailSubjectCustom.Value' => '',
        'PrettifyMailsWarningVisibility' => SucuriScanTemplate::visibility( SucuriScanMail::prettify_mails() ),
    );

    if ( $sucuriscan_email_subjects ) {
        $email_subject = SucuriScanOption::get_option(':email_subject');
        $is_official_subject = false;

        foreach ( $sucuriscan_email_subjects as $subject_format ) {
            if ( $email_subject == $subject_format ) {
                $is_official_subject = true;
                $checked = 'checked="checked"';
            } else {
                $checked = '';
            }

            $template_variables['EmailSubjectOptions'] .= SucuriScanTemplate::get_snippet('settings-emailsubject', array(
                'EmailSubject.Name' => $subject_format,
                'EmailSubject.Value' => $subject_format,
                'EmailSubject.Checked' => $checked,
            ));
        }

        if ( $is_official_subject === false ) {
            $template_variables['EmailSubjectCustom.Checked'] = 'checked="checked"';
            $template_variables['EmailSubjectCustom.Value'] = SucuriScan::escape($email_subject);
        }
    }

    $counter = 0;

    foreach( $sucuriscan_notify_options as $alert_type => $alert_label ){
        $alert_value = SucuriScanOption::get_option($alert_type);
        $checked = ( $alert_value == 'enabled' ? 'checked="checked"' : '' );
        $css_class = ( $counter % 2 == 0 ) ? 'alternate' : '';

        $template_variables['NotificationOptions'] .= SucuriScanTemplate::get_snippet('settings-notifications', array(
            'Notification.CssClass' => $css_class,
            'Notification.Name' => $alert_type,
            'Notification.Checked' => $checked,
            'Notification.Label' => $alert_label,
        ));
        $counter += 1;
    }

    return SucuriScanTemplate::get_section('settings-notifications', $template_variables);
}

/**
 * Read and parse the content of the ignored-rules settings template.
 *
 * @return string Parsed HTML code for the ignored-rules settings panel.
 */
function sucuriscan_settings_ignore_rules(){
    $notify_new_site_content = SucuriScanOption::get_option(':notify_post_publication');

    $template_variables = array(
        'IgnoreRules.MessageVisibility' => 'visible',
        'IgnoreRules.TableVisibility' => 'hidden',
        'IgnoreRules.PostTypes' => '',
    );

    if( $notify_new_site_content == 'enabled' ){
        $post_types = get_post_types();
        $ignored_events = SucuriScanOption::get_ignored_events();

        $template_variables['IgnoreRules.MessageVisibility'] = 'hidden';
        $template_variables['IgnoreRules.TableVisibility'] = 'visible';
        $counter = 0;

        foreach( $post_types as $post_type => $post_type_object ){
            $counter += 1;
            $css_class = ( $counter % 2 == 0 ) ? 'alternate' : '';
            $post_type_title = ucwords( str_replace('_', chr(32), $post_type) );

            if( array_key_exists($post_type, $ignored_events) ){
                $is_ignored_text = 'YES';
                $was_ignored_at = SucuriScan::datetime($ignored_events[$post_type]);
                $is_ignored_class = 'danger';
                $button_action = 'remove';
                $button_class = 'button-primary';
                $button_text = 'Allow';
            } else {
                $is_ignored_text = 'NO';
                $was_ignored_at = 'Not ignored';
                $is_ignored_class = 'success';
                $button_action = 'add';
                $button_class = 'button-primary button-danger';
                $button_text = 'Ignore';
            }

            $template_variables['IgnoreRules.PostTypes'] .= SucuriScanTemplate::get_snippet('settings-ignorerules', array(
                'IgnoreRules.CssClass' => $css_class,
                'IgnoreRules.Num' => $counter,
                'IgnoreRules.PostTypeTitle' => $post_type_title,
                'IgnoreRules.IsIgnored' => $is_ignored_text,
                'IgnoreRules.WasIgnoredAt' => $was_ignored_at,
                'IgnoreRules.IsIgnoredClass' => $is_ignored_class,
                'IgnoreRules.PostType' => $post_type,
                'IgnoreRules.Action' => $button_action,
                'IgnoreRules.ButtonClass' => 'button ' . $button_class,
                'IgnoreRules.ButtonText' => $button_text,
            ));
        }
    }

    return SucuriScanTemplate::get_section('settings-ignorerules', $template_variables);
}

/**
 * Read and parse the content of the trust-ip settings template.
 *
 * @return string Parsed HTML code for the trust-ip settings panel.
 */
function sucuriscan_settings_trust_ip(){
    $template_variables = array(
        'TrustedIPs.List' => '',
        'TrustedIPs.NoItems.Visibility' => 'visible',
    );

    $cache = new SucuriScanCache('trustip');
    $trusted_ips = $cache->get_all();

    if ( $trusted_ips ) {
        $counter = 0;

        foreach ( $trusted_ips as $cache_key => $ip_info ) {
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';

            if ( $ip_info->cidr_range == 32 ) {
                $ip_info->cidr_format = 'n/a';
            }

            $template_variables['TrustedIPs.List'] .= SucuriScanTemplate::get_snippet('settings-trustip', array(
                'TrustIP.CssClass' => $css_class,
                'TrustIP.CacheKey' => $cache_key,
                'TrustIP.RemoteAddr' => SucuriScan::escape($ip_info->remote_addr),
                'TrustIP.CIDRFormat' => SucuriScan::escape($ip_info->cidr_format),
                'TrustIP.AddedAt' => SucuriScan::datetime($ip_info->added_at),
            ));
            $counter += 1;
        }

        if ( $counter > 0 ) {
            $template_variables['TrustedIPs.NoItems.Visibility'] = 'hidden';
        }
    }

    return SucuriScanTemplate::get_section('settings-trustip', $template_variables);
}

/**
 * Read and parse the content of the ignore-scanning settings template.
 *
 * @return string Parsed HTML code for the ignore-scanning settings panel.
 */
function sucuriscan_settings_ignorescanning(){
    $template_variables = array(
        'IgnoreScanning.ResourceList' => '',
        'IgnoreScanning.DisabledVisibility' => 'visible',
        'IgnoreScanning.NoItemsVisibility' => 'visible',
    );

    $ignore_scanning = SucuriScanFSScanner::will_ignore_scanning();

    // Allow disable of this option temporarily.
    if( SucuriScanRequest::get('no_scan') == 1 ){
        $ignore_scanning = FALSE;
    }

    // Scan the project and get the ignored paths.
    if( $ignore_scanning === TRUE ){
        $counter = 0;
        $template_variables['IgnoreScanning.DisabledVisibility'] = 'hidden';
        $dir_list_list = SucuriScanFSScanner::get_ignored_directories_live();

        foreach( $dir_list_list as $group => $dir_list ){
            foreach( $dir_list as $dir_data ){
                $valid_entry = FALSE;
                $snippet_data = array(
                    'IgnoreScanning.CssClass' => '',
                    'IgnoreScanning.Directory' => '',
                    'IgnoreScanning.DirectoryPath' => '',
                    'IgnoreScanning.IgnoredAt' => '',
                    'IgnoreScanning.IgnoredAtText' => 'ok',
                    'IgnoreScanning.IgnoredCssClass' => 'success',
                );

                if( $group == 'is_ignored' ){
                    $valid_entry = TRUE;
                    $snippet_data['IgnoreScanning.Directory'] = urlencode($dir_data['directory_path']);
                    $snippet_data['IgnoreScanning.DirectoryPath'] = SucuriScan::escape($dir_data['directory_path']);
                    $snippet_data['IgnoreScanning.IgnoredAt'] = SucuriScan::datetime($dir_data['ignored_at']);
                    $snippet_data['IgnoreScanning.IgnoredAtText'] = 'ignored';
                    $snippet_data['IgnoreScanning.IgnoredCssClass'] = 'warning';
                }

                elseif( $group == 'is_not_ignored' ){
                    $valid_entry = TRUE;
                    $snippet_data['IgnoreScanning.Directory'] = urlencode($dir_data);
                    $snippet_data['IgnoreScanning.DirectoryPath'] = SucuriScan::escape($dir_data);
                }

                if( $valid_entry ){
                    $css_class = ( $counter %2 == 0 ) ? '' : 'alternate';
                    $snippet_data['IgnoreScanning.CssClass'] = $css_class;
                    $template_variables['IgnoreScanning.ResourceList'] .= SucuriScanTemplate::get_snippet('settings-ignorescanning', $snippet_data);
                    $counter += 1;
                }
            }
        }

        if( $counter > 0 ){
            $template_variables['IgnoreScanning.NoItemsVisibility'] = 'hidden';
        }
    }

    return SucuriScanTemplate::get_section('settings-ignorescanning', $template_variables);
}

/**
 * Read and parse the content of the heartbeat settings template.
 *
 * @return string Parsed HTML code for the heartbeat settings panel.
 */
function sucuriscan_settings_heartbeat(){
    // Current values set in the options table.
    $heartbeat_status = SucuriScanOption::get_option(':heartbeat');
    $heartbeat_pulse = SucuriScanOption::get_option(':heartbeat_pulse');
    $heartbeat_interval = SucuriScanOption::get_option(':heartbeat_interval');
    $heartbeat_autostart = SucuriScanOption::get_option(':heartbeat_autostart');

    // Allowed values for each setting.
    $statuses_allowed = SucuriScanHeartbeat::statuses_allowed();
    $pulses_allowed = SucuriScanHeartbeat::pulses_allowed();
    $intervals_allowed = SucuriScanHeartbeat::intervals_allowed();

    // HTML select form fields.
    $heartbeat_options = SucuriScanTemplate::get_select_options( $statuses_allowed, $heartbeat_status );
    $heartbeat_pulse_options = SucuriScanTemplate::get_select_options( $pulses_allowed, $heartbeat_pulse );
    $heartbeat_interval_options = SucuriScanTemplate::get_select_options( $intervals_allowed, $heartbeat_interval );

    $template_variables = array(
        'HeartbeatStatus' => 'Undefined',
        'HeartbeatPulse' => 'Undefined',
        'HeartbeatInterval' => 'Undefined',
        /* Heartbeat Options. */
        'HeartbeatStatusOptions' => $heartbeat_options,
        'HeartbeatPulseOptions' => $heartbeat_pulse_options,
        'HeartbeatIntervalOptions' => $heartbeat_interval_options,
        /* Heartbeat Auto-Start. */
        'HeartbeatAutostart' => 'Enabled',
        'HeartbeatAutostartSwitchText' => 'Disable',
        'HeartbeatAutostartSwitchValue' => 'disable',
        'HeartbeatAutostartSwitchCssClass' => 'button-danger',
    );

    if( array_key_exists($heartbeat_status, $statuses_allowed) ){
        $template_variables['HeartbeatStatus'] = $statuses_allowed[$heartbeat_status];
    }

    if( array_key_exists($heartbeat_pulse, $pulses_allowed) ){
        $template_variables['HeartbeatPulse'] = $pulses_allowed[$heartbeat_pulse];
    }

    if( array_key_exists($heartbeat_interval, $intervals_allowed) ){
        $template_variables['HeartbeatInterval'] = $intervals_allowed[$heartbeat_interval];
    }

    if( $heartbeat_autostart == 'disabled' ){
        $template_variables['HeartbeatAutostart'] = 'Disabled';
        $template_variables['HeartbeatAutostartSwitchText'] = 'Enable';
        $template_variables['HeartbeatAutostartSwitchValue'] = 'enable';
        $template_variables['HeartbeatAutostartSwitchCssClass'] = 'button-success';
    }

    return SucuriScanTemplate::get_section('settings-heartbeat', $template_variables);
}

/**
 * Generate and print the HTML code for the InfoSys page.
 *
 * This page will contains information of the system where the site is hosted,
 * also information about users in session, htaccess rules and configuration
 * options.
 *
 * @return void
 */
function sucuriscan_infosys_page(){
    SucuriScanInterface::check_permissions();

    // Process all form submissions.
    sucuriscan_infosys_form_submissions();

    // Page pseudo-variables initialization.
    $template_variables = array(
        'PageTitle' => 'Site Info',
        'ServerInfo' => sucuriscan_server_info(),
        'Cronjobs' => sucuriscan_show_cronjobs(),
        'HTAccessIntegrity' => sucuriscan_infosys_htaccess(),
        'WordpressConfig' => sucuriscan_infosys_wpconfig(),
        'ErrorLogs' => sucuriscan_infosys_errorlogs(),
    );

    echo SucuriScanTemplate::get_template('infosys', $template_variables);
}

/**
 * Find the main htaccess file for the site and check whether the rules of the
 * main htaccess file of the site are the default rules generated by WordPress.
 *
 * @return string The HTML code displaying the information about the HTAccess rules.
 */
function sucuriscan_infosys_htaccess(){
    $htaccess_path = SucuriScan::get_htaccess_path();

    $template_variables = array(
        'HTAccess.Content' => '',
        'HTAccess.Message' => '',
        'HTAccess.MessageType' => '',
        'HTAccess.MessageVisible' => 'hidden',
        'HTAccess.TextareaVisible' => 'hidden',
    );

    if( $htaccess_path ){
        $htaccess_rules = file_get_contents($htaccess_path);

        $template_variables['HTAccess.MessageType'] = 'updated';
        $template_variables['HTAccess.MessageVisible'] = 'visible';
        $template_variables['HTAccess.TextareaVisible'] = 'visible';
        $template_variables['HTAccess.Content'] = $htaccess_rules;
        $template_variables['HTAccess.Message'] .= 'HTAccess file found in this path <code>'.$htaccess_path.'</code>';

        if( empty($htaccess_rules) ){
            $template_variables['HTAccess.TextareaVisible'] = 'hidden';
            $template_variables['HTAccess.Message'] .= '</p><p>The HTAccess file found is completely empty.';
        }
        if( sucuriscan_htaccess_is_standard($htaccess_rules) ){
            $template_variables['HTAccess.Message'] .= '</p><p>
                The main <code>.htaccess</code> file in your site has the standard rules for a WordPress installation. You can customize it to improve the
                performance and change the behaviour of the redirections for pages and posts in your site. To get more information visit the official documentation at
                <a href="http://codex.wordpress.org/Using_Permalinks#Creating_and_editing_.28.htaccess.29" target="_blank">Codex WordPrexx - Creating and editing (.htaccess)</a>';
        }
    }else{
        $template_variables['HTAccess.Message'] = 'Your website does not contains a <code>.htaccess</code> file or it was not found in the default location.';
        $template_variables['HTAccess.MessageType'] = 'error';
        $template_variables['HTAccess.MessageVisible'] = 'visible';
    }

    return SucuriScanTemplate::get_section('infosys-htaccess', $template_variables);
}

/**
 * Check whether the rules in a htaccess file are the default options generated
 * by WordPress or if the file has custom options added by other Plugins.
 *
 * @param  string  $rules Optional parameter containing a text string with the content of the main htaccess file.
 * @return boolean        Either TRUE or FALSE if the rules found in the htaccess file specified are the default ones or not.
 */
function sucuriscan_htaccess_is_standard($rules=FALSE){
    if( $rules===FALSE ){
        $htaccess_path = SucuriScan::get_htaccess_path();
        $rules = $htaccess_path ? file_get_contents($htaccess_path) : '';
    }

    if( !empty($rules) ){
        $standard_lines = array(
            '# BEGIN WordPress',
            '<IfModule mod_rewrite\.c>',
            'RewriteEngine On',
            'RewriteBase \/',
            'RewriteRule .index.\.php. - \[L\]',
            'RewriteCond %\{REQUEST_FILENAME\} \!-f',
            'RewriteCond %\{REQUEST_FILENAME\} \!-d',
            'RewriteRule \. \/index\.php \[L\]',
            '<\/IfModule>',
            '# END WordPress',
        );
        $pattern  = '';
        $standard_lines_total = count($standard_lines);
        foreach($standard_lines as $i=>$line){
            if( $i < ($standard_lines_total-1) ){
                $end_of_line = "\n";
            }else{
                $end_of_line = '';
            }
            $pattern .= sprintf("%s%s", $line, $end_of_line);
        }

        if( preg_match("/{$pattern}/", $rules) ){
            return TRUE;
        }
    }

    return FALSE;
}

/**
 * Retrieve all the constants and variables with their respective values defined
 * in the WordPress configuration file, only the database password constant is
 * omitted for security reasons.
 *
 * @return string The HTML code displaying the constants and variables found in the wp-config file.
 */
function sucuriscan_infosys_wpconfig(){
    $template_variables = array(
        'WordpressConfig.Rules' => '',
        'WordpressConfig.Total' => 0,
    );

    $ignore_wp_rules = array( 'DB_PASSWORD' );
    $wp_config_path = SucuriScan::get_wpconfig_path();

    if( $wp_config_path ){
        $wp_config_rules = array();
        $wp_config_content = SucuriScanFileInfo::file_lines($wp_config_path);

        // Parse the main configuration file and look for constants and global variables.
        foreach( (array) $wp_config_content as $line ){
            // Ignore commented lines.
            if ( preg_match('/^\s?(#|\/\/)/', $line) ) { continue; }

            // Detect PHP constants even if the line if indented.
            elseif ( preg_match('/define\(/', $line) ) {
                $line = preg_replace('/.*define\((.+)\);.*/', '$1', $line);
                $line_parts = explode(',', $line, 2);
            }

            // Detect global variables like the database table prefix.
            elseif( preg_match('/^\$[a-zA-Z_]+/', $line) ){
                $line = preg_replace( '/;\s\/\/.*/', ';', $line );
                $line_parts = explode('=', $line, 2);
            }

            // Ignore other lines.
            else { continue; }

            // Clean and append the rule to the wp_config_rules variable.
            if( isset($line_parts) && count($line_parts)==2 ){
                $key_name = '';
                $key_value = '';

                // TODO: A foreach loop is not really necessary, find a better way.
                foreach( $line_parts as $i => $line_part ){
                    $line_part = trim($line_part);
                    $line_part = ltrim($line_part, '$');
                    $line_part = rtrim($line_part, ';');

                    // Remove single/double quotes at the beginning and end of the string.
                    $line_part = ltrim($line_part, "'");
                    $line_part = rtrim($line_part, "'");
                    $line_part = ltrim($line_part, '"');
                    $line_part = rtrim($line_part, '"');

                    // Assign the clean strings to specific variables.
                    if( $i==0 ){ $key_name = $line_part; }
                    if( $i==1 ){
                        if( defined($key_name) ){
                            $key_value = constant($key_name);

                            if( is_bool($key_value) ){
                                $key_value = ( $key_value === TRUE ) ? 'TRUE' : 'FALSE';
                            }
                        } else {
                            $key_value = $line_part;
                        }
                    }
                }

                // Remove the value of sensitive variables like the database password.
                if( in_array($key_name, $ignore_wp_rules) ){
                    $key_value = 'hidden';
                }

                // Append the value to the configuration rules.
                $wp_config_rules[$key_name] = $key_value;
            }
        }

        // Pass the WordPress configuration rules to the template and show them.
        $counter = 0;
        foreach( $wp_config_rules as $var_name => $var_value ){
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
            $label_css = 'sucuriscan-monospace';

            if( empty($var_value) ){
                $var_value = 'empty';
                $label_css = 'sucuriscan-label-default';
            }

            elseif( $var_value == 'hidden' ){
                $label_css = 'sucuriscan-label-info';
            }

            $template_variables['WordpressConfig.Total'] += 1;
            $template_variables['WordpressConfig.Rules'] .= SucuriScanTemplate::get_snippet('infosys-wpconfig', array(
                'WordpressConfig.VariableName' => SucuriScan::escape($var_name),
                'WordpressConfig.VariableValue' => SucuriScan::escape($var_value),
                'WordpressConfig.VariableCssClass' => $label_css,
                'WordpressConfig.CssClass' => $css_class,
            ));
            $counter += 1;
        }
    }

    return SucuriScanTemplate::get_section('infosys-wpconfig', $template_variables);
}

/**
 * Retrieve a list with the scheduled tasks configured for the site.
 *
 * @return array A list of pseudo-variables and values that will replace them in the HTML template.
 */
function sucuriscan_show_cronjobs(){
    $template_variables = array(
        'Cronjobs.List' => '',
        'Cronjobs.Total' => 0,
    );

    $cronjobs = _get_cron_array();
    $schedules = wp_get_schedules();
    $counter = 0;

    foreach( $cronjobs as $timestamp => $cronhooks ){
        foreach( (array) $cronhooks as $hook => $events ){
            foreach( (array) $events as $key => $event ){
                if( empty($event['args']) ){
                    $event['args'] = array( '<em>empty</em>' );
                }

                $template_variables['Cronjobs.Total'] += 1;
                $template_variables['Cronjobs.List'] .= SucuriScanTemplate::get_snippet('infosys-cronjobs', array(
                    'Cronjob.Hook' => $hook,
                    'Cronjob.Schedule' => $event['schedule'],
                    'Cronjob.NextTime' => SucuriScan::datetime($timestamp),
                    'Cronjob.Arguments' => SucuriScan::implode(', ', $event['args']),
                    'Cronjob.CssClass' => ( $counter % 2 == 0 ) ? '' : 'alternate',
                ));
                $counter += 1;
            }
        }
    }

    return SucuriScanTemplate::get_section('infosys-cronjobs', $template_variables);
}

/**
 * Process the requests sent by the form submissions originated in the infosys
 * page, all forms must have a nonce field that will be checked against the one
 * generated in the template render function.
 *
 * @param  boolean $page_nonce True if the nonce is valid, False otherwise.
 * @return void
 */
function sucuriscan_infosys_form_submissions(){
    if( SucuriScanInterface::check_nonce() ){

        // Modify the scheduled tasks (run now, remove, re-schedule).
        $allowed_actions = '(runnow|hourly|twicedaily|daily|remove)';

        if( $cronjob_action = SucuriScanRequest::post( ':cronjob_action', $allowed_actions ) ){
            $cronjobs = SucuriScanRequest::post(':cronjobs', '_array');

            if( !empty($cronjobs) ){
                $total_tasks = count($cronjobs);

                switch( $cronjob_action ){
                    case 'runnow':
                        SucuriScanInterface::info( $total_tasks . ' tasks were scheduled to run in the next ten seconds.' );
                        foreach( $cronjobs as $task_name ){
                            wp_schedule_single_event( time() + 600, $task_name );
                        }
                        break;
                    case 'remove':
                        SucuriScanInterface::info( $total_tasks . ' scheduled tasks were removed.' );
                        foreach( $cronjobs as $task_name ){
                            wp_clear_scheduled_hook($task_name);
                        }
                        break;
                    default:
                        SucuriScanInterface::info( $total_tasks . ' tasks were re-scheduled to run <code>' . $cronjob_action . '</code>.' );
                        foreach( $cronjobs as $task_name ){
                            wp_clear_scheduled_hook($task_name);
                            $next_due = wp_next_scheduled($task_name);
                            wp_schedule_event( $next_due, $cronjob_action, $task_name );
                        }
                        break;
                }
            } else {
                SucuriScanInterface::error( 'No scheduled tasks were selected from the list.' );
            }
        }

    }
}

/**
 * Locate, parse and display the latest error logged in the main error_log file.
 *
 * @return array A list of pseudo-variables and values that will replace them in the HTML template.
 */
function sucuriscan_infosys_errorlogs(){
    $template_variables = array(
        'ErrorLog.Path' => '',
        'ErrorLog.Exists' => 'No',
        'ErrorLog.NoItemsVisibility' => 'visible',
        'ErrorLog.DisabledVisibility' => 'visible',
        'ErrorLog.FileSize' => '0B',
        'ErrorLog.List' => '',
    );

    $error_log_path = realpath( ABSPATH . '/error_log' );
    $parse_errorlogs = ( SucuriScanOption::get_option(':parse_errorlogs') !== 'disabled' );
    $errorlogs_limit = SucuriScanOption::get_option(':errorlogs_limit');

    if ( $error_log_path && $parse_errorlogs ) {
        $template_variables['ErrorLog.Path'] = $error_log_path;
        $template_variables['ErrorLog.Exists'] = 'Yes';
        $template_variables['ErrorLog.FileSize'] = SucuriScan::human_filesize( filesize($error_log_path) );
        $template_variables['ErrorLog.DisabledVisibility'] = 'hidden';

        $last_lines = SucuriScanFileInfo::tail_file( $error_log_path, $errorlogs_limit );
        $error_logs = SucuriScanFSScanner::parse_error_logs($last_lines);
        $error_logs = array_reverse($error_logs);
        $counter = 0;

        foreach ( $error_logs as $error_log ) {
            $css_class = ( $counter % 2 == 0 ) ? '' : 'alternate';
            $template_variables['ErrorLog.List'] .= SucuriScanTemplate::get_snippet('infosys-errorlogs', array(
                'ErrorLog.CssClass' => $css_class,
                'ErrorLog.DateTime' => SucuriScan::datetime( $error_log->timestamp ),
                'ErrorLog.ErrorType' => SucuriScan::escape( $error_log->error_type ),
                'ErrorLog.ErrorCode' => SucuriScan::escape($error_log->error_code),
                'ErrorLog.ErrorAbbr' => strtoupper( substr($error_log->error_code, 0, 1) ),
                'ErrorLog.ErrorMessage' => SucuriScan::escape( $error_log->error_message ),
                'ErrorLog.FilePath' => SucuriScan::escape( $error_log->file_path ),
                'ErrorLog.LineNumber' => SucuriScan::escape( $error_log->line_number ),
            ));
            $counter += 1;
        }

        if ( $counter > 0 ) {
            $template_variables['ErrorLog.NoItemsVisibility'] = 'hidden';
        }
    }

    return SucuriScanTemplate::get_section('infosys-errorlogs', $template_variables);
}

/**
 * Gather information from the server, database engine, and PHP interpreter.
 *
 * @return array A list of pseudo-variables and values that will replace them in the HTML template.
 */
function sucuriscan_server_info(){
    global $wpdb;

    $template_variables = array(
        'ServerInfo.Variables' => '',
    );

    $info_vars = array(
        'Plugin_version' => SUCURISCAN_VERSION,
        'Plugin_checksum' => SUCURISCAN_PLUGIN_CHECKSUM,
        'Last_filesystem_scan' => SucuriScanFSScanner::get_filesystem_runtime(TRUE),
        'Using_CloudProxy' => 'Unknown',
        'HTTP_Host' => 'Unknown',
        'Host_Name' => 'Unknown',
        'Host_Address' => 'Unknown',
        'Remote_Address' => SucuriScan::get_remote_addr(),
        'Remote_Address_Header' => SucuriScan::get_remote_addr_header(),
        'Operating_system' => sprintf('%s (%d Bit)', PHP_OS, PHP_INT_SIZE*8),
        'Server' => 'Unknown',
        'Developer_mode' => 'OFF',
        'Memory_usage' => 'N/A',
        'MySQL_version' => '0.0',
        'SQL_mode' => 'Not set',
        'PHP_version' => PHP_VERSION,
    );

    $proxy_info = SucuriScan::is_behind_cloudproxy(TRUE);
    $info_vars['HTTP_Host'] = $proxy_info['http_host'];
    $info_vars['Host_Name'] = $proxy_info['host_name'];
    $info_vars['Host_Address'] = $proxy_info['host_addr'];
    $info_vars['Using_CloudProxy'] = $proxy_info['status'] ? 'Yes' : 'No';

    if( defined('WP_DEBUG') && WP_DEBUG ){
        $info_vars['Developer_mode'] = 'ON';
    }

    if( function_exists('memory_get_usage') ){
        $info_vars['Memory_usage'] = round(memory_get_usage() / 1024 / 1024, 2).' MB';
    }

    if( isset($_SERVER['SERVER_SOFTWARE']) ){
        $info_vars['Server'] = SucuriScan::escape($_SERVER['SERVER_SOFTWARE']);
    }

    if( $wpdb ){
        $info_vars['MySQL_version'] = $wpdb->get_var('SELECT VERSION() AS version');

        $mysql_info = $wpdb->get_results('SHOW VARIABLES LIKE "sql_mode"');
        if( is_array($mysql_info) && !empty($mysql_info[0]->Value) ){
            $info_vars['SQL_mode'] = $mysql_info[0]->Value;
        }
    }

    $field_names = array(
        'safe_mode',
        'expose_php',
        'allow_url_fopen',
        'memory_limit',
        'upload_max_filesize',
        'post_max_size',
        'max_execution_time',
        'max_input_time',
    );

    foreach( $field_names as $php_flag ){
        $php_flag_value = SucuriScan::ini_get($php_flag);
        $php_flag_name = 'PHP_' . $php_flag;
        $info_vars[$php_flag_name] = $php_flag_value ? $php_flag_value : 'N/A';
    }

    $counter = 0;

    foreach( $info_vars as $var_name => $var_value ){
        $css_class = ( $counter %2 == 0 ) ? '' : 'alternate';
        $var_name = str_replace('_', chr(32), $var_name);

        $template_variables['ServerInfo.Variables'] .= SucuriScanTemplate::get_snippet('infosys-serverinfo', array(
            'ServerInfo.CssClass' => $css_class,
            'ServerInfo.Title' => $var_name,
            'ServerInfo.Value' => $var_value,
        ));
        $counter += 1;
    }

    return SucuriScanTemplate::get_section('infosys-serverinfo', $template_variables);
}

