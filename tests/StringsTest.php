<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use Nerd\Common\Strings;

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
}
