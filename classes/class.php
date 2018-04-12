<?php

class em_shortcodes {
    
	public function hooks() {
     
        /* Version du plugin */
        $option['emshortcodes_version'] = EMS_VERSION;
        if( !get_option('emshortcodes_version') ) {
            add_option('emshortcodes_version', $option);
        } else if ( get_option('emshortcodes_version') != EMS_VERSION ) {
            update_option('emshortcodes_version', EMS_VERSION);
        }    
        add_filter( 'plugin_action_links', array( $this, 'emshortcodes_plugin_actions'), 10, 2 );
        register_deactivation_hook(__FILE__, 'emshortcodes_uninstall');
        add_action( 'admin_menu', array( $this, 'emshortcodes_admin_menu' ) );
        add_action( 'admin_head', array( $this, 'emshortcodes_admin_head') );
        add_action( 'wp_head', array( $this, 'emshortcodes_css') );
    }
    
    
    // Add "Réglages" link on plugins page
    function emshortcodes_plugin_actions( $links, $file ) {
        
        //return array_merge( $links, $settings_link );
        if ( $file != EMS_PLUGIN_BASENAME ) {
		  return $links;
        } else {
            
            $settings_link = '<a href="admin.php?page=em_shortcodes">'
                . esc_html( __( 'Settings', 'em-shortcodes' ) ) . '</a>';

            array_unshift( $links, $settings_link );

            return $links;
        }
    }
    
    function emshortcodes_css() {
        
        // Récupère les paramètres sauvegardés
        if(get_option('em_shortcodes_settings')) { extract(get_option('em_shortcodes_settings')); }
        $paramMMode = get_option('em_shortcodes_settings');
        
        $emsCss = '<style type="text/css" media="screen">';
        if(get_option('em_shortcodes_css')) {
            $emsCss .= '
'.get_option('em_shortcodes_css');
        }
        
        if( isset($paramMMode['colorbutton']) && $paramMMode['colorbutton']!='' ) {
            $emsCss .= '
.ems-btn{background-image:-webkit-linear-gradient(top,'.$paramMMode['colorbutton'].',#2980b9);background-image:-ms-linear-gradient(top,'.$paramMMode['colorbutton'].',#2980b9);background-image:-o-linear-gradient(top,'.$paramMMode['colorbutton'].',#2980b9);-webkit-border-radius:4;-moz-border-radius:4;background:'.$paramMMode['colorbutton'].';}
.ems-btn:hover{background:'.$paramMMode['colorbutton-hover'].';background-image:-webkit-linear-gradient(top,'.$paramMMode['colorbutton-hover'].',#3498db);background-image:-moz-linear-gradient(top,'.$paramMMode['colorbutton-hover'].','.$paramMMode['colorbutton'].');background-image:-ms-linear-gradient(top,'.$paramMMode['colorbutton-hover'].','.$paramMMode['colorbutton'].');background-image:-o-linear-gradient(top,'.$paramMMode['colorbutton-hover'].','.$paramMMode['colorbutton'].');background-image:linear-gradient(to bottom,'.$paramMMode['colorbutton-hover'].','.$paramMMode['colorbutton'].')}';
        }
        $emsCss .= '</style>';
        echo $emsCss;
    }
    
    function emshortcodes_admin_menu() {
		add_options_page(
			'EM Shortcodes Settings',
			'EM Shortcodes',
			'manage_options',
			'em_shortcodes',
			array(
				$this,
				'emshortcodes_settings_page'
			)
		);
        
        // If you're not including an image upload then you can leave this function call out
        if (isset($_GET['page']) && strpos($_GET['page'], 'em_shortcodes') !==false) {
            /* ****************************************
             * Create a simple CodeMirror instance
             * ****************************************
             */
            // Mode http://codemirror.net/mode/php/index.html
            wp_register_style( 'wpm_codemirror_css', EMS_PLUGIN_URL.'js/codemirror/codemirror.css', false, '1.0.0' );
            wp_enqueue_style( 'wpm_codemirror_css' );

            wp_register_style( 'wpm_codemirror_theme_css', EMS_PLUGIN_URL.'js/codemirror/theme/material.css', false, '1.0.0' );
            wp_enqueue_style( 'wpm_codemirror_theme_css' );

            wp_register_script('wpm_codemirror', EMS_PLUGIN_URL.'js/codemirror/codemirror.js', 'jquery', '1.0');
            wp_enqueue_script('wpm_codemirror');
            wp_register_script('wpm_codemirror_css', EMS_PLUGIN_URL.'js/codemirror/css.js', 'jquery', '1.0');
            wp_enqueue_script('wpm_codemirror_css');

            /* END CODE MIRROR */
            
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'my-script-handle', EMS_PLUGIN_URL.'js/color-options.js', array( 'wp-color-picker' ), false, true );
            
        }
	}
    
    /* Ajout HEAD ADMIN */
    function emshortcodes_admin_head() {
        
        global $current_user;
        global $_wp_admin_css_colors;
        
        $admin_color = get_user_option( 'admin_color', get_current_user_id() );
        $colors      = $_wp_admin_css_colors[$admin_color]->colors;

            echo '
<style>

.switch-field input:checked + label { background-color: '.$colors[2].'; }
.switch-field input:checked + label:last-of-type {
    background-color: '.$colors[0].'!important;
    color:#e4e4e4!important;
}
.wpmass-form-field {
    border: 1px solid '.$colors[2].'!important;
    background: #fff;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    color: '.$colors[2].'!important;
    -webkit-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
    -moz-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
    box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
    padding:8px;
    /*margin-bottom:20px;*/
}
.wpmass-form-field:focus {
    background: #fff!important;
    color: '.$colors[0].'!important;
}
</style>';
        
    }

	function emshortcodes_settings_page() {
		include(EMS_DIR.'/admin/settings.php');
	}
    
    function emshortcodes_cat() {
        global $wpdb;

    }
    function emshortcodes_uninstall() {
    
        global $wpdb;

        if(get_option('emshortcodes_version')) { delete_option('emshortcodes_version'); }

    }
    
       
}


?>