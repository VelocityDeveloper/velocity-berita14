<?php

/**
 * The template for displaying all single posts
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container  = velocitytheme_option('justg_container_type', 'container');
$full_url   = get_the_post_thumbnail_url(get_the_ID(), 'full');
$format     = get_post_format() ?: 'standard';
?>

<div class="wrapper" id="single-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="stylebread card rounded-0 pt-2 px-3 mb-3">
            <?php echo justg_breadcrumb(); ?>
        </div>

        <div class="row m-0">
            <?php echo left_sidebar(); ?>
            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main col order-2" id="main">

                <?php

                while (have_posts()) {
                    the_post();
                ?>

                    <?php the_title('<h1 class="entry-title h4 fw-bold">', '</h1>'); ?>

                    <div class="d-flex mt-2 justify-content-between align-items-center py-1 px-2 border-bottom border-top text-muted bg-light mb-3">
                        <div class="text-uppercase">
                            <small>
                                <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                            </small>
                            <small class="ms-2">
                                <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                            </small>
                            <?php $getcategories = get_the_category(get_the_ID()); ?>
                            <?php if ($getcategories) : ?>
                                <small class="ms-2">
                                    <i class="fa fa-archive"></i>
                                    <?php foreach ($getcategories as $index => $cat) : ?>
                                        <?php echo $index === 0 ? '' : ','; ?>
                                        <a href="<?php echo get_tag_link($cat->term_id); ?>"> <?php echo $cat->name; ?> </a>
                                        <?php if ($index > 1) {
                                            break;
                                        } ?>
                                    <?php endforeach; ?>
                                </small>
                            <?php endif; ?>
                            <small>
                                <?php edit_post_link(__('Edit', 'justg'), '<span class="edit-link"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> ', '</span>'); ?>
                            </small>
                        </div>
                    </div>

                    <div class="entry-content">

                        <?php
                        if ($full_url && $format !== 'video') {
                            echo '<img class="img-fluid w-100 mb-2" src="' . $full_url . '" loading="lazy">';
                        }
                        ?>

                        <?php the_content(); ?>
                        <div class="mb-3">
                            <?php get_berita_iklan('iklan_content'); ?>
                        </div>

                        <?php $gettags = get_the_category(get_the_ID()); ?>
                        <?php if ($gettags) : ?>
                            <div class="pb-2">
                                <button class="btn btn-dark rounded-0 py-1 px-2">Tags :</button>
                                <?php foreach ($gettags as $index => $tag) : ?>
                                    <?php echo $index === 0 ? '' : ','; ?>
                                    <a class="btn btn-sm bg-color-theme rounded-0 py-1 px-2 text-white" href="<?php echo get_tag_link($tag->term_id); ?>"> <?php echo $tag->name; ?> </a>
                                    <?php if ($index > 1) {
                                        break;
                                    } ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . __('Pages:', 'justg'),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div><!-- .entry-content -->

                    <div class="rating-form p-3 mb-3">
                        <h5 class="fw-bold m-0 text-muted">Rate this article!</h5>
                        <?php
                        echo do_shortcode('[review_form]');
                        echo display_post_rating(get_the_ID());
                        ?>
                    </div>

                    <div class="author-single p-2 bg-muted">
                        <?php
                        $author_id = $post->post_author;
                        $url = get_avatar($author_id);
                        echo '<div class="px-2 fw-bold">Author : ' . get_the_author_posts_link() . '</div>';
                        echo '<div class="px-2">' . $url . '</div>';
                        ?>

                    </div>

                    <div class="single-post-nav py-1 my-3">
                        <div class="nav-post">
                            <div class="d-md-flex justify-content-between" role="group" aria-label="Navigation Post">
                                <?php
                                $prev_post = get_adjacent_post(false, '', true);
                                if (!empty($prev_post)) {
                                    echo '<a href="' . get_permalink($prev_post->ID) . '" class="btn btn-sm btn-light px-3 border rounded-0" title="' . $prev_post->post_title . '">Prev</a>';
                                }
                                $next_post = get_adjacent_post(false, '', false);
                                if (!empty($next_post)) {
                                    echo '<a href="' . get_permalink($next_post->ID) . '" class="btn btn-sm btn-light px-3 border rounded-0" title="' . $next_post->post_title . '">Next</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="related-post">
                        <div class="related-post-title bg-color-theme  mb-2">
                            <h6 class="fw-bold text-white m-0 px-3 py-2 d-inline-block">RELATED POSTS</h6>
                        </div>
                        <div class="overflow-hidden">
                            <?php
                            module_vdposts(array(
                                'post_type'         => 'post',
                                'posts_per_page'    => 4,
                                'post__not_in'      => [get_the_ID()],
                                'category__in'      => wp_get_post_categories(get_the_ID()),
                            ), 'gallery');
                            ?>
                        </div>
                    </div>
                <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        do_action('justg_before_comments');
                        comments_template();
                        do_action('justg_after_comments');
                    }
                }
                ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
