<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_LanguageTest extends \PHPUnit_Framework_TestCase
{
    public function testSet() 
    {
    }
	
	public function testGet()
	{
		$string = eden('utility')
			->language(__DIR__.'/../../../assets/tagalog.php')
			->get('How are you?');
		
		$this->assertEquals('Kumusta ka?', $string);
	}
	
	public function testGetLanguage()
	{
		
		$language = eden('utility')
			->language(__DIR__.'/../../../assets/tagalog.php')
			->getLanguage();
		
		$this->assertArrayHasKey('How are you?', $language);
	}
	
	public function testTranslate()
	{
		$string = eden('utility')
			->language(__DIR__.'/../../../assets/tagalog.php')
			->translate('How much is this?', 'Magkano ba ito?')
			->get('How much is this?');
		
		$this->assertEquals('Magkano ba ito?', $string);
	}
	
	public function testSave()
	{
		$rand = rand();
		
		$class = eden('utility')
			->language(__DIR__.'/../../../assets/tagalog.php')
			->translate('How much is this?', 'Magkano ba ito? '.$rand)
			->save();
		
		$this->assertInstanceOf('Eden\\Utility\\Language', $class);
		
		$string = eden('utility')
			->language(__DIR__.'/../../../assets/tagalog.php')
			->get('How much is this?');
		
		$this->assertEquals('Magkano ba ito? '.$rand, $string);
	}
	
	public function testArrayAccess()
	{
		$language = eden('utility')->language(__DIR__.'/../../../assets/tagalog.php');
		
		$this->assertEquals('Kumusta ka?', $language['How are you?']);
		
		$language['Really?'] = 'Talaga?';
		
		$this->assertEquals('Talaga?', $language['Really?']);
	}
	
	public function testIterable() 
	{
		$language = eden('utility')->language(__DIR__.'/../../../assets/tagalog.php');
		foreach($language as $key => $translation) {
			$this->assertEquals($language[$key], $translation);
		}
	}
}