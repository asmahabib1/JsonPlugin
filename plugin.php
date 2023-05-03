<?php
/*
Plugin Name: Display data from a JSON file
Description: A plugin that works with a shortcode to display data from a JSON file.
Version: 1.0
Plugin URI: https://github.com/asmahabib1/JsonPlugin
Description: Load JSON data in table
Author: Asma Habib

*/
//============================REGISTER PLUGIN STYLESHEET======================================
// register style on initialization
add_action('init', 'register_script');
function register_script(){

    wp_register_style( 'new_style', plugins_url('/json_styles.css', plugin_dir_path( __FILE__ ) . 'json_styles.css'), false, '1.0.0', 'all');
}

// use the registered style above
add_action('wp_enqueue_scripts', 'enqueue_style');

function enqueue_style(){

    wp_enqueue_style( 'new_style' );
}
//============================PLUGIN CODE START===============================================
// Register shortcode i.e  [custom_shortcode sorting=”a”]
add_shortcode( 'custom_shortcode', 'custom_shortcode_handler' );

// Shortcode handler function
function custom_shortcode_handler( $atts ) {
// Parse shortcode attributes
    $args = shortcode_atts( array(
        'sorting' => 'a',
    ), $atts );

// Load JSON data from file
    $json_file = plugin_dir_path( __FILE__ ) . 'data.json';

    if(file_exists($json_file)){
        $json_data = file_get_contents( $json_file );

//DECODE JSON DATA
        $data = json_decode( $json_data, true );

        $message = "";
    } else {
        $message = "<h3 class='text-danger'>JSON file Not found</h3>";
    }
// Sort data by position or natural sort order
    if ( $args['sorting'] == 0 ) {
    } elseif ( $args['sorting'] = '1' ) {
    }
//============================PLUGIN CODE END===============================================
// Build table HTML
    $html = '<div class="jdiv">';
//Error or success message
    if(isset($message)) {
        echo $message;

    $html .= '<table width="99%" align="center" cellspacing="0" class="jtbl">
    <thead>
    <tr class="row">
        <td>Casino</td>
        <td>Bonus</td>
        <td>Features</td>
        <td>Play</td>
    </tr>
    </thead>';
//Display Json data
     foreach ($data['toplists'] as $jdata) {
        foreach ($jdata as $jdata) {
            $html .= '<tr>
            <td> <img src="'.$jdata['logo'] .'"><br><a href="'. $jdata['brand_id'].'">Review</a> </td>
            <td>'.$jdata['info']['rating'].' star <br>'.$jdata['info']['bonus'].'</td>
            <td><ul>';

                for($i="0";$i<count($jdata['info']['features']);$i++) {
                    $html .= '<li>'.$jdata['info']['features'][$i].'</li>';
                }

            $html .= '</ul></td>
            <td><div class="playbutton"><a href="'.$jdata['play_url'].'">PLAY NOW</a></div>
                <div>'.$jdata['terms_and_conditions'].'</div>
            </td>

            </tr>';
      }}
    }
    else
    echo $message;

    $html .= '</table></div>';
    $html .= '</body>
</html>';

    // Return table HTML
    return $html;
}

// [custom_shortcode sorting="a"]
// [custom_shortcode sorting="0"]
