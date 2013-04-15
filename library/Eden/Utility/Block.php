<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

use Eden\Core\Exception\ExceptionHandler;

/**
 * Base class for any class that defines an output block.
 * A block is a default and customizable piece of output.
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
abstract class Block extends Base 
{
	protected static $blockRoot = null;
	private static $global = array();
	
	/**
     * Returns the rendered version of the block
     *
     * @return string
     */
	public function __toString() 
	{
		try {
			return (string) $this->render();
		} catch(Exception $e) {
			ExceptionHandler::i()->handler($e);
		}
		
		return '';
	}
	
	/**
	 * returns location of template file
	 *
	 * @return string
	 */
	abstract public function getTemplate();
	
	/**
	 * returns variables used for templating
	 *
	 * @return array
	 */
	abstract public function getVariables();
	
	/**
	 * Transform block to string
	 *
	 * @param array
	 * @return string
	 */
	public function render() 
	{
		return Template::i()
			->set($this->getVariables())
			->parsePhp($this->getTemplate());
	}
	
	/**
	 * For one file Eden, you can set the default
	 * location of Eden's template to another location.
	 *
	 * @param *string
	 * @return Eden\Utility\Block
	 */
	public function setBlockRoot($root) 
	{
		//argument 1 must be a folder
		Argument::i()->argument(1, 'folder');
		
		self::$blockRoot = $root;
		return $this;
	}
	
	/**
	 * Guarantees a global value is used once
	 *
	 * @param *scalar
	 * @return false|scalar
	 */
	protected function getGlobal($value) 
	{
		if(in_array($value, self::$global)) {
			return false;
		}
		
		self::$global[] = $value;
		return $value;
	}
}