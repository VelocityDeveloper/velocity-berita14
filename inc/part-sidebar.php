<?php
$post1_title    = velocitytheme_option('title_posts_sidebar_1', 'Recent Posts');
$post1_cat      = velocitytheme_option('cat_posts_sidebar_1');
$post2_title    = velocitytheme_option('title_posts_sidebar_2', 'Recent Posts');
$post2_cat      = velocitytheme_option('cat_posts_sidebar_2');
$post2_sort     = velocitytheme_option('sortby_posts_sidebar_2');
?>
<aside id="iklan-sidebar" class="widget widget_berita_iklan">
    <?php get_berita_iklan('iklan_sidebar'); ?>
</aside>

<?php if ($post1_cat !== 'disable') : ?>
    <aside id="sidebar-post-berita1" class="widget widget_berita_posts part_posts_sidebar_1">
        <h3 class="widget-title">
            <span><?php echo $post1_title; ?></span>
        </h3>
        <?php
        $post1_args = array(
            'post_type' => 'post',
            'cat'       => $post1_cat,
            'posts_per_page' => 5,
        );
        module_vdposts($post1_args, 'posts4');
        ?>
    </aside>
<?php endif; ?>

<aside id="iklan-sidebar2" class="widget widget_berita_iklan">
    <?php get_berita_iklan('iklan_sidebar_2'); ?>
</aside>

<?php if ($post2_cat !== 'disable') : ?>
    <aside id="sidebar-post-berita2" class="widget widget_berita_posts part_posts_sidebar_2">
        <h3 class="widget-title">
            <span><?php echo $post2_title; ?></span>
        </h3>
        <?php
        $post2_args = array(
            'post_type'         => 'post',
            'cat'               => $post2_cat,
            'posts_per_page'    => 5,
            'sortby'            => $post2_sort
        );
        module_vdposts($post2_args, 'posts3');
        ?>
    </aside>
<?php endif; ?>

<aside id="sidebar-post-tabs" class="widget widget_berita_tabs">
    <ul class="nav nav-tabs p-0" id="beritaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 bg-light active" id="popular-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-popular" type="button" role="tab" aria-controls="berita-tab-popular" aria-selected="true">
                POPULAR
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 bg-light" id="comments-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-comments" type="button" role="tab" aria-controls="berita-tab-comments" aria-selected="false">
                COMMENTS
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 bg-light" id="tags-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-tags" type="button" role="tab" aria-controls="berita-tab-tags" aria-selected="false">
                TAGS
            </button>
        </li>
    </ul>
    <div class="tab-content pt-2" id="beritaTabsContent">
        <div class="tab-pane fade show active" id="berita-tab-popular" role="tabpanel" aria-labelledby="popular-tab" tabindex="0">
            <?php
            // The Query
            $popular_query = new WP_Query(
                array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'meta_key'          => 'hit',
                    'orderby'           => 'meta_value_num',
                )
            );
            // The Loop
            if ($popular_query->have_posts()) {
                echo '<div class="tabpopular-post-part">';
                while ($popular_query->have_posts()) {
                    $popular_query->the_post();
                    echo '<div class="tabpopular-post-item bg-light border p-2 mb-1">';
                    echo '<div class="row">';
                    echo '<div class="col-3 pe-0">';
                    if (has_post_thumbnail()) {
                        echo '<img class="border border-3" src="' . wp_get_attachment_thumb_url(get_post_thumbnail_id()) . '" loading="lazy"/>';
                    }
                    echo '</div>';
                    echo '<div class="col">';
                    echo '<a class="fw-bold" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    echo '<div class="text-muted"><small>Posted on: ' . get_the_date() . '</small></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            }
            /* Restore original Post Data */
            wp_reset_postdata();
            ?>
        </div>
        <div class="tab-pane fade" id="berita-tab-comments" role="tabpanel" aria-labelledby="comments-tab" tabindex="0">
            <?php
            // The Query
            $postcomment_query = new WP_Query(
                array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'orderby'           => 'comment_count',
                    'order'             => 'DESC',
                )
            );
            // The Loop
            if ($postcomment_query->have_posts()) {
                echo '<div class="tabpopular-post-part">';
                while ($postcomment_query->have_posts()) {
                    $postcomment_query->the_post();
                    echo '<div class="tabpopular-post-item bg-light border p-2 mb-1">';
                    echo '<div class="row">';
                    echo '<div class="col-3 text-center">';
                    echo '<div class="fst-italic text-muted">';
                    echo '<div class="fw-bold">' . get_comments_number() . '</div>';
                    echo '<small>Komentar</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col">';
                    echo '<a class="fw-bold" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    echo '<div class="text-muted"><small>Posted on: ' . get_the_date() . '</small></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            }
            /* Restore original Post Data */
            wp_reset_postdata();
            ?>
        </div>
        <div class="tab-pane fade" id="berita-tab-tags" role="tabpanel" aria-labelledby="berita-tab" tabindex="0">
            <?php
            $tags = get_tags(array(
                'orderby'   => 'count',
                'order'     => 'DESC',
                'number'    => 8,
            ));
            echo '<div class="tabpost_tags">';
            foreach ($tags as $tag) {
                $tag_link = get_tag_link($tag->term_id);

                echo "<a href='{$tag_link}' title='{$tag->name} Tag' class='btn btn-sm btn-dark me-1 mb-1 bg-color-theme rounded-0'>";
                echo "{$tag->name}</a>";
            }
            echo '</div>';
            ?>
        </div>
    </div>
</aside>