<?php
// Initiate the admin URL for the ajax request.
add_action('wp_ajax_nopriv_load_more_posts', 'search_posts');
add_action('wp_ajax_load_more_posts', 'search_posts');

function load_more_posts()
{
    $next_page = $_POST['current_page'] + 1;
    $query = new WP_Query([
        'posts_per_page' => $_POST['posts_per_page'],
        'paged' => $next_page
    ]);

    if ($query->have_posts()) :

        ob_start();

        while ($query->have_posts()) : $query->the_post();

            if (file_exists(get_template_directory() . '/template-parts/blog/post.php')) {
                get_template_part('template-parts/blog/post');
            } else {
                get_template_part('blocks/ajax-blogs/post');
            }

        endwhile;

        wp_send_json_success(ob_get_clean());

    else :

        wp_send_json_error('No more posts!');

    endif;
    wp_die();
}
