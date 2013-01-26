<?php

namespace Autocode;

use Autocode\PHPAttribute;
use Autocode\PHPEntity;
use Autocode\Project;

class EntityTest extends \PHPUnit_Framework_TestCase {
    /** @var Project */
    protected $project;

    /** @var PHPEntity */
    protected $entity;

    /** @var PHPAttribute */
    protected $attribute;

    /** @var PHPEntity */
    protected $foreignEntity;

    /** @var PHPAttribute */
    protected $foreignAttribute;

    public function setUp()
    {
        $this->project          = new Project('FakeNamespace');
        $this->entity           = new PHPEntity($this->project, 'FakeEntityNamespace', '', 'TestEntity');
        $this->attribute        = new PHPAttribute($this->entity, 'testAttribute', 'integer');
        $this->foreignEntity    = new PHPEntity($this->project, 'ForeignNamespace', 'SomeModule', 'OtherEntity');
        $this->foreignAttribute = new PHPAttribute($this->entity, 'otherAttribute', 'smallint');
    }

    public function testGetPhpType()
    {
        $this->assertEquals(
            'integer',
            $this->attribute->getPhpType()
        );

        $this->attribute->setType('array');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpType()
        );

        $this->attribute->setSubtype('House');

        $this->assertEquals(
            'House[]',
            $this->attribute->getPhpType()
        );

        $this->attribute->setType('object');
        $this->assertEquals(
            'House',
            $this->attribute->getPhpType()
        );

        $this->attribute->setType('integer');
        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);

        $this->assertEquals(
            'OtherEntity',
            $this->attribute->getPhpType()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'OtherEntity[]|Collection',
            $this->attribute->getPhpType()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetPhpTypeException() {
        $this->attribute->setType('object');
        $this->attribute->getPhpType();
    }

    public function testGetPhpParameterType()
    {
        $this->assertEquals(
            null,
            $this->attribute->getPhpParameterType()
        );

        $this->attribute->setType('array');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpParameterType()
        );

        $this->attribute->setSubtype('House');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpParameterType()
        );

        $this->attribute->setType('object');
        $this->assertEquals(
            'House',
            $this->attribute->getPhpParameterType()
        );

        $this->attribute->setType('integer');
        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);

        $this->assertEquals(
            'OtherEntity',
            $this->attribute->getPhpParameterType()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'Collection',
            $this->attribute->getPhpParameterType()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetPhpParameterTypeException() {
        $this->attribute->setType('object');
        $this->attribute->getPhpParameterType();
    }

    public function testGetPhpTypeBase()
    {
        $this->assertEquals(
            'integer',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setType('array');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setSubtype('House');

        $this->assertEquals(
            'House[]',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setType('object');
        $this->assertEquals(
            'House',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);

        $this->assertEquals(
            'House',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setType('integer');

        $this->assertEquals(
            'OtherEntity',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'OtherEntity[]|Collection',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setForeign('OneToOne');
        $this->project->setBase(true);

        $this->assertEquals(
            'OtherEntityBase|OtherEntity',
            $this->attribute->getPhpTypeBase()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'OtherEntityBase[]|OtherEntity[]|Collection',
            $this->attribute->getPhpTypeBase()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetPhpTypeBaseException() {
        $this->attribute->setType('object');
        $this->attribute->getPhpTypeBase();
    }

    public function testGetPhpParameterTypeBase()
    {
        $this->assertEquals(
            null,
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setType('array');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setSubtype('House');

        $this->assertEquals(
            'array',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setType('object');
        $this->assertEquals(
            'House',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setType('integer');
        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);

        $this->assertEquals(
            'OtherEntity',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'Collection',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setForeign('OneToOne');
        $this->project->setBase(true);

        $this->assertEquals(
            'OtherEntityBase|OtherEntity',
            $this->attribute->getPhpParameterTypeBase()
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            'Collection',
            $this->attribute->getPhpParameterTypeBase()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetPhpParameterTypeBaseException() {
        $this->attribute->setType('object');
        $this->attribute->getPhpParameterTypeBase();
    }
}