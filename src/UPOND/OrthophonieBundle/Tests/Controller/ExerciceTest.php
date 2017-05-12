<?php
namespace Kitpages\DataGridBundle\Tests\Model;

use Kitpages\DataGridBundle\Model\Field;

class FieldTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $field = new Field("id");
        $this->assertEquals($field->getFieldName(), "id");

        $field = new Field("phone", array(
            "label" => "Phone",
            "sortable" => true,
            "filterable" => true,
            "visible" => false,
            "formatValueCallback" => function($value) { return strtoupper($value);},
            "autoEscape" => true,
            "translatable" => true
        ));
        $this->assertEquals("Phone", $field->getLabel());
        $this->assertTrue($field->getSortable());
        $this->assertTrue($field->getFilterable());
        $this->assertFalse($field->getVisible());
        $this->assertNotNull($field->getFormatValueCallback());
        $this->assertTrue($field->getFilterable());
        $this->assertTrue($field->getFilterable());
    }

    public function testWrongParameterConstructor()
    {
        try {
            $field = new Field("phone", array(
                "foo" => "bar"
            ));
            $this->fail();
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }
    }
}
