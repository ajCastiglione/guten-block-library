<?php

/**
 * Register Gutenberg block on server-side.
 *
 * Register the block on server-side to ensure that the block
 * scripts and styles for both frontend and backend are
 * enqueued when the editor loads.
 *
 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
 * @since 1.16.0
 */
register_block_type(
    'mwd/posts',
    array(
        // Enqueue blocks.style.build.css on both frontend & backend.
        'style'         => 'custom_blocks-cgb-style-css',
        // Enqueue blocks.build.js in the editor only.
        'editor_script' => 'custom_blocks-cgb-block-js',
        // Enqueue blocks.editor.build.css in the editor only.
        'editor_style'  => 'custom_blocks-cgb-block-editor-css',
        'render_callback' => 'render_posts_block'
    )
);

function render_posts_block($attributes)
{
    $posts = get_posts([
        'category' => $attributes['selectedCategory'],
        'posts_per_page' => $attributes['postsPerPage'],
    ]);

    ob_start();
    foreach ($posts as $post) {
        echo "<div class='" . esc_attr(implode(' ', get_post_class('', $post->ID))) . "'>";
        echo "<h2>" . $post->post_title . "</h2>";
        echo get_the_post_thumbnail($post->ID);
        echo "<p>" . $post->post_excerpt . "</p>";
        echo "</div>";
        echo "<hr>";
    }

    return ob_get_clean();
}
