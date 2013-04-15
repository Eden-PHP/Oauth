<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

/**
 * General available methods for common cookie procedures.
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Cookie extends Base implements \ArrayAccess, \Iterator 
{
    const INSTANCE = 1;
    protected static $session = false;

    /**
     * Removes all cookies.
     *
     * @return Eden\Utility\Cookie
     */
    public function clear() 
    {
        foreach($_COOKIE as $key => $value) {
            $this->remove($key);
        }

        return $this;
    }

    /**
     * Returns the current item
     * For Iterator interface
     *
     * @return void
     */
    public function current() 
    {
        return current($_COOKIE);
    }

    /**
     * Returns data
     *
     * @param string|null
     * @return mixed
     */
    public function get($key = null) 
    {
        //argument 1 must be a string or null
        Argument::i()->test(1, 'string', 'null');

        if(is_null($key)) {
            return $_COOKIE;
        }

        if(isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }

        return null;
    }

    /**
     * Returns th current position
     * For Iterator interface
     *
     * @return void
     */
    public function key() 
    {
        return key($_COOKIE);
    }

    /**
     * Increases the position
     * For Iterator interface
     *
     * @return void
     */
    public function next() 
    {
        next($_COOKIE);
    }

    /**
     * isset using the ArrayAccess interface
     *
     * @param *scalar|null|bool
     * @return bool
     */
    public function offsetExists($offset) 
    {
        //argument 1 must be scalar, null or bool
        Argument::i()->test(1, 'scalar', 'null', 'bool');

        return isset($_COOKIE[$offset]);
    }

    /**
     * returns data using the ArrayAccess interface
     *
     * @param *scalar|null|bool
     * @return bool
     */
    public function offsetGet($offset) 
    {
        //argument 1 must be scalar, null or bool
        Argument::i()->test(1, 'scalar', 'null', 'bool');

        return isset($_COOKIE[$offset]) ? $_COOKIE[$offset] : null;
    }

    /**
     * Sets data using the ArrayAccess interface
     *
     * @param *scalar|null|bool
     * @param *mixed
     * @return void
     */
    public function offsetSet($offset, $value) 
    {
        //argument 1 must be scalar, null or bool
        Argument::i()->test(1, 'scalar', 'null', 'bool');

        $this->set($offset, $value, strtotime('+10 years'));
    }

    /**
     * unsets using the ArrayAccess interface
     *
     * @param *scalar|null|bool
     * @return bool
     */
    public function offsetUnset($offset) 
    {
        //argument 1 must be scalar, null or bool
        Argument::i()->test(1, 'scalar', 'null', 'bool');

        $this->remove($offset);
    }

    /**
     * Removes a cookie.
     *
     * @param *string cookie name
     * @return Eden\Utility\Cookie
     */
    public function remove($name) 
    {
        //argument 1 must be a string
        Argument::i()->test(1, 'string');

        $this->set($name, null, time() - 3600);

        unset($_COOKIE[$name]);

        return $this;
    }

    /**
     * Rewinds the position
     * For Iterator interface
     *
     * @return void
     */
    public function rewind() 
    {
        reset($_COOKIE);
    }

    /**
     * Sets a cookie.
     *
     * @param *string cookie name
     * @param scalar the data
     * @param int expiration
     * @param string path to make the cookie available
     * @param string|null the domain
     * @return Eden\Utility\Cookie
     */
    public function set(
        $key,
        $data = null,
        $expires = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httponly = false)
    {
        //argment test
        Argument::i()
            ->test(1, 'string')                    //argument 1 must be a string
            ->test(2, 'string', 'numeric', 'null') //argument 2 must be a string,numeric or null
            ->test(3, 'int')                       //argument 3 must be a integer
            ->test(4, 'string', 'null')            //argument 4 must be a string or null
            ->test(5, 'string', 'null')            //argument 5 must be a string or null
            ->test(6, 'bool')                      //argument 6 must be a boolean
            ->test(7, 'bool');                     //argument 7 must be a boolean

        $_COOKIE[$key] = $data;

        setcookie($key, $data, $expires, $path, $domain, $secure, $httponly);

        return $this;
    }

    /**
     * Sets a set of cookies.
     *
     * @param *array the data in key value format
     * @param int expiration
     * @param string path to make the cookie available
     * @param string|null the domain
     * @return Eden\Utility\Cookie
     */
    public function setData(
        array $data,
        $expires = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httponly = false)
    {
        //argment test
        Argument::i()
            ->test(2, 'int')                       //argument 3 must be a integer
            ->test(3, 'string', 'null')            //argument 4 must be a string or null
            ->test(4, 'string', 'null')            //argument 5 must be a string or null
            ->test(5, 'bool')                      //argument 6 must be a boolean
            ->test(6, 'bool');                     //argument 7 must be a boolean

        foreach($data as $key => $value) {
            $this->set($key, $value, $expires, $path, $domain, $secure, $httponly);
        }

        return $this;
    }

    /**
     * Sets a secure cookie.
     *
     * @param *string cookie name
     * @param variable the data
     * @param int expiration
     * @param string path to make the cookie available
     * @param string|null the domain
     * @return Eden\Utility\Cookie
     */
    public function setSecure($key, $data = null, $expires = 0, $path = null, $domain = null) 
    {
        //argment test
        Argument::i()
            ->test(1, 'string')                    //argument 1 must be a string
            ->test(2, 'string', 'numeric', 'null') //argument 2 must be a string,numeric or null
            ->test(3, 'int')                       //argument 3 must be a integer
            ->test(4, 'string', 'null')            //argument 4 must be a string or null
            ->test(5, 'string', 'null');           //argument 5 must be a string or null

        return $this->set($key, $data, $expires, $path, $domain, true, false);
    }

    /**
     * Sets a set of secure cookies.
     *
     * @param *array the data in key value format
     * @param int expiration
     * @param string path to make the cookie available
     * @param string|null the domain
     * @return Eden\Utility\Cookie
     */
    public function setSecureData(array $data, $expires = 0, $path = null, $domain = null) 
    {
        //argment test
        Argument::i()
            ->test(2, 'int')              //argument 3 must be a integer
            ->test(3, 'string', 'null')   //argument 4 must be a string or null
            ->test(4, 'string', 'null');  //argument 5 must be a string or null

        $this->setData($data, $expires, $path, $domain, true, false);
        return $this;
    }

    /**
     * Validates whether if the index is set
     * For Iterator interface
     *
     * @return bool
     */
    public function valid() 
    {
        return isset($_COOKIE[$this->key()]);
    }
}