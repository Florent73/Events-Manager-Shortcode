<?php

defined( 'ABSPATH' )
	or die( 'No direct load ! ' );

function ems_events_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'limit' => 3,
            'image' => 1,
            'class' => '',
            'cat' => '',
        ), $atts )
    );
    
    // Récupère les paramètres sauvegardés
    if(get_option('em_shortcodes_settings')) { extract(get_option('em_shortcodes_settings')); }
    $paramMMode = get_option('em_shortcodes_settings');
    
    if( isset($paramMMode['image_width']) ) { $thumbnail = $paramMMode['image_width']; }
    if( isset($paramMMode['image_width_px']) && !empty($paramMMode['image_width_px']) ) { $thumbnail = array( $paramMMode['image_height_px'], $paramMMode['image_width_px']); }

    $listEvents = EM_Events::get( array('limit'=>3, 'category' => $cat, 'scope' => 'future', 'owner'=>false) );
    $counEvents = count($listEvents);
    $events = '<div id="ems-list-event" class="ems-list-events">';
    if( $counEvents >= 1 ) {
        
        foreach ( $listEvents as $event ) {
            
            $idThumbnail = get_post_thumbnail_id( $event->post_id );
            $localised_start_date = date_i18n(get_option('date_format'), $event->start);
            $localised_end_date = date_i18n(get_option('date_format'), $event->end);
        
            if( $localised_end_date != $localised_start_date ) { 
                $dateEvent = 'Du '.$localised_start_date .' au '.$localised_end_date; 
            } else if($localised_end_date == $localised_start_date) {
                $dateEvent = 'Le '.$localised_start_date;
            }
            
            if( isset($paramMMode['image_width_px']) && $paramMMode['image_width_px']!='' && is_numeric($paramMMode['image_width_px']) ) {
                if( empty($paramMMode['image_height_px']) || $paramMMode['image_height_px'] == '') { $paramMMode['image_height_px'] == 200; }
                $getImage = wp_get_attachment_image($idThumbnail, array($paramMMode['image_width_px'], $paramMMode['image_height_px']), '', array('class' => "wp-post-image"));
                $events .= '<style>.wp-post-image { width:'.$paramMMode['image_width_px'].'px;height:'.$paramMMode['image_height_px'].'px; } 
                #em-thumbnail { width:'.$paramMMode['image_width_px'].'px;height:'.$paramMMode['image_height_px'].'px; }
                </style>';
            } else {
                $getImage = wp_get_attachment_image($idThumbnail, $paramMMode['image_width'], '', array('class' => "wp-post-image"));
            }
            
            
            // Construction de la miniature de l'événement
            $eventImage = '<div class="em-thumbnail">';
                if ( $idThumbnail ) { // Vérifies qu'une miniature est associée à l'article.
                            $eventImage .= '<a href="'.get_the_permalink($event->post_id).'" title="'.$event->event_name.'" alt="'.$event->event_name.'">'.$getImage.'</a>';
                } else {
                    $eventImage .= '<a href="'.get_the_permalink($event->post_id).'" title="'.$event->event_name.'" alt="'.$event->event_name.'"><img src="'.EMS_URL.'images/blank.jpg" />'.get_post_thumbnail_id( $event->post_id ).'</a>';
                }
            $eventImage .= '</div>';
            // Fin miniature
            
            $eventTitle = '<div class="ems-title"><a href="'.get_the_permalink($event->post_id).'">'.$event->event_name.'</a></div>';
            
            $eventDate = '';
            if( empty($paramMMode['displaydate']) || (isset($paramMMode['displaydate']) && $paramMMode['displaydate']=='Yes') ) {
                $eventDate = '<div class="ems-date">'.$dateEvent.'</div>';
            }
            
            $eventTime = '';
            if( empty($paramMMode['displaytime']) || (isset($paramMMode['displaytime']) && $paramMMode['displaytime']=='Yes') ) {
                //TODO Should 00:00 - 00:00 be treated as an all day event? 
                $eventTime = '<div class="ems-time">De '.str_replace(':', 'h', substr ( $event->start_time, 0, 5 )). " à " . str_replace(':', 'h', substr ( $event->end_time, 0, 5 ) ).'</div>';
            }
            
            $eventExcerpt = '';
            if( get_the_excerpt($event->post_id)!='' && isset($paramMMode['displayexcerpt']) && $paramMMode['displayexcerpt']=='Yes' ) {
                $eventExcerpt = '<div class="ems-exerpt">'.get_the_excerpt($event->post_id).'</div>';
            }
            $eventButton = '';
            if( isset($paramMMode['textbutton']) && $paramMMode['textbutton']!='' ) { $textButton = $paramMMode['textbutton']; } else { $textButton = 'Read More...'; }
            if( empty($paramMMode['displaybutton']) || (isset($paramMMode['displaybutton']) && $paramMMode['displaybutton']=='Yes') ) {
                $eventButton .= '<div class="ems-divbtn"><a class="ems-btn" href="'.get_the_permalink($event->post_id).'" title="'.$event->event_name.'" alt="'.$event->event_name.'">'.$textButton.'</a></div>';
            }
            
            $events .= '<div id="ems-event" class="ems-event"><!-- event:'.$event->post_id.') -->';
            
            if( isset($paramMMode['template']) && $paramMMode['template']=='landscape' ) {
                
                $events .= '<div class="ems-left">'.$eventImage.'</div>';
                $events .= '<div class="ems-right">'.$eventTitle.$eventDate.$eventTime.$eventExcerpt.$eventButton.'</div>';
                $events .= '<div class="clear"></div>';
                
            } else {
                
                
                $events .= $eventImage.$eventTitle.$eventDate.$eventTime.$eventExcerpt.$eventButton;
                
                
            }
            $events .= '</div>';

        }
    } else {
        if( isset($paramMMode['textnotevent']) && $paramMMode['textnotevent']!='' ) { 
            $events .= stripslashes($paramMMode['textnotevent']); 
        } else {
            $events .= 'Actually, there is not event!';
        }
        
    }
    $events .= '</div>';
    
    return $events;
}
add_shortcode( 'ems_events', 'ems_events_shortcode' );