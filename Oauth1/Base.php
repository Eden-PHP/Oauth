<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth1;

use Eden\Oauth\Base as OauthBase;

/**
 *  Trigger when something is false
 *
 * @vendor Eden
 * @package Oauth
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Base extends OauthBase 
{
    const HMAC_SHA1 = 'HMAC-SHA1';
    const RSA_SHA1 	= 'RSA-SHA1';
    const PLAIN_TEXT = 'PLAINTEXT';

    const POST = 'POST';
    const GET = 'GET';

    const OAUTH_VERSION	= '1.0';

    /**
     * Generates an oauth standard query
     *
     * @param array
     * @param string
     * @param bool
     * @param bool
     * @param string
     */
    protected function buildQuery($params, $separator = '&', $noQuotes = true, $subList = false)
    {
        if(empty($params)) {
            return '';
        }

        //encode both keys and values
        $keys = $this->encode(array_keys($params));
        $values = $this->encode(array_values($params));

        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte value ordering.
        // http://oauth.net/core/1.0/#rfc.section.9.1.1
        uksort($params, 'strcmp');

        // Turn params array into an array of "key=value" strings
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                // If two or more parameters share the same name,
                // they are sorted by their value. OAuth Spec: 9.1.1 (1)
                natsort($value);
                $params[$key] = $this->buildQuery($value, $separator, $noQuotes, true);
                continue;
            }

            if(!$noQuotes) {
                $value = '"'.$value.'"';
            }

            $params[$key] = $value;
        }

        if($subList) {
            return $params;
        }

        foreach($params as $key => $value) {
            $params[$key] = $key.'='.$value;
        }

        return implode($separator, $params);
    }

    /**
     * Generates an oauth standard encoding
     *
     * @param string
     * @return string
     */
    protected function encode($string)
    {
        if (is_array($string)) {
            foreach($string as $i => $value) {
                $string[$i] = $this->encode($value);
            }

            return $string;
        }

        if (is_scalar($string)) {
            return str_replace('%7E', '~', rawurlencode($string));
        }

        return null;
    }

    /**
     * URL decodes a string
     *
     * @param string
     * @return string
     */
    protected function decode($rawInput)
    {
        return rawurldecode($rawInput);
    }

    /**
     * Oauth standard parseString
     *
     * @param string
     * @return array
     */
    protected function parseString($string)
    {
        $array 	= array();

        if(strlen($string) < 1) {
            return $array;
        }

        // Separate single string into an array of "key=value" strings
        $keyvalue = explode('&', $query_string);

        // Separate each "key=value" string into an array[key] = value
        foreach ($keyvalue as $pair) {
            list($k, $v) = explode('=', $pair, 2);

            // Handle the case where multiple values map to the same key
            // by pulling those values into an array themselves
            if (isset($query_array[$k])) {
                // If the existing value is a scalar, turn it into an array
                if (is_scalar($query_array[$k])) {
                    $query_array[$k] = array($query_array[$k]);
                }
                array_push($query_array[$k], $v);
            } else {
                $query_array[$k] = $v;
            }
        }

        return $array;
    }
}