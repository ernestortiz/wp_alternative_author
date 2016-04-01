<?php 
/*
Plugin Name: Alternative Author
Plugin URI: https://github.com/ernestortiz/wp_alternative_author/
Description: This is a simple way of consider an alternative post author (without creating a wordpress user as author).
Author: Ernesto Ortiz
Version: 1.0
Author URI: https://github.com/ernestortiz
*/


/*** add metabox ***/
function add_alterauthor_metabox() {
	add_meta_box('alterauthor_mbox', __('Alternative Author'), 'show_alterauthor_mbox', 'post', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_alterauthor_metabox');

/*** draw metabox ***/
function show_alterauthor_mbox($post) {
	?>
	<div class="option-item" id="alter-mbox-item">
		<label><?php echo __('Alternative Author\'s Full Name');?>:</label>
		<input type="text" name="altername" id="altername" value="<?php echo get_post_meta($post->ID, 'altername', true)?>" /><br/>
		<label><?php echo __('Alternative Author\'s Link');?>:</label>
		<input type="text" name="alterlnk" id="alterlnk" value="<?php echo get_post_meta($post->ID, 'alterlnk', true)?>" /><br/>
		<label><?php echo __('Alternative Author\'s Data');?>:</label><br/>
		<textarea name="alterdata" id="alterdata"><?php echo get_post_meta($post->ID, 'alterdata', true)?></textarea><br/>
		<input type="hidden" name="alterauthor_mbox_nonce" value="<?php echo wp_create_nonce('alterauthor_mbox');?>" />
	</div>
  <?php
}
/*** save metabox data ***/
function save_alterauthor_mbox($post_id) {
	// check nonce
  	if (!isset($_POST['alterauthor_mbox_nonce']) || !wp_verify_nonce($_POST['alterauthor_mbox_nonce'], 'alterauthor_mbox')) return $post_id;
  	// check capabilities
  	if ('post' == $_POST['post_type']) {
    		if (!current_user_can('edit_post', $post_id)) return $post_id;
  	} elseif (!current_user_can('edit_page', $post_id)) {
		 return $post_id;
  	}
  	// exit on autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
  	//
  	if(isset($_POST['altername']))
		update_post_meta($post_id, 'altername', $_POST['altername']);
  	else
    		delete_post_meta($post_id, 'altername');
	if(isset($_POST['alterdata']))
    		update_post_meta($post_id, 'alterdata', $_POST['alterdata']);
	else
    		delete_post_meta($post_id, 'alterdata');
	if (isset($_POST['alterlnk']))
    		update_post_meta($post_id, 'alterlnk', $_POST['alterlnk']);
  	else
    		delete_post_meta($post_id, 'alterlnk');
}
add_action('save_post', 'save_alterauthor_mbox');

/*** draw alternative_author ***/
add_filter( 'the_author', 'filter_alterauthor_name' );
function filter_alterauthor_name($the_author){
	return has_alter_author('altername', $the_author);
}
//
add_filter( 'author_link', 'filter_alterauthor_link');
function filter_alterauthor_link($the_link){
	return has_alter_author('alterlnk', $the_link);
}
//
add_filter('get_the_author_description', 'filter_alterauthor_descr' );
function filter_alterauthor_descr($the_descr){
	return has_alter_author('alterdata', $the_descr);
}

/*** functions ***/
function has_alter_author($get = 'altername', $default = ''){
	global $post;
	$get_meta = get_post_custom($post->ID);
	$altername = trim($get_meta['altername'][0]);
	$return = trim($get_meta[$get][0]);
	if (!empty($altername))
		return $return;
	else return $default;
}
?>
