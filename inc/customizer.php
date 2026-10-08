<?php

/**
 * Pengaturan Berita 14 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Nama theme mod sama dengan versi Kirki (color_theme, image_iklan_*, link_iklan_*,
 * link_sosmed_*, title_posts_home_*, cat_posts_home_*) supaya nilai yang sudah tersimpan
 * tetap terbaca sesudah tema diperbarui.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/** Warna bawaan tema (bawaan field Kirki color_theme versi lama). */
define('VELOCITY_BERITA14_WARNA', '#740106');

/**
 * Slot iklan yang dipanggil template (slot versi Kirki lain tidak pernah tampil, jadi tidak ditampilkan
 * di Customizer): id => [label, keterangan ukuran]. Slot tanpa gambar tidak tampil.
 * Ukuran "WxH" di keterangan dibaca installer untuk membuat banner "Ruang Iklan" seukuran slot.
 */
function velocity_berita14_slot_iklan()
{
    return array(
        'iklan_header'  => array('Iklan Header', 'Iklan Header 728x90'),
        'iklan_content' => array('Iklan Single', 'Iklan Single post 600x80'),
    );
}

/** Sosial media: id => label. Link kosong = ikon disembunyikan. */
function velocity_berita14_sosmed()
{
    return array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter / X',
        'instagram' => 'Instagram',
        'youtube'   => 'YouTube',
    );
}

/** Blok berita beranda: id => label. */
function velocity_berita14_blok()
{
    return array(
        'posts_home_1' => 'Posts Home 1 (carousel kecil)',
        'posts_home_2' => 'Posts Home 2 (grid)',
        'posts_home_3' => 'Posts Home 3 (galeri kiri)',
        'posts_home_4' => 'Posts Home 4 (kiri bawah)',
        'posts_home_5' => 'Posts Home 5 (kolom kanan)',
        'posts_home_6' => 'Posts Home 6 (bawah)',
    );
}

function velocity_berita14_sanitize_kategori($value)
{
    $value = (string) $value;
    return ($value !== '' && term_exists((int) $value, 'category')) ? (string) absint($value) : '';
}

add_action('customize_register', 'velocity_berita14_customize_register', 20);
function velocity_berita14_customize_register(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_panel('panel_berita', array(
        'priority' => 10,
        'title'    => esc_html__('Berita', 'justg'),
    ));

    // Warna.
    $wp_customize->add_section('section_colorberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Warna', 'justg'),
        'description' => esc_html__('Kosongkan untuk memakai warna utama tema (Primary Color) atau warna bawaan tema.', 'justg'),
        'priority'    => 10,
    ));
    $wp_customize->add_setting('color_theme', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_theme', array(
        'label'   => esc_html__('Warna Tema', 'justg'),
        'section' => 'section_colorberita',
    )));

    // Iklan.
    $wp_customize->add_section('section_iklanberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Iklan', 'justg'),
        'description' => esc_html__('Slot tanpa gambar tidak ditampilkan.', 'justg'),
        'priority'    => 20,
    ));
    foreach (velocity_berita14_slot_iklan() as $id => $slot) {
        $wp_customize->add_setting('image_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_' . $id, array(
            'label'       => sprintf(esc_html__('Gambar %s', 'justg'), $slot[0]),
            'description' => $slot[1],
            'section'     => 'section_iklanberita',
        )));
        $wp_customize->add_setting('link_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_' . $id, array(
            'type'    => 'url',
            'label'   => sprintf(esc_html__('Link %s', 'justg'), $slot[0]),
            'section' => 'section_iklanberita',
        ));
    }

    // Sosial media.
    $wp_customize->add_section('section_sosmedberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Sosial Media', 'justg'),
        'description' => esc_html__('Kosongkan link untuk menyembunyikan ikonnya.', 'justg'),
        'priority'    => 30,
    ));
    foreach (velocity_berita14_sosmed() as $id => $label) {
        $wp_customize->add_setting('link_sosmed_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_sosmed_' . $id, array(
            'type'    => 'url',
            'label'   => sprintf(esc_html__('Link %s', 'justg'), $label),
            'section' => 'section_sosmedberita',
        ));
    }

    // Blok berita beranda.
    $wp_customize->add_section('section_homeberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Home', 'justg'),
        'description' => esc_html__('Judul kosong = nama kategori yang dipilih.', 'justg'),
        'priority'    => 40,
    ));

    $kategori = array('' => esc_html__('Semua Kategori (terbaru)', 'justg'));
    foreach (get_categories(array('hide_empty' => false, 'exclude' => array(1))) as $term) {
        $kategori[(string) $term->term_id] = $term->name;
    }

    foreach (velocity_berita14_blok() as $id => $label) {
        $wp_customize->add_setting('title_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('title_' . $id, array(
            'type'    => 'text',
            'label'   => sprintf(esc_html__('Judul %s', 'justg'), $label),
            'section' => 'section_homeberita',
        ));
        $wp_customize->add_setting('cat_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'velocity_berita14_sanitize_kategori',
        ));
        $wp_customize->add_control('cat_' . $id, array(
            'type'    => 'select',
            'label'   => sprintf(esc_html__('Kategori %s', 'justg'), $label),
            'section' => 'section_homeberita',
            'choices' => $kategori,
        ));
    }
}

/**
 * Warna tema: pilihan Customizer Berita, lalu Primary Color induk (diisi installer dari
 * warna klien), lalu warna bawaan tema.
 */
function velocity_berita14_warna()
{
    $warna = sanitize_hex_color((string) get_theme_mod('color_theme', ''));
    if (!$warna) {
        $utama = sanitize_hex_color((string) get_theme_mod('primary_color', ''));
        $warna = ($utama && strtolower($utama) !== '#1e73be') ? $utama : VELOCITY_BERITA14_WARNA;
    }
    return $warna;
}

add_action('wp_head', 'velocity_berita14_css_warna', 100);
function velocity_berita14_css_warna()
{
    printf(
        '<style id="velocity-berita14-warna">:root{--color-theme:%1$s;}.border-color-theme{--bs-border-color:%1$s;}</style>' . "\n",
        esc_attr(velocity_berita14_warna())
    );
}

/** URL gambar iklan; Kirki lama bisa menyimpan id lampiran atau array. */
function velocity_berita14_url_gambar($nilai)
{
    if (is_numeric($nilai)) {
        return (string) wp_get_attachment_url((int) $nilai);
    }
    if (is_array($nilai)) {
        $nilai = isset($nilai['url']) ? $nilai['url'] : (isset($nilai['id']) ? wp_get_attachment_url((int) $nilai['id']) : '');
    }
    return (string) $nilai;
}

/**
 * Id kategori blok untuk WP_Query ('' = semua kategori).
 * Pilihan "Nonaktifkan" versi Kirki ('disable') pada praktiknya menampilkan semua kategori.
 */
function velocity_berita14_kategori($id)
{
    $cat = get_theme_mod('cat_' . $id, '');
    $cat = is_array($cat) ? (string) reset($cat) : (string) $cat;
    return ($cat === '' || !term_exists((int) $cat, 'category')) ? '' : (string) absint($cat);
}

/**
 * Judul blok: isian Customizer, lalu nama kategori, lalu "Berita Terbaru".
 * "Recent Posts" adalah bawaan versi Kirki, jadi diperlakukan sebagai kosong.
 */
function velocity_berita14_judul($id)
{
    $judul = trim((string) get_theme_mod('title_' . $id, ''));
    if ($judul !== '' && $judul !== 'Recent Posts') {
        return $judul;
    }
    $cat  = velocity_berita14_kategori($id);
    $term = ($cat !== '') ? get_term((int) $cat, 'category') : null;
    return ($term && !is_wp_error($term)) ? $term->name : __('Berita Terbaru', 'justg');
}

/** Kepala blok beranda: judul + tombol ke arsip kategori (bila kategori dipilih). */
function velocity_berita14_kepala_blok($id)
{
    $cat   = velocity_berita14_kategori($id);
    $judul = velocity_berita14_judul($id);
    echo '<h3 class="home-title d-flex align-items-center justify-content-between">';
    echo '<span>' . esc_html($judul) . '</span>';
    if ($cat !== '') {
        echo '<a class="btn btn-sm py-0 text-white px-1" href="' . esc_url(get_category_link((int) $cat)) . '" aria-label="' . esc_attr(sprintf(__('Lihat semua %s', 'justg'), $judul)) . '">';
        echo '<i class="fa fa-rss" aria-hidden="true"></i>';
        echo '</a>';
    }
    echo '</h3>';
}
