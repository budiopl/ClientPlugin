<?php
/**
 * Plugin Name: Hurtownia - Budio.pl
 * Plugin URI: https://github.com/budiopl/ClientPlugin
 * Description: Umieszcza link do twojej hurtowni w stopce strony.
 * Version: 1.0
 * Author: Budio.pl
 * Author URI: https://budio.pl
 * License: GPL2
 */

add_action('wp_head', 'main_css');

function main_css()
{
      echo '<link rel="stylesheet" href="'.plugins_url( 'css/clientplugin.css', __FILE__ ).'" type="text/css" />';
}


add_action( 'wp_footer', 'budio_signature' );

function budio_signature () {
    $domain = parse_url(get_site_url());
    $response = wp_remote_get( 'https://itnavigator.budio.pl:444/wp-plugin-data?url='.$domain['host'] );

    if(!is_wp_error($response))
    {
          $data = json_decode($response['body']);
          echo '<div class="budio-partner-container">
                 <div class="budio-logo-container">
                     <div class="head">Jesteśmy częścią</div>
                     <a href="https://budio.pl/" target="_blank" class="ext-link grupa-link" rel="nofollow"><img src="'.plugins_url( 'image/budiopl-logo.png', __FILE__ ).'" alt="Budio.pl"></a>';

          if(!is_null($data->wholesale_link))
          {
             echo '<div class="links">
                 <a href="'.$data->wholesale_link.'" target="_blank">Zobacz naszą ofertę</a>
             </div>';
          }

          echo '</div>
                 <div class="budio-apps-container">
                     <div class="head">Darmowa aplikacja mobilna dla Wykonawców</div>
                     <div class="badges">
                         <a href="'.$data->android_app_link.'" target="_blank" rel="nofollow" class="ext-link"><img src="'.plugins_url( 'image/googleplay.png', __FILE__ ).'"></a>
                         <a href="'.$data->ios_app_link.'" target="_blank" rel="nofollow" class="ext-link"><img src="'.plugins_url( 'image/appstore.png', __FILE__ ).'"></a>
                     </div>
                 </div>
             </div>';
    }
 }
