<?php

/**
 * Partial template for content in page.php
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article <?php post_class('block-primary'); ?> id="post-<?php the_ID(); ?>">
    <div class="stylebread card rounded-0 pt-2 px-3 mb-3">
        <?php echo justg_breadcrumb(); ?>
    </div>
    <header class="entry-header mb-2">
        <?php the_title('<div class="entry-page-title fw-bold h6 text-uppercase bg-color-theme text-white p-2">', '</div>'); ?>
    </header><!-- .entry-header -->

    <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>

    <div class="entry-content">

        <?php the_content(); ?>

        <?php
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __('Pages:', 'justg'),
                'after'  => '</div>',
            )
        );
        ?>

    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php edit_post_link(__('Edit', 'justg'), '<span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->