<?php

/**
 * Check whether this class exists or not
 */
if ( ! class_exists( 'Read_Only_Admin_Plugin' ) ) {
    
    /**
     * This is the class that calls all the methods for
     * read only admin plugin.
     */
    class Read_Only_Admin_Plugin {

        /**
         * Class Constructor
         */
        function __construct() {
            add_action( 'init', array( $this, 'activate' ) );
            add_action( 'pre_get_posts', array( $this, 'deny_trash_access_to_read_only_admin_user' ) );
            add_action( 'admin_init', array( $this, 'stop_submit' ) );
            add_action( 'admin_init', array( $this, 'remove_all_things' ) );
            add_action( 'admin_menu', array( $this, 'add_error404_page' ) );
            add_action( 'user_new_form', array( $this, 'add_checkbox_on_add_new_user_page' ) );
            add_action( 'show_user_profile', array( $this, 'add_checkbox_on_add_new_user_page' ) );
            add_action( 'edit_user_profile', array( $this, 'add_checkbox_on_add_new_user_page' ) );
            add_action( 'user_register', array( $this, 'save_new_field_from_add_new_user_page' ) );
            add_action( 'personal_options_update', array( $this, 'save_new_field_from_add_new_user_page' ) );
            add_action( 'edit_user_profile_update', array( $this, 'save_new_field_from_add_new_user_page' ) );
        }
    
        /**
         * Plugin Activation Method
         *
         * @return void
         */
        function activate() {
            $this->get_current_user_ID();
        }
    
        /**
         * This function gets the current user role.
         *
         * @return void
         */
        function get_role() {
            if( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                $role = $current_user->roles;
                return $role[0];
            }
        }
    
        /**
         * This function gets the current user id.
         *
         * @return void
         */
        function get_current_user_ID() {
            $user_ID = get_current_user_id();
            return $user_ID;
        }
    
        /**
         * This function gets all registered post type
         *
         * @return void
         */
        function get_all_post_types() {
            $output = 'names';
            $operator = 'and';
            $post_types = get_post_types( '', $output, $operator );
            $all_post = array();
            foreach ( $post_types  as $post_type ) {
                $all_post[] = $post_type;
            }
            return $all_post;
        }
    
        /**
         * This function checks whether meta key == read_only_admin or not 
         * and remove all the desired things that needs to be remove.
         *
         * @return void
         */
        function remove_all_things() {
            $all_post = $this->get_all_post_types();
            $size = sizeof( $all_post );
            $user_ID = $this->get_current_user_ID();
            $meta_key = get_user_meta( $user_ID, 'read_only_admin', true );
            $current_role = $this->get_role();
            
            if ( $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                $this->enqueue_custom_style();
                $this->remove_row_actions();
                $this->conditional_redirect_post_new();
                $this->remove_pages_from_admin_screen();
                for( $i = 0; $i < $size; $i++ ) {
                    $this->remove_submit_div_from_post( $all_post[$i] );
                    $this->remove_add_new_page_from_post_type( $all_post[$i] );
                    $this->remove_bulk_edit_options( $all_post[$i] );
                }
            }
        }
    
        /**
         * This function access denies to trash link
         * only to read only admin user.
         *
         * @param [type] $query
         * @return void
         */
        function deny_trash_access_to_read_only_admin_user( $query ) {
            $user_ID = $this->get_current_user_ID();
            $meta_key = get_user_meta( $user_ID, 'read_only_admin', true );
            $current_role = $this->get_role();
            if ( $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {

                $status = $query->get( 'post_status' );
                if ( $status === 'trash' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
                    exit();
                }
            }
        }

        /**
         * This function remove the access to create new post for all 
         * post type
         *
         * @return void
         */
        function conditional_redirect_post_new() {
            global $pagenow;
            $user_ID = $this->get_current_user_ID();
            $meta_key = get_user_meta( $user_ID, 'read_only_admin', true );
            $current_role = $this->get_role();
           
            if( !empty( $pagenow )
                && 'post-new.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow )
                && 'media-new.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow )
                && 'options-general.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow )
                && 'theme-editor.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow )
                && 'widgets.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow )
                && 'user-new.php' == $pagenow
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow ) 
                && 'plugin-install.php' == $pagenow 
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( !empty( $pagenow ) 
                && 'plugin-editor.php' == $pagenow 
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
            }
            if( 'activate' == $_GET['action'] 
                && !empty( $pagenow ) 
                && 'themes.php' == $pagenow  
                && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin') {
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
                    exit();
            }
        }

        /**
         * This function removes custom post type pages from admin screen.
         *
         * @return void
         */
        function remove_add_new_page_from_post_type( $all_post ) {
            remove_submenu_page( 'edit.php?post_type='.$all_post, 'post-new.php?post_type='.$all_post );
        }

        /**
         * This function removes following pages from admin screen
         *
         * @return void
         */
        function remove_pages_from_admin_screen(){
            remove_menu_page( 'options-general.php' );
            remove_submenu_page( 'edit.php', 'post-new.php');
            remove_submenu_page( 'upload.php', 'media-new.php');
            remove_submenu_page( 'users.php', 'user-new.php');
            remove_submenu_page( 'themes.php', 'theme-editor.php');
            remove_submenu_page( 'plugins.php', 'plugin-install.php');
            remove_submenu_page( 'plugins.php', 'plugin-editor.php');
        }
    
        /**
         * This function removes the submit div from all the post types
         *
         * @param [type] $all_post
         * @return void
         */
        function remove_submit_div_from_post( $all_post ) {
            remove_meta_box( 'submitdiv', $all_post, 'side' );
        }
    
        /**
         * This function enqueues our custom style
         *
         * @return void
         */
        function enqueue_custom_style() {
            wp_enqueue_style( 'custom-style', plugins_url('../assets/css/style.css', __FILE__ ) );
        }
    
        /**
         * This functions removes all the bulk edit options from all post types
         * and admin pages.
         *
         * @param [type] $all_post
         * @return void
         */
        function remove_bulk_edit_options( $all_post ) {
            global $actions;
            add_filter( 'bulk_actions-edit-post', '__return_empty_array' );
            add_filter( 'bulk_actions-edit-comments', '__return_empty_array' );
            add_filter( 'bulk_actions-users', '__return_empty_array' );
            add_filter( 'bulk_actions-plugins', '__return_empty_array' );
            add_filter( 'bulk_actions-upload', '__return_empty_array' );
            add_filter( 'bulk_actions-edit-'.$all_post, '__return_empty_array' );
            add_filter( 'bulk_actions-'.$all_post, '__return_empty_array' );
        }
    
        /**
         * This function removes all the row action from all post types
         * and admin pages.
         *
         * @return void
         */
        function remove_row_actions() {
            global $actions;
            add_filter( 'post_row_actions', '__return_empty_array', 10, 2 );
            add_filter( 'page_row_actions', '__return_empty_array', 10, 2 );
            add_filter( 'media_row_actions', '__return_empty_array', 10, 2 );
            add_filter( 'comment_row_actions', '__return_empty_array', 10, 2 );
            add_filter( 'user_row_actions', '__return_empty_array', 10, 2 );
            add_filter( 'plugin_action_links', '__return_empty_array', 10, 2 );
        }

        /**
         * This function blocks all the $_POST methods
         *
         * @return void
         */
        function stop_submit() {
            $user_ID = $this->get_current_user_ID();
            $meta_key = get_user_meta($user_ID,'read_only_admin',true );
            $current_role = $this->get_role();
            if ( $_POST && $current_role == 'administrator'
                &&  $meta_key == 'read_only_admin' ) {
                if ( true === DOING_AJAX ) {
                    exit;
                }
                else{
                    wp_safe_redirect( admin_url( '?page=error-404' ) );
                    exit;
                }
            }
        }
    
        /**
         * This function adds checkbox custom field in Admin add new User profile page
         *
         * @param [type] $user
         * @return void
         */
        function add_checkbox_on_add_new_user_page( $user ) {
            $user_ID = $this->get_current_user_ID();
            $current_role = $this->get_role();
            $meta_key = get_user_meta( $user_ID, 'read_only_admin', true );
            if( $current_role == 'administrator' && !$meta_key ){
        ?>
            <div style = "margin-top:15px;">
                <label><b>Read Only Admin</b><label>
                <input style = "margin-left:11%;" type = "checkbox" name = "read_only_admin" 
                    value = "read_only_admin" id = "read_only_admin" 
                    <?php if ( get_user_meta( $user->ID, 'read_only_admin', true ) == 'read_only_admin' ){?> checked = "checked" <?php } ?> />
            </div>
        <?php
            }
        }
    
        /**
         * This function save the checkbox custom_field in user_meta
         *
         * @param [type] $user_id
         * @return void
         */
        function save_new_field_from_add_new_user_page( $user_id ) {
            if( isset( $_POST[ 'read_only_admin' ] ) ) {
                $field = $_POST[ 'read_only_admin' ];
                update_usermeta( $user_id, 'read_only_admin', $field );
            }
            
        }
    
        /**
         * This function add new page for displaying error
         *
         * @return void
         */
        function add_error404_page() {
            add_submenu_page(
                null,
                'Custom Page',
                'Custom Page',
                'manage_options',
                'error-404',
                array($this,'render_page_callback' )
            );
        }
    
        /**
         * This is a callback function for add_error404_page()
         *
         * @return void
         */
        function render_page_callback() {
            echo '<div  style="padding-top: 20%; text-align: center;">';
            echo '<h1><b>YOU ARE NOT ALLOWED TO ACCESS THIS PAGE.</b></h1>';
            echo '</div>';
        }
       
        /**
         * Plugin Deactivation Method
         *
         * @return void
         */
        function deactivate() {
            //flush rewrite rules
            flush_rewrite_rules();
        }
    }
    /**
     * Creating Object of this class
     */
    $plugin = new read_only_admin_plugin();
}

/**
 * Activation Hook
 */
register_activation_hook( __FILE__ , array( $plugin,'activate' ) );

/**
 * Deactivation Hook
 */
register_deactivation_hook( __FILE__ , array( $plugin,'deactivate' ) );
