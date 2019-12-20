<?php

namespace Ibrows\AnnotationReader\Tests\Annotation;

/**
 * @Annotation
 */
class TestAnnotation implements TestAnnotationInterface
{
    /**
     * @var string
     */
    public $key;
}