<?php

//Enqueue assets for Metablock Settings plugin
add_action('enqueue_block_editor_assets', function () {
    $handle = 'settings';
    $assets = include dirname(__FILE__, 3). "/build/block-$handle.asset.php";
    $dependencies = $assets['dependencies'];
    wp_enqueue_script(
        $handle,
        plugins_url("/build/block-$handle.js", dirname(__FILE__, 2)),
        $dependencies,
        $assets['version']
    );
});

//Register meta fields for plugin
add_action( 'init', function() {
    register_meta( 'post', 'something', [
        'sidebar' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'default' => 16,
    ] );
} );
