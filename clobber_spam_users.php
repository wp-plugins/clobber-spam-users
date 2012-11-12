<?php
/*
Plugin Name: Clobber spam users
Plugin URI: http://www.tacticaltechnique.com/wordpress/clobber-spam-users/
Description: Easily delete spam post submissions and disable accounts by visiting the Clobber Spam section of your Users menu.
Version: 0.121111
Author: Corey Salzano
Author URI: http://coreysalzano.com/
License: GPL2
*/

	if( !function_exists('get_clobber_users_table_HTML')){
		function get_clobber_users_table_HTML( ){
			//this function is called by the ajax api
			$html = "";
			$html .= "<table class=\"widefat\"><thead><tr><th></th><th>User name</th><th>Email</th><th>Latest post</th></tr></thead><tfoot><tr><th></th><th>User name</th><th>Email</th><th>Latest post</th></tr></tfoot><tbody>";

			global $wpdb;
			$q = "";
			$q .= "SELECT ";
			$q .= "$wpdb->users.ID, ";
			$q .= "$wpdb->posts.ID as post_ID ";
			$q .= "FROM $wpdb->users ";
			$q .= "LEFT JOIN $wpdb->posts ON $wpdb->users.ID = $wpdb->posts.post_author ";
			$q .= "WHERE $wpdb->posts.post_title <> 'Auto Draft' ";
			$q .= "AND $wpdb->posts.post_type = 'post' ";
			//$q .= "AND $wpdb->posts.post_title <> '' ";
			$q .= "ORDER BY post_date DESC LIMIT 30";

			$new_users = $wpdb->get_results( $q );

			$c = 0;
			foreach( $new_users as $found_user ){
				$user = get_user_by( 'id', $found_user->ID );
				if( $user <> $last_user ){
					//output checkbox
					$html .= "<tr>";
					$html .= "<td><input type=\"checkbox\" value=\"". $found_user->ID ."\" id=\"clobber-user-id-" . $found_user->ID . "-" . $c . "\"></td>";
					//user name and post title
					$html .= "<td><label for=\"clobber-user-id-". $found_user->ID ."-" . $c . "\">" . $user->user_login . "</label></td>";
					$html .= "<td><label for=\"clobber-user-id-". $found_user->ID ."-" . $c . "\">" . $user->user_email . "</label></td>";
					$title = get_the_title( $found_user->post_ID );
					if( !$title ){ $title = "[a post saved with no title]"; }
					$html .= "<td><a href=\"" . get_admin_url( NULL, "post.php?post=" . $found_user->post_ID . "&action=edit" ) ."\">" . $title . "</a></td>";
					$html .= "</tr>";
					$c++;
				}
				$last_user = $user;
			}
			$html .= "</tbody></table>";
			echo $html;
			die( );
		}
		if( is_admin()){
			add_action( 'wp_ajax_load_table', 'get_clobber_users_table_HTML' );
		}
	}

	if( !function_exists('add_clobber_spam_users_menu_item') && !function_exists('clobber_admin_page_HTML')){
		function clobber_admin_page_HTML( ){
			//output the admin page where the user interacts with this plugin
			$html = "<div class=\"wrap\" id=\"clobber-users\"><div id=\"icon-users\" class=\"icon32\"></div>";
			$html .= "<h2>Clobber spam users</h2>";
			$html .= "<p>The users listed below are the most recently created accounts on this website that have submitted a new post regardless of its status. Check users that you believe are spam, and click the clobber button to complete the following actions.<ol><li>Delete all posts</li><li>Change password to prevent logins</li><li>Change email address to prevent password recovery</li></ol></p>";
			$html .= "<div id=\"clobber-users-table\"></div>";
			//button to clobber
			$html .= "<p style=\"text-align: right; padding-right: .5em;\"><input class=\"button-primary\" type=\"submit\" name=\"clobberButton\" value=\"". __('Clobber Users') . "\" id=\"clobberButton\" onclick=\"clobber_checked_users( );\" /></p>";
			//javascript function to get all the user ids from the checks
	?>
	<script type="text/javascript">
	<!--
		jQuery(document).ready(function(){
			load_clobber_user_table( );
		});
	//-->
	</script><?php
			$html .= "</div>";
			echo $html;
		}

		function add_clobber_spam_users_menu_item(){
			//add our options page to the admin menu
			add_users_page('Clobber spam users', 'Clobber Spam', 'remove_users', 'clobber_spam_users', 'clobber_admin_page_HTML');
		}
		add_action('admin_menu', 'add_clobber_spam_users_menu_item');
	}

	if( !function_exists('clobber_spam_users')){
		function clobber_spam_users( ){
			//incoming comma-delimited user ids from ajax
			$user_ids = $post_id = $_POST['user_ids'];
			$user_array = explode( ",", $user_ids );
			//take some action on each of these user names
			foreach( $user_array as $user_id ){
				if( $user_id > 0 ){
					//delete all their posts
					$posts = get_posts( array(
						'author' => $user_id,
						'posts_per_page' => -1,
						'post_status' => array( 'publish', 'inherit', 'pending', 'private', 'future', 'draft' )
					));
					foreach( $posts as $post ){
						//echo " post# " . $post->ID . " ";
						$deleted_post = wp_delete_post( $post->ID, true );
					}
					//change their password and email address
					$user = get_user_by( 'id', $user_id );
					$new_user_data = array(
						'user_pass' => 'password123',
						'ID' => $user_id,
						'user_email' => 'username@example.com'
					);
					$updated_user = wp_update_user( $new_user_data );
				}
			}
			die( );
		}
		if( is_admin()){
			add_action( 'wp_ajax_clobber_users', 'clobber_spam_users' );
		}
	}

	if( !function_exists('add_jquery_library_to_admin')){
		function add_jquery_library_to_admin(){
			//make sure jquery is included in the admin dashboard
			if( is_admin( )){
				wp_enqueue_script('jquery');
			}
		}
		add_action('admin_enqueue_scripts', 'add_jquery_library_to_admin');
	}

	if( !function_exists('load_clobber_spam_users_javascript')){
		function load_clobber_spam_users_javascript( ){
			//include our javascript file
			wp_register_script( 'clobber_js', plugins_url( 'clobber-spam-users/clobber_spam_users.js', __DIR__ ));
			wp_enqueue_script( 'clobber_js' );
			//our javascript file needs a path to this directory available to our javascript file
			wp_localize_script( 'clobber_js', 'clobber', array( 'loading_gif_path' => plugins_url( 'clobber-spam-users/loading.gif', __DIR__ )));
		}
		add_action('admin_enqueue_scripts', 'load_clobber_spam_users_javascript');
	}
?>