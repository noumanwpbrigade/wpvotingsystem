<?php
/**
 * votingsystem functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package votingsystem
 */

function votingsystem_setup() {
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'votingsystem_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'votingsystem_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function votingsystem_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'votingsystem_content_width', 640 );
}
add_action( 'after_setup_theme', 'votingsystem_content_width', 0 );


function votingsystem_scripts() {
	wp_style_add_data( 'votingsystem-style', 'rtl', 'replace' );

	// css
	wp_enqueue_style('main-stylesheet', get_template_directory_uri() . "/assets/css/main.css");
	wp_enqueue_style('admin-stylesheet', get_template_directory_uri() . "/assets/css/admin-style.css");
	wp_enqueue_style('aos-stylesheet', "https://unpkg.com/aos@2.3.1/dist/aos.css");
	// Enqueue Scripts
wp_enqueue_script('script', get_template_directory_uri() . "/assets/js/script.js", array(), wp_get_theme()->get('Version'), true);

}
add_action( 'wp_enqueue_scripts', 'votingsystem_scripts' );



// DATABASE START
// Function to create the table on theme activation
function create_table_on_activation() {
    global $wpdb;

    // Define the table name with the WordPress prefix
    $table_name = $wpdb->prefix . 'voter';

    $sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		username varchar(50) NOT NULL,
		email varchar(100) NOT NULL,
		cnic varchar(100) NOT NULL,
		password varchar(255) NOT NULL,
		hasvoted tinyint(1) DEFAULT NULL,
		PRIMARY KEY (id)
	  );";

    // Execute the SQL query to create the voter table
    $wpdb->query($sql);
}

register_activation_hook(__FILE__, 'create_table_on_activation');

function create_candidate_table_on_activation() {
    global $wpdb;

    $table_candidate = $wpdb->prefix . 'candidate';
    $sql_candidate = "CREATE TABLE $table_candidate (
        candidateID int(11) NOT NULL AUTO_INCREMENT,
        CNIC varchar(15),
        name varchar(100),
        partyName varchar(150),
        image varchar(200) NOT NULL,
        votesReceived int(11) DEFAULT 0,
        PRIMARY KEY (candidateID)
    );";

    $wpdb->query($sql_candidate);
}

register_activation_hook(__FILE__, 'create_candidate_table_on_activation');


// DATABASE END




