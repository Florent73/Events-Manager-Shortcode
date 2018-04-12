<?php

defined( 'ABSPATH' ) or die( 'Not allowed' );

global $_wp_admin_css_colors;
$admin_color = get_user_option( 'admin_color', get_current_user_id() );
$colors      = $_wp_admin_css_colors[$admin_color]->colors;

$messageUpdate = 0;
/* Update des paramètres */
if( isset($_POST['action']) && $_POST['action'] == 'update_settings' ) {

    update_option('em_shortcodes_settings', $_POST["em_shortcodes_settings"]);
    update_option('em_shortcodes_css', stripslashes($_POST["em_shortcodes_css"]));
    $options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.', 'em-shortcodes').'</strong></p></div>';
}

// Récupère les paramètres sauvegardés
if(get_option('em_shortcodes_settings')) { extract(get_option('em_shortcodes_settings')); }
$paramMMode = get_option('em_shortcodes_settings');


if(!get_option('em_shortcodes_css') or get_option('em_shortcodes_css')=='') {
    $cssOrigin = '
.ems-event { float:left;text-align:center;padding:0.2em; }
.ems-title, a { font-weight: bold;padding-right:0px!important;margin-top:0.8em;text-align: center;margin-left: auto;margin-right: auto; }
.em-thumbnail {}
.ems-exerpt { padding-right:0px!important; }
.ems-date { padding-right:0px!important; }
.ems-left { float:left;width:20%; }
.ems-right { float:left;width:80%; }
.ems-divbtn {}
.ems-btn,.ems-btn:hover{text-decoration:none}.btn{background-image:-webkit-linear-gradient(top,#3498db,#2980b9);background-image:-ms-linear-gradient(top,#3498db,#2980b9);background-image:-o-linear-gradient(top,#3498db,#2980b9);-webkit-border-radius:4;-moz-border-radius:4;border-radius:4px;font-family:Arial;color:#fff;font-size:20px;background:#3498db;padding:10px 20px}.btn:hover{background:#3cb0fd;background-image:-webkit-linear-gradient(top,#3cb0fd,#3498db);background-image:-moz-linear-gradient(top,#3cb0fd,#3498db);background-image:-ms-linear-gradient(top,#3cb0fd,#3498db);background-image:-o-linear-gradient(top,#3cb0fd,#3498db);background-image:linear-gradient(to bottom,#3cb0fd,#3498db)}
    ';
    update_option('em_shortcodes_css', stripslashes($cssOrigin));
}
//if(get_option('em_shortcodes_css')) { extract(get_option('em_shortcodes_css')); }
//var_dump($paramMMode);
?>
<script>
    function myFunction(e) {
        var limit = document.getElementById("limit").value;
        var image = document.getElementById("image").value;
        select = document.getElementById("category");
        choice = select.selectedIndex  // Récupération de l'index du <option> choisi
        var cat = select.options[choice].value;
        document.getElementById("code").value = '[ems_events cat=' + cat + ' image=' + image + ' limit=' + limit + ']';
    }
    //btn.onclick = reload;
</script>
<style>
.switch-field label,.wpmclassname{display:inline-block;text-align:center}body#tinymce.wp-editor{font-size:.9rem;margin:10px;max-width:100%}.switch-field{font-family:"Lucida Grande",Tahoma,Verdana,sans-serif;overflow:hidden;width:90px;margin-left:auto}.switch-title{margin-bottom:6px}.switch-field input{position:absolute!important;clip:rect(0,0,0,0);height:1px;width:1px;border:0;overflow:hidden}.switch-field label{float:left;width:40px;background-color:#e4e4e4;color:#333;font-size:12px;text-shadow:none;padding:0;border:1px solid rgba(0,0,0,.2);-webkit-box-shadow:inset 0 1px 3px rgba(0,0,0,.3),0 1px rgba(255,255,255,.1);box-shadow:inset 0 1px 3px rgba(0,0,0,.3),0 1px rgba(255,255,255,.1);-webkit-transition:all .1s ease-in-out;-moz-transition:all .1s ease-in-out;-ms-transition:all .1s ease-in-out;-o-transition:all .1s ease-in-out;transition:all .1s ease-in-out}.switch-field label:hover{cursor:pointer}.switch-field input:checked+label{-webkit-box-shadow:none;box-shadow:none;color:#e4e4e4}.switch-field label:first-of-type{border-radius:4px 0 0 4px}.switch-field label:last-of-type{border-radius:0 4px 4px 0}#wpadminbar .wpmbackground{background-color:#333;-webkit-animation-name:blinker;-webkit-animation-duration:5s;-webkit-animation-timing-function:linear;-webkit-animation-iteration-count:infinite;-moz-animation-name:blinker;-moz-animation-duration:5s;-moz-animation-timing-function:linear;-moz-animation-iteration-count:infinite;animation-name:blinker;animation-duration:5s;animation-timing-function:linear;animation-iteration-count:infinite}@-moz-keyframes blinker{0%,100%{opacity:1}50%{opacity:0}}@-webkit-keyframes blinker{0%,100%{opacity:1}50%{opacity:0}}@keyframes blinker{0%,100%{opacity:1}50%{opacity:0}}
</style>
<div class="wrap">
    
    <h3><?php _e('EM Shortcodes Settings', 'em-shortcodes'); ?></h3>
    
    <form method="post" action="" name="valide_settings">
        <input type="hidden" name="action" value="update_settings" />
        
        
    <div style="margin-top:40px;">

        <div>
            <h3><?php _e('Thumbnail Settings:', 'em-shortcodes'); ?></h3>
            <label><?php _e('Thumbnails width:', 'em-shortcodes'); ?></label><br />
            <select name="em_shortcodes_settings[image_width]">
                <option value="thumbnail" <?php if( empty($paramMMode['image_width']) || (isset($paramMMode['image_width']) && $paramMMode['image_width']=='thumbnail') ) { echo ' selected'; } ?> >thumbnail</option>
                <option value="medium"<?php if( isset($paramMMode['image_width']) && $paramMMode['image_width']=='medium' ) { echo ' selected'; } ?>>medium</option>
                <option value="large"<?php if( isset($paramMMode['image_width']) && $paramMMode['image_width']=='large' ) { echo ' selected'; } ?>>large</option>
                <option value="thumbnail"<?php if( isset($paramMMode['image_width']) && $paramMMode['image_width']=='full' ) { echo ' selected'; } ?>>full</option>
            </select> <?php _e('or', 'em-shortcodes'); ?> <input type="text" id="" name="em_shortcodes_settings[image_width_px]" value="<?php if( isset($paramMMode['image_width_px']) ) { echo $paramMMode['image_width_px']; } ?>" placeholder="<?php _e('Width', 'em-shortcodes'); ?>" /> X <input type="text" id="" name="em_shortcodes_settings[image_height_px]" value="<?php if( isset($paramMMode['image_height_px']) ) { echo $paramMMode['image_height_px']; } ?>" placeholder="<?php _e('Height', 'em-shortcodes'); ?>" />
        
            <h3><?php _e('Shortcode Options', 'em-shortcodes'); ?></h3>
            
            <table cellspacing="10">
                <tr>
                    <td valign="middle" align="left"><?php _e('Display events date?', 'em-shortcodes'); ?></td>
                    <td>
                        <div class="switch-field">
                            <input class="switch_left" type="radio" id="switch_displaydate" name="em_shortcodes_settings[displaydate]" value="Yes" <?php if( empty($paramMMode['displaydate']) || (isset($paramMMode['displaydate']) && $paramMMode['displaydate']=='Yes') ) { echo ' checked'; } ?>/>
                            <label for="switch_displaydate"><?php _e('Yes', 'em-shortcodes'); ?></label>
                            <input class="switch_right" type="radio" id="switch_displaydate_no" name="em_shortcodes_settings[displaydate]" value="No" <?php if( isset($paramMMode['displaydate']) && $paramMMode['displaydate']=='No' ) { echo ' checked'; } ?> />
                            <label for="switch_displaydate_no"><?php _e('No', 'em-shortcodes'); ?></label>
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Display events time?', 'em-shortcodes'); ?></td>
                    <td>
                        <div class="switch-field">
                            <input class="switch_left" type="radio" id="switch_displaytime" name="em_shortcodes_settings[displaytime]" value="Yes" <?php if( empty($paramMMode['displaytime']) || (isset($paramMMode['displaytime']) && $paramMMode['displaytime']=='Yes') ) { echo ' checked'; } ?>/>
                            <label for="switch_displaytime"><?php _e('Yes', 'em-shortcodes'); ?></label>
                            <input class="switch_right" type="radio" id="switch_displaytime_no" name="em_shortcodes_settings[displaytime]" value="No" <?php if( isset($paramMMode['displaytime']) && $paramMMode['displaytime']=='No' ) { echo ' checked'; } ?> />
                            <label for="switch_displaytime_no"><?php _e('No', 'em-shortcodes'); ?></label>
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Display events excerpt?', 'em-shortcodes'); ?></td>
                    <td>
                        <div class="switch-field">
                            <input class="switch_left" type="radio" id="switch_displayexcerpt" name="em_shortcodes_settings[displayexcerpt]" value="Yes" <?php if( empty($paramMMode['displayexcerpt']) || (isset($paramMMode['displayexcerpt']) && $paramMMode['displayexcerpt']=='Yes') ) { echo ' checked'; } ?>/>
                            <label for="switch_displayexcerpt"><?php _e('Yes', 'em-shortcodes'); ?></label>
                            <input class="switch_right" type="radio" id="switch_displayexcerpt_no" name="em_shortcodes_settings[displayexcerpt]" value="No" <?php if( isset($paramMMode['displayexcerpt']) && $paramMMode['displayexcerpt']=='No' ) { echo ' checked'; } ?> />
                            <label for="switch_displayexcerpt_no"><?php _e('No', 'em-shortcodes'); ?></label>
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Display button?', 'em-shortcodes'); ?></td>
                    <td>
                        <div class="switch-field">
                            <input class="switch_left" type="radio" id="switch_displaybutton" name="em_shortcodes_settings[displaybutton]" value="Yes" <?php if( empty($paramMMode['displaybutton']) || (isset($paramMMode['displaybutton']) && $paramMMode['displaybutton']=='Yes') ) { echo ' checked'; } ?>/>
                            <label for="switch_displaybutton"><?php _e('Yes', 'em-shortcodes'); ?></label>
                            <input class="switch_right" type="radio" id="switch_displaybutton_no" name="em_shortcodes_settings[displaybutton]" value="No" <?php if( isset($paramMMode['displaybutton']) && $paramMMode['displaybutton']=='No' ) { echo ' checked'; } ?> />
                            <label for="switch_displaybutton_no"><?php _e('No', 'em-shortcodes'); ?></label>
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Text button:', 'em-shortcodes'); ?></td>
                    <td><input type="text" name="em_shortcodes_settings[textbutton]" value="<?php if( isset($paramMMode['textbutton']) && $paramMMode['textbutton']!='' ) { echo $paramMMode['textbutton']; } else { echo 'Read More...'; } ?>" /></td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Color button:', 'em-shortcodes'); ?></td>
                    <td><input type="text" value="<?php if( isset($paramMMode['colorbutton']) && $paramMMode['colorbutton']!='' ) { echo $paramMMode['colorbutton']; } else { echo '#cd1719'; } ?>" name="em_shortcodes_settings[colorbutton]" class="ems-color-field" data-default-color="#cd1719" /></td>
                </tr>
                <tr>
                    <td valign="middle" align="left"><?php _e('Color button hover:', 'em-shortcodes'); ?></td>
                    <td><input type="text" value="<?php if( isset($paramMMode['colorbutton-hover']) && $paramMMode['colorbutton-hover']!='' ) { echo $paramMMode['colorbutton-hover']; } else { echo '#e92a2c'; } ?>" name="em_shortcodes_settings[colorbutton-hover]" class="ems-color-field" data-default-color="#e92a2c" /></td>
                </tr>
            </table>
            <h3><?php _e('Choose a template', 'em-shortcodes'); ?></h3>
            <table cellspacing="10">
                <tr>
                    <td valign="middle" align="left">
                        <?php _e('Landscape', 'em-shortcodes'); ?>
                        
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <?php _e('Portrait', 'em-shortcodes'); ?>
                    </td>
                </tr>
                <tr>
                    <td valign="middle" align="left">
                        <img src="<?php echo EMS_PLUGIN_URL.'images/template2.png '; ?>" />
                                            
                    </td>
                    <td>
                        <div class="switch-field">
                            <input class="switch_left" type="radio" id="switch_template" name="em_shortcodes_settings[template]" value="landscape" <?php if( empty($paramMMode['template']) || (isset($paramMMode['template']) && $paramMMode['template']=='landscape') ) { echo ' checked'; } ?>/>
                            <label for="switch_template"><?php _e('&nbsp;<&nbsp;', 'em-shortcodes'); ?></label>
                            <input class="switch_right" type="radio" id="switch_template_no" name="em_shortcodes_settings[template]" value="portrait" <?php if( isset($paramMMode['template']) && $paramMMode['template']=='portrait' ) { echo ' checked'; } ?> />
                            <label for="switch_template_no"><?php _e('&nbsp;>&nbsp;', 'em-shortcodes'); ?></label>
                        </div>
                    </td>
                    <td>
                        <img src="<?php echo EMS_PLUGIN_URL.'images/template1.png '; ?>" />
                    </td>
                </tr>
            </table>
            <h3><?php _e('Configure your shortcode', 'em-shortcodes'); ?></h3>
            <?php _e('Limit:', 'em-shortcodes'); ?><br /><input type="text" onchange="myFunction(event)" name="em_shortcodes_settings[limit]" id="limit" value="<?php if( isset($paramMMode['limit']) ) { echo $paramMMode['limit']; } else { echo 3; } ?>" /><br />
            <?php _e('Display image:', 'em-shortcodes'); ?><br />
            <select onchange="myFunction(event)" name="em_shortcodes_settings[image_display]" id="image">
                <option value="1" <?php if( (isset($paramMMode['image_display']) && $paramMMode['image_display']==1) or empty($paramMMode['image_display']) ) { echo 'selected'; } ?>><?php _e('Yes', 'em-shortcodes'); ?></option>
                <option value="0" <?php if( isset($paramMMode['image_display']) && $paramMMode['image_display']==0) { echo 'selected'; } ?>><?php _e('No', 'em-shortcodes'); ?></option>
            </select><br />
            <?php _e('Choose your category', 'em-shortcodes'); ?><br /><?php 
                if( isset($paramMMode['category']) ) { $selectedCat = $paramMMode['category']; } else { $selectedCat = 1; }
                $args = array(
                    'show_option_none' => __( 'All category' ),
                    'show_count'       => 0,
                    'option_none_value'=> 0,
                    'orderby'          => 'name',
                    'echo'             => 0,
                    'id' => 'category',
                    'selected' => $selectedCat,
                    'taxonomy' => EM_TAXONOMY_CATEGORY,
                    'name' => 'em_shortcodes_settings[category]', 
                );
                $select  = wp_dropdown_categories( $args );
                $replace = "<select$1 onchange='myFunction(event)' >";
                $select  = preg_replace( '#<select([^>]*)>#', $replace, $select );
                echo $select;
            ?><br /><br />
            <?php
                $displayShortcode = '[ems_events';
                if( isset($paramMMode['limit']) && $paramMMode['limit']>=4 ) {
                    $displayShortcode .= ' limit='.$paramMMode['limit'];
                }
                if( isset($paramMMode['image_display']) && $paramMMode['image_display']=='0' ) {
                    $displayShortcode .= ' image='.$paramMMode['image_display'];
                }
                if( isset($paramMMode['category']) ) {
                    $displayShortcode .= ' cat='.$paramMMode['category'];
                }
                $displayShortcode .= ']';
            ?>
            <?php _e('Copy/Paste this shortcode', 'em-shortcodes'); ?><br /><input type="text" id="code" value="<?php echo $displayShortcode; ?>" size="45" />
            <br /><br />
            <h3><?php _e('CSS', 'em-shortcodes'); ?></h3>
            <TEXTAREA NAME="em_shortcodes_css" id="emshorcodestyle" COLS=70 ROWS=24 style="height:250px;"><?php echo stripslashes(trim(get_option('em_shortcodes_css'))); ?></TEXTAREA>
        
        </div>
        <?php submit_button(); ?>
    </div>
    </form>
    
</div>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("emshorcodestyle"), {
    lineNumbers: true,
    matchBrackets: true,
    textWrapping: true,
    lineWrapping: true,
    mode: "text/x-scss",
    theme:"material"
    });
</script>