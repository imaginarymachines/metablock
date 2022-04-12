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
            },

        ]);
    }
});

/**
 * When saving a post, save the metablock field
 *
 * @see: https://developer.wordpress.org/reference/hooks/field_no_prefix_save_pre/
 */
add_action('rest_insert_post', function($post){
    //No blocks? Return early
    if( ! has_blocks($post->post_content) ){
        return;
    }
    $block_name = 'joshmetablock/metablock';
    $blocks = parse_blocks($post->post_content);
    //Find out block
    foreach ($blocks as $block) {
        if( $block['blockName'] === $block_name ){
            //Get field name and value
            $field_name = isset( $block['attrs']['field_name'])? $block['attrs']['field_name'] : null;
            $value = isset($block['attrs']['field_value']) ? $block['attrs']['field_value'] : null;
            if( ! $field_name || ! $value ){
                continue;
            }
            update_post_meta($post->ID, $field_name, $value);
        }
    }

});
