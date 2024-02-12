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


    if (class_exists('Kirki')) :

        Kirki::add_panel('panel_berita', [
            'priority'    => 10,
            'title'       => esc_html__('Berita', 'justg'),
            'description' => esc_html__('', 'justg'),
        ]);

        ///Section Color
        Kirki::add_section('section_colorberita', [
            'panel'    => 'panel_berita',
            'title'    => __('Warna', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme',
            'label'       => __('Color Theme', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorberita',
            'default'     => '#740106',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme',
                ],
                [
                    'element'   => '.border-color-theme',
                    'property'  => '--bs-border-color',
                ]
            ],
        ]);

        ///Section Iklan
        Kirki::add_section('section_iklanberita', [
            'panel'    => 'panel_berita',
            'title'    => __('Iklan', 'justg'),
            'priority' => 10,
        ]);
        $fieldiklan = [
            'iklan_header'  => [
                'label'            => 'Iklan Header',
                'description'    => 'Iklan Halaman Depan 728x90',
            ],
            'iklan_home_1'  => [
                'label'            => 'Iklan Home 1',
                'description'    => 'Iklan Halaman Depan 310x350',
            ],
            'iklan_home_2'  => [
                'label'            => 'Iklan Home 2',
                'description'    => 'Iklan Halaman Depan 300x250',
            ],
            'iklan_home_3'  => [
                'label'            => 'Iklan Home 3',
                'description'    => 'Iklan Halaman Depan 300x250',
            ],
            'iklan_home_bawah_1'  => [
                'label'            => 'Iklan Home Bawah 1',
                'description'    => 'Iklan Halaman Depan Bawah 600x80',
            ],
            'iklan_home_bawah_2'  => [
                'label'            => 'Iklan Home Bawah 2',
                'description'    => 'Iklan Halaman Depan Bawah 600x80',
            ],
            'iklan_content'  => [
                'label'            => 'Iklan Single',
                'description'    => 'Iklan Single post 600x80 ',
            ],
            'iklan_content_2'  => [
                'label'            => 'Iklan Single 2',
                'description'    => 'Iklan Single post 300x250 ',
            ],
            'iklan_archive'  => [
                'label'            => 'Iklan Archive',
                'description'    => 'Iklan Arsip post 600x60',
            ],
            'iklan_archive_2'  => [
                'label'            => 'Iklan Archive 2',
                'description'    => 'Iklan Arsip post 600x60',
            ]
        ];
        foreach ($fieldiklan as $idfield => $datafield) {
            Kirki::add_field('justg_config', [
                'type'        => 'image',
                'settings'    => 'image_' . $idfield,
                'label'       => esc_html__('Gambar ' . $datafield['label'], 'kirki'),
                'description' => esc_html__($datafield['description'], 'kirki'),
                'section'     => 'section_iklanberita',
                'default'     => '',
                'partial_refresh'    => [
                    'partial_' . $idfield => [
                        'selector'        => '.part_' . $idfield,
                        'render_callback' => '__return_false'
                    ]
                ],
            ]);
            Kirki::add_field('justg_config', [
                'type'     => 'link',
                'settings' => 'link_' . $idfield,
                'label'    => __('Link ' . $datafield['label'], 'kirki'),
                'section'  => 'section_iklanberita',
                'default'  => '',
                'priority' => 10,
            ]);
        }

        ///Section Sosmed
        Kirki::add_section('section_sosmedberita', [
            'panel'    => 'panel_berita',
            'title'    => __('Sosial Media', 'justg'),
            'priority' => 10,
        ]);
        $fieldsosmed = [
            'facebook'  => [
                'label'    => 'Facebook',
            ],
            'twitter'  => [
                'label'    => 'Twitter',
            ],
            'instagram'  => [
                'label'    => 'Instagram',
            ],
            'youtube'  => [
                'label'    => 'Youtube',
            ]
        ];
        foreach ($fieldsosmed as $idfield => $datafield) {
            Kirki::add_field('justg_config', [
                'type'     => 'link',
                'settings' => 'link_sosmed_' . $idfield,
                'label'    => __('Link ' . $datafield['label'], 'kirki'),
                'section'  => 'section_sosmedberita',
                'default'  => 'https://' . $idfield . '.com/',
                'priority' => 10,
            ]);
        }

        ///Section Home
        Kirki::add_section('section_homeberita', [
            'panel'    => 'panel_berita',
            'title'    => __('Home', 'justg'),
            'priority' => 10,
        ]);

        ///field set posts
        $fieldposts = [
            'posts_home_1'  => [
                'label'        => 'Posts Home 1',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
            'posts_home_2'  => [
                'label'        => 'Posts Home 2',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
            'posts_home_3'  => [
                'label'        => 'Posts Home 3',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
            'posts_home_4'  => [
                'label'        => 'Posts Home 4',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
            'posts_home_5'  => [
                'label'        => 'Posts Home 5',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
            'posts_home_6'  => [
                'label'        => 'Posts Home 6',
                'section'    => 'section_homeberita',
                'title'        => 'Recent Posts',
            ],
        ];
        $categories = Kirki_Helper::get_terms('category');
        $categories['disable'] = 'Nonaktifkan';
        unset($categories[1]);
        foreach ($fieldposts as $idfield => $datafield) {
            if (isset($datafield['title'])) {
                Kirki::add_field('justg_config', [
                    'type'     => 'text',
                    'settings' => 'title_' . $idfield,
                    'label'    => esc_html__('Judul ' . $datafield['label'], 'kirki'),
                    'section'  => $datafield['section'],
                    'default'  => esc_html__($datafield['title'], 'kirki'),
                    'priority' => 10,
                ]);
            }
            Kirki::add_field('justg_config', [
                'type'        => 'select',
                'settings'    => 'cat_' . $idfield,
                'label'       => esc_html__('Kategori ' . $datafield['label'], 'kirki'),
                'section'     => $datafield['section'],
                'default'     => '',
                'placeholder' => esc_html__('Pilih kategori', 'kirki'),
                'priority'    => 10,
                'multiple'    => 1,
                'choices'     => $categories,
                'partial_refresh'    => [
                    'partial_' . $idfield => [
                        'selector'        => '.part_' . $idfield,
                        'render_callback' => '__return_false'
                    ]
                ],
            ]);
            if (isset($datafield['sortby']) && $datafield['sortby'] == true) {
                Kirki::add_field('justg_config', [
                    'type'     => 'select',
                    'settings' => 'sortby_' . $idfield,
                    'label'    => esc_html__('Urutkan ' . $datafield['label'] . ' berdasarkan', 'kirki'),
                    'section'  => $datafield['section'],
                    'default'  => 'date',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices'  => [
                        'date'    => esc_html__('Tanggal', 'kirki'),
                        'view'    => esc_html__('Tayangan', 'kirki'),
                    ],
                ]);
            }
        }

    endif;

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
    $iklan_content  = velocitytheme_option('image_' . $idiklan, '');
    echo '<div class="part_' . $idiklan . '">';
    if ($iklan_content) {
        $linkiklan = velocitytheme_option('link_' . $idiklan, '');
        echo '<div class="text-center">';
        echo $linkiklan ? '<a href="' . $linkiklan . '" target="_blank">' : '';
        echo '<img class="img-fluid" src="' . $iklan_content . '" loading="lazy">';
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
