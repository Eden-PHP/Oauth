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
 * General available methods for common templating procedures
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Template extends Base 
{
    protected $data = array();

    /**
     * Sets template variables
     *
     * @param *array|string
     * @param mixed
     * @return this
     */
    public function set($data, $value = null) 
    {
		//argument 1 must be an array or string
        Argument::i()->test(1, 'array', 'string');

        if(is_array($data)) {
            $this->data = $data;
            return $this;
        }

        $this->data[$data] = $value;

        return $this;
    }

    /**
     * Simple string replace template parser
     *
     * @param *string template file
     * @return string
     */
    public function parseString($string) 
    {
		//argument 1 must be a string
        Argument::i()->test(1, 'string');
		
        foreach($this->data as $key => $value) {
            $string = str_replace($key, $value, $string);
        }

        return $string;
    }

    /**
     * For PHP templates, this will transform the given document to an actual page or partial
     *
     * @param *string template file or PHP template string
     * @param bool whether to evaluate the first argument
     * @return string
     */
    public function parsePhp($___file, $___evalString = false) 
    {
        Argument::i()
            ->test(1, $___file, 'string')      //argument 1 must be a string
            ->test(2, $___evalString, 'bool'); //argument 2 must be a boolean

        extract($this->data, EXTR_SKIP);     // Extract the values to a local namespace

        if($___evalString) {
            return eval('?>'.$___file.'<?php;');
        }

        ob_start();                            // Start output buffering
        include $___file;                    // Include the template file
        $___contents = ob_get_contents();    // Get the contents of the buffer
        ob_end_clean();                        // End buffering and discard
        return $___contents;                // Return the contents
    }
}