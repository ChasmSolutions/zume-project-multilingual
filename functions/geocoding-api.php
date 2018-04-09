<?php

/**
 * Zume_Google_Geolocation
 *
 * @class   Zume_Google_Geolocation
 * @version 0.1.0
 * @since   0.1.0
 * @package Zume_Tabs
 * @author  Chasm.Solutions
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Class Zume_Google_Geolocation
 */
class Zume_Google_Geolocation
{
    public static $key = 'AIzaSyDPNx9iEK4L1y709lUvw-exL8EqU31MeDk';

    /**
     * Google geocoding service
     *
     * @param $address          string   Can be an address or a geolocation lat, lng
     * @param $type             string      Default is 'full_object', which returns full google response, 'coordinates only' returns array with coordinates_only
     *                          and 'core' returns an array of the core information elements of the google response.
     *
     * @return array|mixed|object|bool
     */
    public static function query_google_api( $address, $type = 'full_object' )
    {
        $address = str_replace( '   ', ' ', $address );
        $address = str_replace( '  ', ' ', $address );
        $address = urlencode( trim( $address ) );
        $url_address = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . self::$key;
        $details = json_decode( self::url_get_contents( $url_address ) );

        if ( $details->status == 'ZERO_RESULTS' ) {
            return false;
        }
        else {
            switch ( $type ) {
                case 'validate':
                    return true;
                    break;
                case 'coordinates_only':
                    $g_lat = $details->results[0]->geometry->location->lat;
                    $g_lng = $details->results[0]->geometry->location->lng;

                    return [
                        'lng' => $g_lng,
                        'lat' => $g_lat
                    ];
                    break;
                case 'core':
                    $g_lat = $details->results[0]->geometry->location->lat;
                    $g_lng = $details->results[0]->geometry->location->lng;
                    $g_formatted_address = $details->results[0]->formatted_address;

                    return [
                        'lng' => $g_lng,
                        'lat' => $g_lat,
                        'formatted_address' => $g_formatted_address
                    ];
                    break;
                case 'all_points':
                    return [
                        'center' => $details->results[0]->geometry->location,
                        'northeast' => $details->results[0]->geometry->bounds->northeast,
                        'southwest' => $details->results[0]->geometry->bounds->southwest,
                        'formatted_address' => $details->results[0]->formatted_address,
                    ];
                    break;
                default:
                    return json_decode( self::url_get_contents( $url_address ), true ); // full_object returned
                    break;
            }
        }
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public static function url_get_contents( $url )
    {
        if ( !function_exists( 'curl_init' ) ) {
            die( 'CURL is not installed!' );
        }
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close( $ch );

        return $output;
    }

    public static function geocode_ip_address( $ip_address ) {
        if ( is_null( $ip_address ) || empty( $ip_address ) ) {
            $ip_address = self::get_real_ip_address();
        }

        $url_address = 'http://freegeoip.net/json/' . $ip_address;
        $details = json_decode( self::url_get_contents( $url_address ), true );

        $formatted_address = '';
        $formatted_address .= empty( $details['city'] ) ? '' : $details['city'];
        $formatted_address .= empty( $details['region_name'] ) ? '' : ', ' . $details['region_name'];
        $formatted_address .= empty( $details['zip_code'] ) ? '' : ' ' . $details['zip_code'];
        $formatted_address .= empty( $details['country_name'] ) ? '' : ' ' . $details['country_name'];

        return [
            'lng' => $details['longitude'],
            'lat' => $details['latitude'],
            'formatted_address' => $formatted_address,
        ];
    }

    /**
     * Check Google for address validation
     * @param $address
     * @return mixed
     */
    public static function check_for_valid_address( $address ) {
        $address = str_replace( '   ', ' ', $address );
        $address = str_replace( '  ', ' ', $address );
        $address = urlencode( trim( $address ) );
        $url_address = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . self::$key;
        $details = json_decode( self::url_get_contents( $url_address ) );

        if ($details->status == 'ZERO_RESULTS' ) {
            return false;
        }
        else {
            return true;
        }
    }

    public static function get_real_ip_address()
    {
        $ip = '';
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ))   //check ip from share internet
        {
            // @codingStandardsIgnoreLine
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ))   //to check ip is pass from proxy
        {
            // @codingStandardsIgnoreLine
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            // @codingStandardsIgnoreLine
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
