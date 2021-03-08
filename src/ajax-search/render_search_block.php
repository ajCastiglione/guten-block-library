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
    'mwd/ajax-search',
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

    ob_start(); ?>

    <div class="mwd-posts-block posts">

        <?php foreach ($posts as $post) { ?>
            <div class="<?= esc_attr(implode(' ', get_post_class('', $post->ID))) ?> ">
                <a href="<?= get_permalink($post->ID) ?>">
                    <h2><?= $post->post_title ?> </h2>
                    <div><?= get_the_category_list(', ', '', $post->ID) ?> </div>
                    <?= get_the_post_thumbnail($post->ID); ?>
                    <p><?= $post->post_excerpt ?> </p>
                </a>
            </div>
    <?php
        }
        echo "</div>";
        return ob_get_clean();
    }
