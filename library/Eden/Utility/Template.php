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
	const ENGINE_PATTERN = '!{([@$#])([A-Za-z0-9:_]+)}|{([A-Za-z:_\!][A-Za-z0-9:_]*)(\s*,(.+?))?(/}|}(.*?){/\\3})!s';
    protected $data = array();
	
	private $callback = NULL;
	
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
	 * Engine Parser. This parser also cases for lazy loaded variables.
	 * One problem with template engines is that it requires you to preload
	 * variables. This becomes problematic when your template requires a 
	 * plethora of MySQL, Facebook, Twitter calls for example. Sometimes
	 * it's just best to wait till it's needed.
	 * ex {$title}
	 * ex {products}{$title}{/products}
	 *
	 * @param string template
	 * @param callable|null callback to be used when key does not exist in data
	 * @return string
	 */
	public function parseEngine($template, $callback = NULL) 
	{
		//argument test
        Argument::i()
			->test(1, 'string')				//argument 1 must be a string
			->test(2, 'callable', 'null');	//argument 2 must be callable or null
		
		$this->callback = $callback;
		
		return preg_replace_callback(
			self::ENGINE_PATTERN, 
			array($this, 'engineParseResults'), 
			$template);
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
	
	/**
	 * Recursively parses template variables 
	 * to eventually return a string considering
	 * binded values
	 *
	 * @param array
	 * @return string|null
	 */
	protected function engineParseResults($matches) 
	{
		switch(count($matches)) {
			case 3:
				if(!isset($this->data[$matches[2]])) {
					if($this->callback) {
						return call_user_func($this->callback, $matches[2], $matches[1]);
					}
					
					return NULL;
				}
				
				//if count
				if($matches[1] == '#') {
					switch(true) {
						case is_numeric($this->data[$matches[2]]):	
							return $this->data[$matches[2]];
						case is_string($this->data[$matches[2]]):	
							return strlen($this->data[$matches[2]]);
						case is_array($this->data[$matches[2]]):	
							return count($this->data[$matches[2]]);
						default: 		
							return 0;	
					}
				}
				
				return $this->data[$matches[2]];
			case 7:
				//parse args
				$args = str_replace(array('  ',',', ' '),array(' ','', '&'), trim($matches[5]));
				parse_str($args, $args);
				
				if(!isset($this->data[$matches[3]])) {
					if($this->callback) {
						return call_user_func($this->callback, $matches[3], '$', $args);
					}
					
					return NULL;
				}
				
				return $this->data[$matches[3]];
			case 8:
				//if count test
				if(strpos($matches[3], '!') === 0) {
					$key = substr($matches[3], 1);
					
					//if not exists
					if(!isset($this->data[$key]) 
					|| !$this->data[$key] 
					|| !count($this->data[$key])) {
						//return blank
						return NULL;
					}
					
					//just blind pass
					return self::i()->set($this->data)->parseEngine($matches[7]);
				}
				
				//parse args
				$args = str_replace(array('  ',',', ' '),array(' ','', '&'), trim($matches[5]));
				parse_str($args, $args);
				
				if(!isset($this->data[$matches[3]])) {
					if($this->callback) {
						return call_user_func($this->callback, $matches[3], $matches[7], $args);
					}
					
					return NULL;
				}
				
				$rows = array();
				foreach($this->data[$matches[3]] as $j => $row) {
					if(!is_array($row)) {
						$rows[] = self::i()
						->set($this->data[$matches[3]])
						->parseEngine($matches[7]);
						break;
					}
					
					$rows[] = self::i()->set($row)->parseEngine($matches[7]);
				}
				
				return implode("\n", $rows);
			default:
				return NULL;
		}
	}
}