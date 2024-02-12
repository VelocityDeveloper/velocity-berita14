<?php
function module_vdposts($args = null, $style = null)
{

    if (isset($args['sortby'])) {
        if ($args['sortby'] == 'view') {
            $args['orderby']    = 'meta_value_num';
            $args['meta_key']   = 'hit';
        }
        unset($args['sortby']);
    }

    // The Query
    $the_query = new WP_Query($args);

    if ($style == 'gallery' || $style == 'gridpost' || $style == 'gallery1') :
        $row = 'row m-0';
    else :
        $row = '';
    endif;

    // The Loop
    if ($the_query->have_posts()) {
        echo '<div class="' . $row . ' module-vdposts module-vdposts-' . $style . '">';
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $metapost   = get_post_meta(get_the_ID());
            $hit    = get_post_meta(get_the_ID(), 'hit', true);
            if (!empty($hit)) :
                $view    = '<i class="fa fa-eye"></i> ' . $hit . ' views';
            endif;

            switch ($style) {
                case 'posts1':
?>
                    <div class="posts-item pb-1 mb-2">
                        <div class="ratio ratio-16x9 bg-light mb-2 position-relative">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="linkthumbnail">
                                    <a class="text-white" href="<?php echo get_the_permalink(); ?>"><i class="fa-2x fa fa-search"></i></a>
                                </div>
                                <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(), 'medium'); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="post-text">
                            <h6 class="mb-0">
                                <a class="fw-bold d-block" href="<?php echo get_the_permalink(); ?>">
                                    <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                </a>
                            </h6>
                            <div class="py-1">
                                <small>
                                    <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                                    <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                                    <?php echo $view; ?>
                                </small>
                            </div>
                            <div class="post-excerpt mb-2 text-muted">
                                <?php echo vdberita_limit_text(strip_tags(get_the_content()), 17); ?>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts2':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="ratio ratio-1x1 bg-light">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="linkthumbnail">
                                            <a class="text-white" href="<?php echo get_the_permalink(); ?>"><i class="fa-2x fa fa-search"></i></a>
                                        </div>
                                        <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <h6>
                                    <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                        <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                    </a>
                                </h6>
                                <div class="post-date">
                                    <small>
                                        <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                                        <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                                        <?php echo $view; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts3':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="ratio ratio-1x1 bg-light">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="linkthumbnail">
                                            <a class="text-white" href="<?php echo get_the_permalink(); ?>"><i class="fa-2x fa fa-search"></i></a>
                                        </div>
                                        <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <h6>
                                    <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                        <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                    </a>
                                </h6>
                                <div class="post-date">
                                    <small>
                                        <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                                        <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                                        <?php echo $view; ?>
                                    </small>
                                </div>
                                <div class="post-excerpt text-muted">
                                    <small>
                                        <?php echo vdberita_limit_text(strip_tags(get_the_content()), 5); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts4':
                    echo '<a class="d-flex w-100 border-bottom pb-1 mb-1" href="' . get_the_permalink() . '">';
                    echo '<i class="fa fa-file-text-o mt-1 me-2"></i>';
                    echo '<span>' . get_the_title() . '</span>';
                    echo '</a>';
                ?>
                <?php
                    break;
                case 'posts5':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <h6>
                            <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                            </a>
                        </h6>
                        <div class="post-date">
                            <small>
                                <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                                <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                                <?php echo $view; ?>
                            </small>
                        </div>
                    </div>
                <?php
                    break;
                case 'carousel':
                ?>
                    <div class="carousel-post-item px-1">
                        <a href="<?php echo get_the_permalink(); ?>">
                            <div class="position-relative">
                                <div class="ratio ratio-4x3 bg-light">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img data-flickity-lazyload="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                    <?php endif; ?>
                                </div>
                                <div class="post-text position-absolute text-center w-100 left-0 bottom-0 p-2 bg-color-theme">
                                    <h6>
                                        <a class="text-white fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                            <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                    break;
                case 'gridpost': ?>
                    <div class="posts-item col-6 p-1">
                        <div class="position-relative">
                            <div class="ratio ratio-16x9 bg-light">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                <?php endif; ?>
                            </div>
                            <div class="post-text position-absolute w-100 text-center bottom-0 left-0 p-2 bg-color-theme">
                                <h6>
                                    <a class="text-white fw-bold" href="<?php echo get_the_permalink(); ?>">
                                        <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'homespecial':
                ?>
                    <div class="posts-item home-special p-2 shadow mb-2 position-relative">
                        <div class="ratio ratio-16x9 bg-light mb-2">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="linkthumbnail">
                                    <a class="text-white" href="<?php echo get_the_permalink(); ?>"><i class="fa-2x fa fa-search"></i></a>
                                </div>
                                <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="post-text text-white">
                            <h6>
                                <a class="fw-bold text-white d-block h6" href="<?php echo get_the_permalink(); ?>">
                                    <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                </a>
                            </h6>
                            <div class="py-2 px-1 text-white">
                                <small>
                                    <i class="fa fa-user-o"></i> <?php echo get_the_author(); ?>
                                    <i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?>
                                    <?php echo $view; ?>
                                </small>
                            </div>
                            <div class="konten">
                                <small>
                                    <?php echo vdberita_limit_text(strip_tags(get_the_content()), 25); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'gallery':
                ?>
                    <div class="col-md-3 col-6 posts-item gallery-post p-1 overflow-hidden">
                        <div class="position-relative  p-1">
                            <div class="ratio ratio-4x3 bg-light">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a class="text-white" href="<?php echo get_the_permalink(); ?>">
                                        <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="position-absolute post-text text-center p-2 text-white bg-light">
                                <h6 class="judul-post">
                                    <a class="text-dark d-block" href="<?php echo get_the_permalink(); ?>">
                                        <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'gallery1':
                ?>
                    <div class="col-6 posts-item gallery-post p-1 overflow-hidden">
                        <div class="position-relative  p-1">
                            <div class="ratio ratio-1x1 bg-light">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a class="text-white" href="<?php echo get_the_permalink(); ?>">
                                        <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="position-absolute post-text text-center p-2 text-white bg-color-theme">
                                <h6 class="judul-post">
                                    <a class="text-dark d-block" href="<?php echo get_the_permalink(); ?>">
                                        <?php echo vdberita_limit_text(get_the_title(), 5); ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
<?php
                    break;
                default:
                    echo '<div class="posts-item border-bottom pb-1 mb-2">';
                    echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    echo '</div>';
                    break;
            }
        }
        echo '</div>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}
