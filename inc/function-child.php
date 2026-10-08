<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{


    // Pengaturan Customizer ada di inc/customizer.php (tanpa Kirki).

    register_nav_menus(
        array(
            'secondary' => __('Secondary Menu', 'justg'),
        )
    );

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
}

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header id="wrapper-header">';
        echo '<div id="wrapper-navbar" class="wrapper-fluid wrapper-navbar position-relative pb-0 p-md-0 p-2" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</div>';
        echo '</header>';
    }
}

///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

function get_berita_iklan($idiklan = null)
{
    $iklan_content  = velocity_berita14_url_gambar(get_theme_mod('image_' . $idiklan, ''));
    echo '<div class="part_' . esc_attr($idiklan) . '">';
    if ($iklan_content) {
        $linkiklan = get_theme_mod('link_' . $idiklan, '');
        echo '<div class="text-center">';
        echo $linkiklan ? '<a href="' . esc_url($linkiklan) . '" target="_blank" rel="noopener">' : '';
        echo '<img class="img-fluid" src="' . esc_url($iklan_content) . '" alt="' . esc_attr__('Iklan', 'justg') . '" loading="lazy">';
        echo $linkiklan ? '</a>' : '';
        echo '</div>';
    }
    echo '</div>';
}

function vdberita_limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

// Fungsi left sidebar archive
function left_sidebar()
{
    if (is_active_sidebar('secondary-sidebar')) :
        echo '<div class="d-none d-md-block col-2 p-0">';
        echo '<div class="sticky-top">';
        dynamic_sidebar('secondary-sidebar');
        echo '</div>';
        echo '</div>';
    endif;
}

function justg_get_hit()
{
    echo get_post_meta(get_the_ID(), 'hit', true);
}
