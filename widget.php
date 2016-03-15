<?php
/*
Plugin Name: Webegin's HKO Weather Widget
Version: 0.1
Plugin URI: http://webegin.com
Description: Grab weather from HKO
Author: Pixelpanic
Author URI: http://webegin.co/
License: MIT
*/

//Get Weather for the widget

$Temperature = "--";
$RelativeHumidity = "--";
$WeatherCode = "0";
$WeatherAlt = "天文台資訊";
$AdditonalIcon = "";



//Register as a wordpress widget

class wp_my_plugin extends WP_Widget {

// constructor
    function wp_my_plugin() {
        parent::WP_Widget(false, $name = __('Webegin HKO Widget', 'wp_widget_plugin') );
    }

// widget form creation
function form($instance) {


/* This widget does not need to user input */
}

// widget update
function update($new_instance, $old_instance) {
/* ... */
}

// widget display
function widget($args, $instance) {

   //Get Weather
    $handle = @fopen("http://www.weather.gov.hk/textonly/forecast/englishwx2.htm", "r");
    if ($handle) {
        while (!feof($handle)) {
            $buffer = strtoupper(fgetss($handle));
            if (strpos($buffer,"AIR TEMPERATURE : ") !== FALSE)
            {
                $txt = array("AIR TEMPERATURE : "," DEGREES CELSIUS");
                $Temperature = str_replace($txt, "", $buffer);
            }
            else if (strpos($buffer,"RELATIVE HUMIDITY : ") !== FALSE)
            {
                $txt = array("RELATIVE HUMIDITY : "," PER CENT");
                $RelativeHumidity = str_replace($txt, "", $buffer);
            }
            else if (strpos($buffer,"WEATHER CARTOON : NO.") !== FALSE)
            {
                $txt = "WEATHER CARTOON : NO.";
                $WeatherCode = substr(trim(str_replace($txt, "", $buffer)),0,2);

                switch ($WeatherCode)
                {
                    case 50: $WeatherAlt = $vocab["wr_code1"]; break;
                    case 51: $WeatherAlt = $vocab["wr_code2"]; break;
                    case 52: $WeatherAlt = $vocab["wr_code3"]; break;
                    case 53: $WeatherAlt = $vocab["wr_code4"]; break;
                    case 54: $WeatherAlt = $vocab["wr_code5"]; break;

                    case 60: $WeatherAlt = $vocab["wr_code6"]; break;
                    case 61: $WeatherAlt = $vocab["wr_code7"]; break;
                    case 62: $WeatherAlt = $vocab["wr_code8"]; break;
                    case 63: $WeatherAlt = $vocab["wr_code9"]; break;
                    case 64: $WeatherAlt = $vocab["wr_code10"]; break;
                    case 65: $WeatherAlt = $vocab["wr_code11"]; break;

                    case 70: $WeatherAlt = $vocab["wr_code12"]; break;
                    case 71: $WeatherAlt = $vocab["wr_code13"]; break;
                    case 72: $WeatherAlt = $vocab["wr_code14"]; break;
                    case 73: $WeatherAlt = $vocab["wr_code15"]; break;
                    case 74: $WeatherAlt = $vocab["wr_code16"]; break;
                    case 75: $WeatherAlt = $vocab["wr_code17"]; break;
                    case 76: $WeatherAlt = $vocab["wr_code18"]; break;
                    case 77: $WeatherAlt = $vocab["wr_code19"]; break;

                    case 80: $WeatherAlt = $vocab["wr_code20"]; break;
                    case 81: $WeatherAlt = $vocab["wr_code21"]; break;
                    case 82: $WeatherAlt = $vocab["wr_code22"]; break;
                    case 83: $WeatherAlt = $vocab["wr_code23"]; break;
                    case 84: $WeatherAlt = $vocab["wr_code24"]; break;
                    case 85: $WeatherAlt = $vocab["wr_code25"]; break;

                    case 90: $WeatherAlt = $vocab["wr_code26"]; break;
                    case 91: $WeatherAlt = $vocab["wr_code27"]; break;
                    case 92: $WeatherAlt = $vocab["wr_code28"]; break;
                    case 93: $WeatherAlt = $vocab["wr_code29"]; break;
                }
                break;
            }
        }
        fclose($handle);
    }

    $handle = @fopen("http://www.weather.gov.hk/textonly/warning/warn.htm", "r");
    if ($handle) {
        while (!feof($handle)) {
            $buffer = strtoupper(fgetss($handle));
            if (strpos($buffer,"There is no warning in force.") !== FALSE)
            {
                break;
            }

            if (strpos($buffer,"TROPICAL CYCLONE WARNING SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc1.gif' alt='".$vocab["wg_code1"]."'/>";
            }

            if (strpos($buffer,"STANDBY SIGNAL, NO. 1") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc1.gif' alt='".$vocab["wg_code2"]."'/>";
            }

            if (strpos($buffer,"STRONG WIND SIGNAL, NO. 3") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc3.gif' alt='".$vocab["wg_code3"]."'/>";
            }

            if (strpos($buffer,"NO. 8 NORTHEAST GALE OR STORM SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc8ne.gif' alt='".$vocab["wg_code4"]."'/>";
            }

            if (strpos($buffer,"NO. 8 NORTHWEST GALE OR STORM SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc8nw.gif' alt='".$vocab["wg_code5"]."'/>";
            }

            if (strpos($buffer,"NO. 8 SOUTHEAST GALE OR STORM SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc8se.gif' alt='".$vocab["wg_code6"]."'/>";
            }

            if (strpos($buffer,"NO. 8 SOUTHWEST GALE OR STORM SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc8sw.gif' alt='".$vocab["wg_code7"]."'/>";
            }

            if (strpos($buffer,"INCREASING GALE OR STORM SIGNAL NO. 9") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc9.gif' alt='".$vocab["wg_code8"]."'/>";
            }

            if (strpos($buffer,"HURRICANE SIGNAL NO. 10") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tc10.gif' alt='".$vocab["wg_code9"]."'/>";
            }

            if (strpos($buffer,"AMBER RAINSTORM WARNING SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/raina.gif' alt='".$vocab["wg_code10"]."'/>";
            }

            if (strpos($buffer,"RED RAINSTORM WARNING SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/rainr.gif' alt='".$vocab["wg_code11"]."'/>";
            }

            if (strpos($buffer,"BLACK RAINSTORM WARNING SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/rainb.gif' alt='".$vocab["wg_code12"]."'/>";
            }

            if (strpos($buffer,"THUNDERSTORM WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/ts.gif' alt='".$vocab["wg_code13"]."'/>";
            }
            /*
                    if (strpos($buffer,"SPECIAL ANNOUNCEMENT ON FLOODING IN THE NORTHERN NEW TERRITORIES") !== FALSE)
                    {
                        $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/nwfl.gif' alt='新 界 北 部 水 浸 特 別 報 告'/>";
                    }
            */
            if (strpos($buffer,"LANDSLIP WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/landslip.gif' alt='".$vocab["wg_code14"]."'/>";
            }

            if (strpos($buffer,"STRONG MONSOON SIGNAL") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/sms.gif' alt='".$vocab["wg_code15"]."'/>";
            }

            if (strpos($buffer,"FROST WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/frost.gif' alt='".$vocab["wg_code16"]."'/>";
            }

            if (strpos($buffer,"YELLOW FIRE DANGER WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/firey.gif' alt='".$vocab["wg_code17"]."'/>";
            }

            if (strpos($buffer,"RED FIRE DANGER WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/firer.gif' alt='".$vocab["wg_code18"]."'/>";
            }

            if (strpos($buffer,"COLD WEATHER WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/cold.gif' alt='".$vocab["wg_code19"]."'/>";
            }

            if (strpos($buffer,"VERY HOT WEATHER WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/vhot.gif' alt='".$vocab["wg_code20"]."'/>";
            }

            if (strpos($buffer,"TSUNAMI WARNING") !== FALSE)
            {
                $AdditonalIcon = $AdditonalIcon."<img src='/tc/images/wea/tsunami-warn.gif' alt='".$vocab["wg_code21"]."'/>";
            }
        }
        fclose($handle);
    }



   //Print result

    echo "<link href=\"/wp-content/themes/reader/weather.css\" rel=\"stylesheet\">
            <div class=\"wea-widget\" style=\"background-image: url('/wp-content/themes/reader/images/wea/". $WeatherCode . ".jpg');\">
			<h3>Hong Kong</h3>";
    echo "<p class=\"wea-week\">" . date('D') . "</p><br>" ;
    echo "<p class=\"wea-date\">" . date('j, F Y')."</p><br>";
    echo "<p class=\"wea-temp\">" . $Temperature ."</p><br>";

}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));
?>

