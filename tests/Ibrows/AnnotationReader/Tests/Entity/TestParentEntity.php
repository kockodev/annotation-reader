<?php

namespace Ibrows\AnnotationReader\Tests\Entity;

use Ibrows\AnnotationReader\Tests\Annotation;

class TestParentEntity extends TestEntity
{
    /**
     * @Annotation\TestAnnotation(key="parent")
     */
    protected $testProperty;
}