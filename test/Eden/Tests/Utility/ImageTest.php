<?php

//-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_ImageTest extends \PHPUnit_Framework_TestCase {

    public function testBlur() {
        $class = eden('utility')->image(realpath(__DIR__ . '/../../../assets/stars.gif'), 'gif');
//        var_dump($class->getDimensions());
        $this->assertInstanceOf('Eden\Utility\Image', $class);
    }

}