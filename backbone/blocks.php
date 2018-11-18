<?php

namespace TPC\MAD;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blocks extends Uptime {

  function __construct() {
    $this->enqueue_assets();
    $this->enqueue_editor_assets();
  }

  function enqueue_assets() {
    add_action( 'enqueue_block_assets', function() {
      wp_enqueue_style(
        'mad_reliable-cgb-style-css', // Handle.
        plugins_url( '/dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
        array( 'wp-blocks' ) // Dependency to include the CSS after it.
        // filemtime( plugin_dir_path( __DIR__ ) . '../dist/blocks.style.build.css' ) // Version: filemtime — Gets file modification time.
      );
    });
  }

  function enqueue_editor_assets() {
    add_action( 'enqueue_block_editor_assets', function() {
      wp_enqueue_script(
        'mad_reliable-cgb-block-js', // Handle.
        plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
        array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
        // filemtime( plugin_dir_path( __DIR__ ) . '../dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
        true // Enqueue the script in the footer.
      );

      wp_enqueue_style(
        'mad_reliable-cgb-block-editor-css', // Handle.
        plugins_url( '/dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
        array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
        // filemtime( plugin_dir_path( __DIR__ ) . '../dist/blocks.editor.build.css' ) // Version: filemtime — Gets file modification time.
      );
    });
  }
}