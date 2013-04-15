<?php //-->
/*
 * This file is part of the Core package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

/**
 * Core Factory Class
 *
 * @vendor Eden
 * @package Core
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Factory extends Base
{
    const INSTANCE = 1;
	
	/**
     * Returns the collection class
     *
	 * @param array
     * @return Eden\Utility\Collection
     */
    public function collection(array $data = array())
    {
        return Collection::i($data);
    }
	
	/**
     * Returns the cookie class
     *
     * @return Eden\Utility\Cookie
     */
    public function cookie()
    {
        return Cookie::i();
    }
	
	/**
     * Returns the cURL class
     *
     * @return Eden\Utility\Curl
     */
    public function curl()
    {
        return Curl::i();
    }
	
	/**
     * Returns the file class
     *
	 * @param string
     * @return Eden\Utility\File
     */
    public function file($path)
    {
		//argument 1 must be a string
		Argument::i()->test(1, 'string');
		
        return File::i($path);
    }
	
	/**
     * Returns the folder class
     *
	 * @param string
     * @return Eden\Utility\Folder
     */
    public function folder($path)
    {
		//argument 1 must be a string
		Argument::i()->test(1, 'string');
		
        return Folder::i($path);
    }
	
	/**
     * Returns the image class
     *
	 * @param string
	 * @param string|null
	 * @param bool
	 * @param int
     * @return Eden\Utility\Image
     */
    public function image($data, $type = null, $path = true, $quality = 75)
    {
		Argument::i()
			->test(1, 'string')
			->test(2, 'string', 'null')
			->test(3, 'bool')
			->test(4, 'int');
			
        return Image::i($data, $type, $path, $quality);
    }
	
	/**
     * Returns the language class
     *
	 * @param string|array
     * @return Eden\Utility\Language
     */
    public function language($language = array())
    {
		//argument 1 must be a file or array
		Argument::i()->test(1, 'file', 'array');
		
        return Language::i($language);
    }
	
	/**
     * Returns the model class
     *
	 * @param array
     * @return Eden\Utility\Model
     */
    public function model(array $data = array())
    {
        return Model::i($data);
    }
		
    /**
     * Returns the oauth class
     *
     * @return Eden\Utility\Oauth
     */
    public function oauth()
    {
        return Oauth::i();
    }
		
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Utility\Oauth2
     */
    public function oauth2()
    {
        return Oauth2::i();
    }
	
	/**
     * Returns the path class
     *
	 * @param string
     * @return Eden\Utility\Path
     */
    public function path($path)
    {
		//argument 1 must be a string
		Argument::i()->test(1, 'string');
		
        return Path::i($path);
    }
		
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Utility\Session
     */
    public function session()
    {
        return Session::i();
    }
		
    /**
     * Returns the template class
     *
     * @return Eden\Utility\Template
     */
    public function template()
    {
        return Template::i();
    }
	
	/**
     * Returns the timezone class
     *
	 * @param string
	 * @param int|string|null
     * @return Eden\Utility\Timezone
     */
	public function timezone($zone, $time = null) 
	{
		Argument::i()
			->test(1, 'string')
			->test(1, 'location', 'utc', 'abbr')
			->test(2, 'int', 'string', 'null');
		
		return Timezone::i($zone, $time);
	}
	
	/**
     * Returns the data type class
     *
	 * @param scalar|array|null
     * @return Eden\Utility\Type
     */
	public function type($type = null) 
	{
		//argument 1 must be a scalar array null
		Argument::i()->test(1, 'scalar', 'array', 'null');
		
		if(func_num_args() > 1) {
			$type = func_get_args();
		}
		
		return Type::i($type);
	}
	
	/**
     * Returns the validation class
     *
	 * @param *mixed
     * @return Eden\Utility\Validation
     */
	public function validation($value) 
	{	
		return Validation::i($value);
	}
}