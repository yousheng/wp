<?php
/*
Plugin Name: Remove admin menus by roles
Plugin URI: 
Version: 1.01
Description: Remove admin menus by roles
Author: Manu225
Author URI: 
Network: false
Text Domain: remove-admin-menus-by-roles
Domain Path: 
*/

register_activation_hook( __FILE__, 'remove_menu_admin_install' );
register_uninstall_hook(__FILE__, 'remove_menu_admin_desinstall');

function remove_menu_admin_install() {

	global $wpdb;

	$remove_menu_admin_table = $wpdb->prefix . "remove_menu_admin_profiles";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$sql = "
        CREATE TABLE `".$remove_menu_admin_table."` (
          id int(11) NOT NULL AUTO_INCREMENT,          
          name varchar(50) NOT NULL,
          roles varchar(500) NOT NULL,
          menus_hidden varchar(5000) NOT NULL,
          submenus_hidden varchar(5000) NOT NULL,
          active int(1),
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    dbDelta($sql);
}

function remove_menu_admin_desinstall() {

	global $wpdb;

	$remove_menu_admin_table = $wpdb->prefix . "remove_menu_admin_profiles";

	//suppression des tables
	$sql = "DROP TABLE ".$remove_menu_admin_table.";";
	$wpdb->query($sql);
}

add_action( 'admin_menu', 'register_remove_menu_admin' );

function register_remove_menu_admin() {

	add_menu_page('Remove admin menus by role', 'Remove admin menus by role', 'manage_options', 'remove_menu_admin', 'remove_menu_admin',   '', 36);

}

add_action('admin_print_styles', 'remove_menu_admin_css' );
function remove_menu_admin_css() {
    wp_enqueue_style( 'RemoveMenuAdminStylesheet', plugins_url('css/admin.css', __FILE__) );
}

function remove_menu_admin() {

	if (is_admin()) {

		global $menu;
		global $submenu;
		global $wpdb;

		$remove_menu_admin_table = $wpdb->prefix . "remove_menu_admin_profiles";

		if(sizeof($_POST) > 0) //mise à jour du profil
		{

			check_admin_referer( 'rambr' );

			foreach($_POST['roles'] as $key => $value)
				$_POST['roles'][$key] = sanitize_text_field($_POST['roles'][$key]);

			foreach($_POST['menus_hidden'] as $key => $value)
				$_POST['menus_hidden'][$key] = sanitize_text_field($_POST['menus_hidden'][$key]);

			foreach($_POST['submenus_hidden'] as $key => $value)
				$_POST['submenus_hidden'][$key] = sanitize_text_field($_POST['submenus_hidden'][$key]);

			if(!is_numeric($_POST['active']))
				$_POST['active'] = 1;

			$query = "REPLACE INTO ".$remove_menu_admin_table." (`id`, `name`, `roles`, `menus_hidden`, `submenus_hidden`, `active`)
			VALUES (1, 'Profil', %s, %s, %s, %d)";
			$query = $wpdb->prepare( $query, serialize($_POST['roles']), serialize($_POST['menus_hidden']), serialize($_POST['submenus_hidden']), $_POST['active']);
			$wpdb->query($query);

			$roles_selected = $_POST['roles'];
			$menus_hidden = $_POST['menus_hidden'];
			$submenus_hidden = $_POST['submenus_hidden'];

		}
		else
		{
			$profile = get_remove_menu_admin_profile();
			//print_r($profile);
			if($profile)
			{
				$roles_selected = unserialize($profile->roles);
				$menus_hidden = unserialize($profile->menus_hidden);
				$submenus_hidden = unserialize($profile->submenus_hidden);
			}
			else
			{
				$roles_selected = array();
				$menus_hidden = array();
				$submenus_hidden = array();
			}
		}

		if(!is_array($roles_selected))
			$roles_selected = array();
		if(!is_array($menus_hidden))
			$menus_hidden = array();
		if(!is_array($submenus_hidden))
			$submenus_hidden = array();

		include(plugin_dir_path( __FILE__ ) . 'views/form.php');

	}

}

add_action( 'admin_init', 'remove_menus_by_roles' );
function remove_menus_by_roles() {

	//on récupère la configuration du profil
	$profile = get_remove_menu_admin_profile();

	if($profile)
	{
			$roles_selected = unserialize($profile->roles);
			$menus_hidden = unserialize($profile->menus_hidden);
			$submenus_hidden = unserialize($profile->submenus_hidden);

			global $current_user;
            $user_role = $current_user->roles[0];

            //si l'utilisateur connecté à un des roles sélectionnés
            if(in_array($user_role, $roles_selected))
            {
            	//on supprime les menus choisis
            	if(sizeof($menus_hidden) > 0)
            	{
	            	foreach($menus_hidden as $menu)
	            		remove_menu_page($menu);
	            }

            	if(sizeof($submenus_hidden) > 0)
            	{
            		foreach($submenus_hidden as $submenu)
	            	{
	            		$data = explode('|', $submenu); //$submenu = menu|submenu
						remove_submenu_page( $data[0], $data[1] );
					}
				}
			}
	}
	
}

function get_remove_menu_admin_profile($id=1)
{
	global $wpdb;

	$remove_menu_admin_table = $wpdb->prefix . "remove_menu_admin_profiles";

	$query = "SELECT roles, menus_hidden, submenus_hidden FROM ".$remove_menu_admin_table." WHERE id=%d";
	$query = $wpdb->prepare($query, $id);
	return $wpdb->get_row($query);
}

?>