<?php
/*
Plugin Name: Offers
Plugin URI: //Not yet developed
Description: This is not the same as the Store plugin. The Store plugin would be used for an online store; this plugin is used for creating a "classifieds" site.
Version: alpha
Author: Star Verte LLC
Author URI: http://www.starverte.com
License: GPL2 or later

  Copyright 2012  Star Verte LLC  (email : info@starverte.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function sparks_offers_init() {
  $labels = array(
    'name' => 'Offers',
    'singular_name' => 'Offer',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Offer',
    'edit_item' => 'Edit Offer',
    'new_item' => 'New Offer',
    'all_items' => 'All Offers',
    'view_item' => 'View Offers',
    'search_items' => 'Search Offers',
    'not_found' =>  'No offers found',
    'not_found_in_trash' => 'No offers found in Trash. Did you check recycling?', 
    'parent_item_colon' => '',
    'menu_name' => 'Offers'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'offers' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
  ); 

  register_post_type( 'sp_offer', $args );
}
add_action( 'init', 'sparks_offers_init' );

//add filter to ensure the text Item, or item, is displayed when user updates an item in the Store 

function codex_sp_offer_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['sp_offer'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Offer updated. <a href="%s">View offer</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Offer updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Offer restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Offer published. <a href="%s">View offer</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Item saved.'),
    8 => sprintf( __('Offer submitted. <a target="_blank" href="%s">Preview offer</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Offer scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview offer</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Offer draft updated. <a target="_blank" href="%s">Preview offer</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'codex_sp_offer_updated_messages' );
?>
