<?php

namespace Autocode\Templates\PHP;

use Autocode\Templates\PHP\Entity;
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

    /** @var Entity */
    protected $entityTemplate;

    /** @var PHPAttribute */
    protected $reverseAttribute;

    public function setUp()
    {
        $this->project          = new Project('FakeNamespace');
        $this->entity           = new PHPEntity($this->project, 'FakeEntityNamespace', '', 'TestEntity');
        $this->attribute        = new PHPAttribute($this->entity, 'testAttribute', 'integer');
        $this->foreignEntity    = new PHPEntity($this->project, 'ForeignNamespace', 'SomeModule', 'OtherEntity');
        $this->foreignAttribute = new PHPAttribute($this->entity, 'otherAttribute', 'smallint');
        $this->entityTemplate   = new Entity();
        $this->entityTemplate->setEntity($this->entity);
        $this->reverseAttribute = new PHPAttribute($this->entity, 'myReverseAttribute', 'decimal');
    }

//	public function testGetAttribute()
//    {
//        $entityTemplate = new Entity();
//
//        $project = new Project('FakeNamespace');
//
//        $entity = new PHPEntity($project, 'FakeEntityNamespace', '', 'TestEntity');
//
//        $attribute = new PHPAttribute($entity, 'testAttribute', 'integer');
//
//        $this->assertEquals(
//            3,
//            $entityTemplate->getAttribute($attribute)
//        );
//    }

    public function testGetGetterCode()
    {
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return integer' . "\n" .
                '     */' . "\n" .
                '    public function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return $this->testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->attribute->setType('object');
        $this->attribute->setSubtype('House');

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return House' . "\n" .
                '     */' . "\n" .
                '    public function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return $this->testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->attribute->setNull(true);

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return House|null' . "\n" .
                '     */' . "\n" .
                '    public function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return $this->testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->attribute->setStatic(true);

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return House|null' . "\n" .
                '     */' . "\n" .
                '    public static function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return self::$testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->project->setBase(true);

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return House|null' . "\n" .
                '     */' . "\n" .
                '    public static function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return self::$testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return OtherEntityBase|OtherEntity|null' . "\n" .
                '     */' . "\n" .
                '    public static function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return self::$testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );

        $this->attribute->setForeign('ManyToMany');

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Get testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return OtherEntityBase[]|OtherEntity[]|Collection|null' . "\n" .
                '     */' . "\n" .
                '    public static function getTestAttribute()' . "\n" .
                '    {' . "\n" .
                '        return self::$testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getGetterCode($this->attribute)
        );
    }

    public function testGetSetterCode()
    {
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param integer $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!is_int($testAttribute)) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be integer (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setType('object');
        $this->attribute->setSubtype('House');

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param House $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute(House $testAttribute)' . "\n" .
                '    {' . "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setNull(true);

        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param House|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setStatic(true);

        // Static, not base, null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param House|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public static function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        self::$testAttribute = $testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->project->setBase(true);

        // Static, base, null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param House|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public static function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        self::$testAttribute = $testAttribute;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setForeign('OneToOne');
        $this->attribute->setForeignEntity($this->foreignEntity);
        $this->attribute->setForeignKey($this->foreignAttribute);
        $this->attribute->setStatic(false);

        // OneToOne from inverse, null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase|OtherEntity|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        if (null !== $testAttribute) {' . "\n" .
                '            $this->testAttribute = $testAttribute;' . "\n" .
                '            if ($this !== $testAttribute->getOtherAttribute()) {' . "\n" .
                '                $testAttribute->setOtherAttribute($this);' . "\n" .
                '            }' . "\n" .
                '        } elseif (null !== $this->testAttribute) {' . "\n" .
                '            $this->testAttribute->setOtherAttribute(null);' . "\n" .
                '            $this->testAttribute = null;' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setNull(false);

        // OneToOne from inverse, not null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase|OtherEntity $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute(OtherEntity $testAttribute)' . "\n" .
                '    {' . "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                '        if ($this !== $testAttribute->getOtherAttribute()) {' . "\n" .
                '            $testAttribute->setOtherAttribute($this);' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setForeign('ManyToMany');
        $this->attribute->setReverseAttribute($this->reverseAttribute);
        $this->attribute->setNull(true);

        // ManyToMany from inverse, null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase[]|OtherEntity[]|Collection|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        foreach ($testAttribute as $testAttributeSingle) {' . "\n" .
                '            $testAttributeSingle->setMyReverseAttribute(new ArrayCollection([$this]));' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setForeign('OneToOne');
        $this->attribute->setOwnerSide(true);

        // OneToOne from direct, null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase|OtherEntity|null $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     *' . "\n" .
                '     * @throws \InvalidArgumentException' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute($testAttribute)' . "\n" .
                '    {' . "\n" .
                '        if (!$testAttribute instanceof House && null !== $testAttribute) {' . "\n" .
                '            throw new \InvalidArgumentException(\'The attribute testAttribute on the class TestEntity has to be House or null (\' . gettype($testAttribute) . (\'object\' === gettype($testAttribute) ? \' \' . get_class($testAttribute) : \'\') . \' given).\');' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        if (null !== $testAttribute) {' . "\n" .
                '            $this->testAttribute = $testAttribute;' . "\n" .
                '            if ($this !== $testAttribute->getTestEntity()) {' . "\n" .
                '                $testAttribute->setTestEntity($this);' . "\n" .
                '            }' . "\n" .
                '        } elseif (null !== $this->testAttribute) {' . "\n" .
                '            $this->testAttribute->setOtherAttribute(null);' . "\n" .
                '            $this->testAttribute = null;' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setNull(false);

        // OneToOne from direct, not null
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase|OtherEntity $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute(OtherEntity $testAttribute)' . "\n" .
                '    {' . "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                '        if ($this !== $testAttribute->getTestEntity()) {' . "\n" .
                '            $testAttribute->setTestEntity($this);' . "\n" .
                '        }' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );

        $this->attribute->setForeign('ManyToOne');

        // ManyToOne from direct, not null
        // TO BE IMPROVED
        $this->assertEquals(
            '    /**' . "\n" .
                '     * Set testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @param OtherEntityBase|OtherEntity $testAttribute' . "\n" .
                '     *' . "\n" .
                '     * @return TestEntity' . "\n" .
                '     */' . "\n" .
                '    public function setTestAttribute(OtherEntity $testAttribute)' . "\n" .
                '    {' . "\n" .
                '        $this->testAttribute = $testAttribute;' . "\n" .
                "\n" .
                '        return $this;' . "\n" .
                '    }' . "\n",
            $this->entityTemplate->getSetterCode($this->attribute)
        );
    }
}