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
 * Finds all instnace of our block and calls $callback on each
 *
 *
 */
function joshmetablock_handler($post,$callback){
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
            //no value? don't update
            if( ! $field_name || ! $value ){
                continue;
            }else{
                $callback($post,$field_name,$value);
            }

        }
    }

}

/**
 * Before the block editor pre-loads its data, register meta fields
 */
add_filter('block_editor_rest_api_preload_paths',function( $preload_paths, $block_editor_context){
    //Use handler to find all metablock blocks
    joshmetablock_handler($block_editor_context->post,function($post,$field_name,$value){
        //Register the field for the found block
        register_meta($post->post_type, $field_name, [
            'type' => 'string',//change to integer if is_int($value) ?
            'single' => true,
            'show_in_rest' => true,
        ] );
    });
    //Return the preload paths unchanged
    return $preload_paths;
}, 10, 2 );


/**
 * When saving a post, save the metablock field
 *
 * @see: https://developer.wordpress.org/reference/hooks/field_no_prefix_save_pre/
 */
add_action('rest_insert_post', function($post){
    //Find blocks using handler
    joshmetablock_handler($post,function($post,$field_name,$value){
        //Update the field value when found
        update_post_meta($post->ID, $field_name, $value);
    });
});
