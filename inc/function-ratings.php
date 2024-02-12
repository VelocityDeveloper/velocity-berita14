<?php
// Fungsi untuk membuat tabel kustom saat mengaktifkan tema atau plugin
add_action('after_setup_theme', 'create_ratings_table');
function create_ratings_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ratings';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        post_id INT NOT NULL,
        rating INT NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Fungsi untuk menampilkan rating dalam bentuk HTML
function display_post_rating($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ratings';
    $sql = "SELECT * FROM $table_name WHERE post_id = $post_id";
    $results = $wpdb->get_results($sql);
    $count = count($results);

    if ($results) {
        // echo '<pre>' . print_r($results, 1) . '</pre>';
        // Loop through each row
        $rating = 0;
        foreach ($results as $result) {
            // Access data for each row
            $rating += $result->rating;
            $post_id = $result->post_id;
        }

        $realrate   = $rating / $count;
        $output = '<div class="post-rating">';
        $output .= '<span class="rating-value pe-1">Rate [' . round($realrate, 2) . '/' . $count . ']</span>';
        $output .= '<span class="rating-stars">';

        for ($i = 5; $i >= 1; $i--) {
            if ($realrate >= $i) {
                $output .= '<i class="fa fa-star text-warning"></i>'; // Menggunakan ikon bintang (misalnya Font Awesome) atau kode HTML yang sesuai
            } else {
                $output .= '<i class="fa fa-star-o"></i>'; // Menggunakan ikon bintang kosong (misalnya Font Awesome) atau kode HTML yang sesuai
            }
        }

        $output .= '</span>';
        $output .= '</div>';
    } else {
        $output .= '<div class="post-rating">';
        $output .= '<span class="rating-value pe-1">Rate [0]</span>';
        $output .= '<span class="rating-stars">';

        for ($i = 5; $i >= 1; $i--) {
            if ($realrate >= $i) {
                $output .= '<i class="fa fa-star text-warning"></i>'; // Menggunakan ikon bintang (misalnya Font Awesome) atau kode HTML yang sesuai
            } else {
                $output .= '<i class="fa fa-star-o"></i>'; // Menggunakan ikon bintang kosong (misalnya Font Awesome) atau kode HTML yang sesuai
            }
        }

        $output .= '</span>';
        $output .= '</div>';
    }
    echo $output;
}
// [review_form]
add_shortcode('review_form', 'review_form_shortcode');
function review_form_shortcode()
{
    ob_start();
?>
    <div id="review-form">
        <div class="rating pt-2">
            <input type="radio" id="star5" name="rating" value="5" onclick="submitReview(this.value)" /><label for="star5"><i class="fa fa-star"></i></label>
            <input type="radio" id="star4" name="rating" value="4" onclick="submitReview(this.value)" /><label for="star4"><i class="fa fa-star"></i></label>
            <input type="radio" id="star3" name="rating" value="3" onclick="submitReview(this.value)" /><label for="star3"><i class="fa fa-star"></i></label>
            <input type="radio" id="star2" name="rating" value="2" onclick="submitReview(this.value)" /><label for="star2"><i class="fa fa-star"></i></label>
            <input type="radio" id="star1" name="rating" value="1" onclick="submitReview(this.value)" /><label for="star1"><i class="fa fa-star"></i></label>
        </div>
    </div>
    <script>
        function submitReview(rating) {
            if (rating) {
                var postId = <?php echo get_the_ID(); ?>; // Mendapatkan ID post yang sedang ditampilkan

                // Mengirim data ke server menggunakan AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Review submitted successfully with rating: ' + rating);
                    } else {
                        console.log('Failed to submit review. Please try again.');
                    }
                };
                xhr.send('action=submit_review&post_id=' + postId + '&rating=' + rating);
                location.reload();
            } else {
                console.log('Please provide both rating and review content.');
            }
        }
    </script>
<?php

    return ob_get_clean();
}

// Fungsi untuk menyimpan ulasan yang dikirimkan melalui AJAX
add_action('wp_ajax_submit_review', 'submit_review');
add_action('wp_ajax_nopriv_submit_review', 'submit_review');
function submit_review()
{
    if (isset($_POST['post_id'], $_POST['rating'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ratings';

        $post_id = intval($_POST['post_id']);
        $rating = intval($_POST['rating']);

        // Tambahkan rating baru
        $wpdb->insert(
            $table_name,
            ['post_id' => $post_id, 'rating' => $rating],
            ['%d', '%d']
        );

        wp_die(); // Menghentikan eksekusi setelah memproses AJAX
    }
}
