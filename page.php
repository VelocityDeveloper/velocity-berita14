<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container         = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content">

        <div class="row m-0">
            <?php echo left_sidebar(); ?>
            <?php do_action('justg_before_content'); ?>

            <main class="site-main" id="main" role="main">

                <?php

                while (have_posts()) {
                    the_post();

                    get_template_part('loop-templates/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {

                        do_action('justg_before_comments');
                        comments_template();
                        do_action('justg_before_comments');
                    }
                }
                ?>

            </main><!-- #main -->

            <?php do_action('justg_after_content');
            ?>

        </div>

    </div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
