<div class="first-head-part bg-color-theme">
    <div class="container bg-transparent py-1">
        <div class="row m-0 align-items-center">
            <div class="col-md-3 col-12 p-0 d-flex align-items-center">
                <?php
                $sosmed = ['facebook', 'twitter', 'instagram', 'youtube'];
                foreach ($sosmed as $key) {
                    $datalink  = velocitytheme_option('link_sosmed_' . $key);
                    if ($datalink) {
                        echo '<a class="btn btn-sm btn-' . $key . ' ms-1 text-white" href="' . $datalink . '" target="_blank"><i class="fa fa-' . $key . '"></i></a>';
                    }
                }
                ?>
            </div>
            <div class="col-md-9 p-0 d-md-block d-none">
                <nav id="main-nav" class="navbar navbar-expand-md d-block navbar-light p-0" aria-labelledby="main-nav-label">
                    <div class="secondary-menu position-relative">
                        <div class="" tabindex="-1" id="navbarsecondarymenu">
                            <!-- The WordPress Menu goes here -->
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location'  => 'secondary',
                                    'container_class' => 'secondary-menu-body',
                                    'container_id'    => '',
                                    'menu_class'      => 'navbar-nav justify-content-end flex-grow-1 px-2',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'secondary-menu',
                                    'depth'           => 1,
                                    'walker'          => new justg_WP_Bootstrap_Navwalker(),
                                )
                            );
                            ?>
                        </div><!-- .offcanvas -->
                    </div>
                </nav>
            </div>
        </div>
    </div>

</div>

<div class="head-part-top bg-light">
    <div class="container bg-transparent">
        <div class="row m-0 py-2 align-items-center">
            <div class="col-md-3">
                <div class="text-md-start text-center p-1">
                    <?php echo the_custom_logo(); ?>
                </div>
            </div>
            <div class="col-md">
                <?php echo get_berita_iklan('iklan_header'); ?>
            </div>
        </div>
    </div>
</div>

<div class="velocity-navbar bg-dark">
    <div class="container bg-transparent">
        <nav id="main-nav" class="navbar navbar-expand-md d-block navbar-dark shadow-sm p-0" aria-labelledby="main-nav-label">

            <h2 id="main-nav-label" class="screen-reader-text">
                <?php esc_html_e('Main Navigation', 'justg'); ?>
            </h2>

            <div class="head-part-menu navbar-dark">
                <div class="menu-header">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                        <span class="navbar-toggler-icon"></span>
                        <small>Menu</small>
                    </button>

                    <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="navbarNavOffcanvas">

                        <div class="offcanvas-header justify-content-end">
                            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div><!-- .offcancas-header -->

                        <!-- The WordPress Menu goes here -->
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'primary',
                                'container_class' => 'offcanvas-body',
                                'container_id'    => '',
                                'menu_class'      => 'navbar-nav justify-content-start flex-grow-1 pe-3',
                                'fallback_cb'     => '',
                                'menu_id'         => 'main-menu',
                                'depth'           => 4,
                                'walker'          => new justg_WP_Bootstrap_Navwalker(),
                            )
                        );
                        ?>
                    </div><!-- .offcanvas -->
                </div>
            </div>

        </nav><!-- .site-navigation -->
    </div>
</div>