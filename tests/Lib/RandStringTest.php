<?php
namespace Mt\Lib;

use Mt\Lib\RandString;

class RandStringTest extends \PHPUnit_Framework_TestCase
{
    public function testString()
    {
        $len1 = strlen(RandString::string(0, 5));
        $len2 = strlen(RandString::string(10));
        $len3 = strlen(RandString::string(10, 11));

        $this->assertEquals(true, $len1 >= 0 && $len1 <= 5);
        $this->assertEquals(10, $len2);
        $this->assertEquals(true, $len3 >= 10 && $len3 <= 11);
    }

    public function testLetters()
    {
        $len1 = strlen(RandString::letters(0, 5));
        $len2 = strlen(RandString::letters(10));
        $len3 = strlen(RandString::letters(10, 11));

        $this->assertEquals(true, $len1 >= 0 && $len1 <= 5);
        $this->assertEquals(10, $len2);
        $this->assertEquals(true, $len3 >= 10 && $len3 <= 11);
    }

    public function testChars()
    {
        $len1 = strlen(RandString::chars(0, 5));
        $len2 = strlen(RandString::chars(10));
        $len3 = strlen(RandString::chars(10, 11));

        $this->assertEquals(true, $len1 >= 0 && $len1 <= 5);
        $this->assertEquals(10, $len2);
        $this->assertEquals(true, $len3 >= 10 && $len3 <= 11);
    }
}