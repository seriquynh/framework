<?php

namespace Illuminate\Tests\Validation\Rules;

use Illuminate\Tests\Validation\ArrayKeys;
use Illuminate\Tests\Validation\ArrayKeysBacked;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\TestCase;

include_once __DIR__ . '/../Enums.php';

class ArrayRuleTest extends TestCase
{
    public function testItCorrectlyFormatsAStringVersionOfTheRule()
    {
        $rule = Rule::array();

        $this->assertSame('array', (string) $rule);

        $rule = Rule::array('key_1', 'key_2', 'key_3');

        $this->assertSame('array:key_1,key_2,key_3', (string) $rule);

        $rule = Rule::array(['key_1', 'key_2', 'key_3']);

        $this->assertSame('array:key_1,key_2,key_3', (string) $rule);

        $rule = Rule::array(collect(['key_1', 'key_2', 'key_3']));

        $this->assertSame('array:key_1,key_2,key_3', (string) $rule);

        $rule = Rule::array([ArrayKeys::key_1, ArrayKeys::key_2, ArrayKeys::key_3]);

        $this->assertSame('array:key_1,key_2,key_3', (string) $rule);

        $rule = Rule::array([ArrayKeysBacked::key_1, ArrayKeysBacked::key_2, ArrayKeysBacked::key_3]);

        $this->assertSame('array:key_1,key_2,key_3', (string) $rule);
    }
}
