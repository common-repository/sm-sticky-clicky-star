<?php
/**
 * Plugin Sticky_Clicky_Star
 *
 * @package    WordPress
 * @subpackage Sm_sticky_clicky_star
 */

namespace SM\Sticky_Clicky_Star;

use SM\Sticky_Clicky_Star\Admin;
use WPAZ_Plugin_Base\V_2_6\Abstract_Plugin;

/**
 * Class Plugin
 */
class Plugin extends Abstract_Plugin {

	/**
	 * Use magic constant to tell abstract class current namespace as prefix for all other namespaces in the plugin.
	 *
	 * @var string $autoload_class_prefix magic constant
	 */
	public static $autoload_class_prefix = __NAMESPACE__;

	/**
	 * Action prefix is used to automatically and dynamically assign a prefix to all action hooks.
	 *
	 * @var string
	 */
	public static $action_prefix = 'sm_sticky_clicky_star_';

	/**
	 * Magic constant trick that allows extended classes to pull actual server file location, copy into subclass.
	 *
	 * @var string $current_file
	 */
	protected static $current_file = __FILE__;


	/**
	 * Initialize the plugin - for public (front end)
	 *
	 * @param mixed $instance Parent instance passed through to child.
	 *
	 * @since   0.1
	 * @return  void
	 */
	public function onload( $instance ) {
	}

	/**
	 * Initialize public / shared functionality using new Class(), add_action() or add_filter().
	 */
	public function init() {
		do_action( static::$action_prefix . 'before_init' );

		do_action( static::$action_prefix . 'after_init' );
	}

	/**
	 * Initialize functionality only loaded for logged-in users.
	 */
	public function authenticated_init() {
		if ( is_user_logged_in() ) {
			do_action( static::$action_prefix . 'before_authenticated_init' );
			// Object $this->admin is in the abstract plugin base class.
			$this->admin = new Admin\App(
				$this->installed_dir,
				$this->installed_url,
				$this->version
			);
			do_action( static::$action_prefix . 'after_authenticated_init' );
		}
	}

	/**
	 * Defines and Globals.
	 *
	 * @return mixed|void
	 */
	protected function defines_and_globals() {
	}

	/**
	 * Activate the plugin
	 */
	public static function activate() {
		// get the "admin" role object and add capability.
		$role = get_role( 'administrator' );
		$role->add_cap( 'edit_post_sticky' );
	} // END public static function activate

	/**
	 * Deactivate the plugin
	 */
	public static function deactivate() {
		global $wp_roles;
		foreach ( array_keys( $wp_roles->roles ) as $role ) {
			$wp_roles->remove_cap( $role, 'edit_post_sticky' );
		}
	} // END public static function deactivate

} // END class Plugin
