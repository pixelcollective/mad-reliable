<?php
/*
Plugin Name: &nbsp;😎Mad Reliable
Plugin URI: https://tinypixel.io/projects/mad-reliable
Description: Uptime Robot status page as a Gutenberg block.
Author: Tiny Pixel Collective, Kelly Mears <developers@tinypixel.io>
Version: 1.0.0
Author URI: https://tinypixel.io
*/

namespace TPC\MAD;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

// Autoload
require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/backbone/uptime-robot.php';
require __DIR__ . '/backbone/blocks.php';

define('UPTIME_ROBOT_API_KEY', getenv('UPTIME_ROBOT_API_KEY'));

add_action('admin_init', function() {
  register_setting( 'tpc-settings', 'tpc-mad-cache' ); /* TODO: refactor */
});

$blocks = new Blocks;

/**
 * Create API Routes
 * Consumed by Gutenblock
 *
 */
add_action( 'rest_api_init', function() {
  register_rest_route( 'uptime', 'get', array(
    'methods' => 'GET',
    'callback' => '\TPC\MAD\uptime_api_callback',
  ));
});

function uptime_api_callback() {
  return get_option( 'tpc-mad-cache' );
}

/**
 * Initialize Dynamic Block
 *
 */
add_action('init', function() {
  register_block_type( 'tpc/mad-reliable', array(
    'attributes' => array(
      'uptimeData' => array(
        'type' => 'string',
      ),
    ), 'render_callback' => '\TPC\MAD\render'
  ));
});

/**
 * Render Dynamic Block
 *
 */

function render( $attributes, $content ) {
  $uptimeData = get_option('tpc-mad-cache')['data'];
  $results = '';
  foreach($uptimeData->monitors as $monitor) {
    $results .= sprintf('<tr><td>%1$s</td><td>%2$s</td></tr>',
                  $monitor->friendly_name,
                  $monitor->all_time_uptime_ratio);
  }
  $block_content = sprintf(
    '<div class="wp-block-tpc-mad-reliable">
      <table>
        <tbody>
          <tr>
            <td><strong>Site name</strong></td>
            <td><strong>Uptime ratio</strong></td>
          </tr>
          %1$s
        </tbody>
      </table>
    </div>',
    $results
  );
  return $block_content;
}
