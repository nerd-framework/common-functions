<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use Nerd\Common\Strings;
use Nerd\Common\Arrays;

class StringsTest extends TestCase
{
    public function testIndent()
    {
        $this->assertEquals("", Strings\indent(4, ""));

        $this->assertEquals("  hello", Strings\indent(2, "hello"));

        $text = "This is\nmultiline text\n\ntest.\n";

        $this->assertEquals("    This is\n    multiline text\n\n    test.\n", Strings\indent(4, $text));
    }

    public function testToArray()
    {
        $this->assertEquals([], Strings\toArray(""));
        $this->assertEquals(['f', 'o', 'o'], Strings\toArray("foo"));
    }

    /**
     * @dataProvider  toStringDataProvider
     * @param $expected
     * @param $test
     */
    public function testToString($expected, $test)
    {
        $this->assertEquals($expected, Strings\toString($test));
    }

    public function toStringDataProvider()
    {
        return [
            ['NULL', null],
            ['TRUE', true],
            ['FALSE', false],
            [Arrays\toString([1, 2, 3]), [1, 2, 3]],
            ['foo', 'foo'],
            ['100', 100],
            ['100.5', 100.5],
            ['bar', new fixtures\Foo()],
            ['tests\fixtures\Bar', new fixtures\Bar()]
        ];
    }
}
