<?php

/**
 * WIDGET TABS BERITA 14
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Tabs_Berita_14_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'tabs_berita_14_widget',
            __('Tabs Berita 14', 'velocity'),
            array('description' => __('Menampilkan tabs template berita 14', 'velocity'),)
        );
    }

    public function form($instance)
    {
        $title      = !empty($instance['title']) ? $instance['title'] : '';
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Judul:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

        return $instance;
    }
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        ?>

        <ul class="nav nav-tabs p-0 border-0" id="beritaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link border rounded-0 bg-light active" id="popular-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-popular" type="button" role="tab" aria-controls="berita-tab-popular" aria-selected="true">
                    Popular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border rounded-0 bg-light" id="comments-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-comments" type="button" role="tab" aria-controls="berita-tab-comments" aria-selected="false">
                    Comments
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border rounded-0 bg-light" id="tags-tab" data-bs-toggle="tab" data-bs-target="#berita-tab-tags" type="button" role="tab" aria-controls="berita-tab-tags" aria-selected="false">
                    Tags
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

<?php

        echo $args['after_widget'];
    }
}

function register_tabs_berita_14_widget()
{
    register_widget('Tabs_Berita_14_Widget');
}
add_action('widgets_init', 'register_tabs_berita_14_widget');
