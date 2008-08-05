<?php


include_once( "lib/ezxml/classes/ezxml.php" );

class GoogleWeather
{
    var $temp;
    var $street;
    var $zip;
    var $city;
    
    function GoogleWeather() 
    {
    }
    
    function request( $address )
    {
        $ini = eZINI::instance( "all2egoogleweather.ini" );                          
        $url = $ini->variable( "GoogleSettings", "RequestURL" );
       
        $requestString= $url."?weather=".$address;                

        $xml = file( $requestString );
        
        if( !empty($xml[0]) )
        {
            eZDebug::writeDebug( $xml[0], 'Google Weather Response');
            $xmldomxml = new eZXML();
            $xmldom = $xmldomxml->domTree($xml[0]);
            
            $dom_problem_causenode = $xmldom->elementsByName( "problem_cause" );
            $dom_weathernode = $xmldom->elementsByName( "weather" );
            $dom_forecastnode = $dom_weathernode[0]->elementsByName( "forecast_information" );
            
            if( !$dom_problem_causenode && $dom_forecastnode )
            {
                $dom_adressnode = $xmldom->elementsByName( "city" ); 
                $city = $dom_adressnode[0]->get_attribute( "data" );
                
                $dom_temp_cnode = $xmldom->elementsByName( "temp_c" ); 
                $temp_c = $dom_temp_cnode[0]->get_attribute( "data" );
                
                $dom_humiditynode = $xmldom->elementsByName( "humidity" ); 
                $humidity = $dom_humiditynode[0]->get_attribute( "data" );
                
                // Current Condition
                $dom_current_conditionsnode = $xmldom->elementsByName( "current_conditions" );
                $cur_condition = $dom_current_conditionsnode[0]->elementsByName( "condition" );
                $cur_temp_c = $dom_current_conditionsnode[0]->elementsByName( "temp_c" );
                $cur_humidity = $dom_current_conditionsnode[0]->elementsByName( "humidity" );
                $cur_icon = $dom_current_conditionsnode[0]->elementsByName( "icon" );
                
                $current['cur_condition'] = $cur_condition[0]->get_attribute( "data" );
                $current['cur_temp_c'] = $cur_temp_c[0]->get_attribute( "data" );
                $current['cur_humidity'] = $cur_humidity[0]->get_attribute( "data" );
                $current['cur_icon'] = $cur_icon[0]->get_attribute( "data" );
                
                
                $dom_forecast_conditionsnode = $xmldom->elementsByName( "forecast_conditions" );
                for( $i=0; $i<count($dom_forecast_conditionsnode); $i++ )
                {
                    $for_day_of_week = $dom_forecast_conditionsnode[$i]->elementsByName( "day_of_week" );
                    $for_low = $dom_forecast_conditionsnode[$i]->elementsByName( "low" );
                    $for_high = $dom_forecast_conditionsnode[$i]->elementsByName( "high" );
                    $for_icon = $dom_forecast_conditionsnode[$i]->elementsByName( "icon" );
                    $for_condition = $dom_forecast_conditionsnode[$i]->elementsByName( "condition" );
                    
                    $forecast[$i]['day_of_week'] = $for_day_of_week[0]->get_attribute( "data" );
                    $forecast[$i]['low'] = $for_low[0]->get_attribute( "data" );
                    $forecast[$i]['high'] = $for_high[0]->get_attribute( "data" );
                    $forecast[$i]['icon'] = $for_icon[0]->get_attribute( "data" );
                    $forecast[$i]['condition'] = $for_condition[0]->get_attribute( "data" );
                }
                
                $content = array( "city"=>$city, "temp_c"=>$temp_c, "humidity"=>$humidity, "current_conditions" => $current, "forecast"=>$forecast );
                
                
                
                return $content;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        } 
                      
    }
}
?>
