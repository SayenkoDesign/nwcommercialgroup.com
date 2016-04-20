<?php
require_once __DIR__ . '/bootstrap.php';

// include ACF fields if not in debug mode
//require_once __DIR__ . '/App/ACF/options.php';

// supports
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );
add_theme_support( 'html5' );

// read more link
add_filter( 'excerpt_more', function ( $more ) {
    global $post;
    return ' <a href="' . get_permalink($post->ID) . '" class="read-more">Read More <i class="fa fa-angle-right"></i></a>';
} );

// styles and scripts
add_action('wp_enqueue_scripts', function() {
    wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
    wp_register_style( 'fancybox', get_template_directory_uri() . '/web/scripts/fancybox/source/jquery.fancybox.css' );
    wp_register_style( 'app', get_template_directory_uri() . '/web/stylesheets/app.css', ['fontawesome', 'fancybox'] );
    wp_enqueue_style( 'app' );

    wp_deregister_script('jquery');
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js' );
    wp_register_script( 'fancybox', get_template_directory_uri() . '/web/scripts/fancybox/source/jquery.fancybox.js', ['jquery'], false, true );
    wp_register_script( 'app', get_template_directory_uri() . '/web/scripts-min/app.min.js', ['jquery', 'fancybox'], false, true );
    wp_enqueue_script( 'app' );
});

// menus
add_action( 'after_setup_theme', function () {
    register_nav_menu( 'primary', __( 'Primary Menu', 'theme-slug' ) );
} );

// image sizes
add_image_size( 'home_slider', 1400, 600, true );
add_image_size( 'team_member', 350, 350, true );
add_image_size( 'listing_teaser', 380, 230, true );

// remove margin-top: 32px !important when logged in
add_action('init', function () {
    add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );
});

// options page for ACF
if(function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        'icon_url'      => 'dashicons-sayenko'
    ]);
}

// logo for ACF options page
add_action('admin_head', function () {
    $root_uri = get_template_directory_uri();
    echo <<<HTML
    <style type="text/css">
        .dashicons-sayenko {
            background-image: url('$root_uri/options-icon.png');
            background-size: 18px;
            background-position: 10px center;
            background-repeat: no-repeat;
        }
    </style>
HTML;
});

// register listing post type
add_action( 'init', function () {
    register_post_type( 'listing',
        array(
            'labels' => array(
                'name' => __( 'Listings' ),
                'singular_name' => __( 'Listing' )
            ),
            'public' => true,
            'has_archive' => true,
        )
    );
});

// login logo
add_action('login_head', function() {
    $root_uri = get_template_directory_uri();
    echo <<<HTML
    <style type="text/css">
        h1 a {
            background-image: url('$root_uri/logo.png') !important;
            background-size: contain !important;
            width: 320px !important;
            height: 120px !important;
       }
    </style>
HTML;
});

// comments form fields
add_filter( 'comment_form_fields', function ( $fields ) {
    $commenter = wp_get_current_commenter();

    $comment_field = '<div class="row column"><textarea placeholder="*Your Comment" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>';
    $fields['author'] = '<div class="row">'
        . '<div class="medium-6 columns">'
        . '<input placeholder="*Name" name="author" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author'] ).'"/>'
        . '</div>';
    $fields['email'] = '<div class="medium-6 columns">'
        . '<input name="email" placeholder="*Email" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author_email'] ).'"/>'
        . '</div>'
        . '</div>';

    unset($fields['url']);
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
});
