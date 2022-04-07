<?php

/**
 * Register metablock block
 */
add_action('init', function () {
    if( file_exists(dirname(__FILE__, 3). "/build/block-metablock.asset.php") ) {
        register_block_type_from_metadata(__DIR__,[
            'render_callback' => function ($attributes, $content) {
                $field_name = isset($attributes['field_name']) ? $attributes['field_name'] : null;
                if( ! $field_name ) {
                    return '';
                }
                $value = get_post_meta(get_post()->ID, $field_name, true);
                if( ! $value ) {
                    return '';
                }elseif (is_array($value)) {
                    $value = implode(', ', $value);
                }
                return sprintf('<p>%s</p>', esc_html($value));
            }
        ]);
    }
});
