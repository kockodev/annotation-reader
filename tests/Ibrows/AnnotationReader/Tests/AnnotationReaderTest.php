<?php

namespace Ibrows\AnnotationReader\Tests;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use Ibrows\AnnotationReader\AnnotationReader;
use Ibrows\AnnotationReader\AnnotationReaderInterface;
use Ibrows\AnnotationReader\Tests\Annotation\TestAnnotation;
use Ibrows\AnnotationReader\Tests\Entity\TestEntity;
use Ibrows\AnnotationReader\Tests\Entity\TestParentEntity;

class AnnotationReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAnnotationReader()
    {
        $doctrineAnnotationReader = new DoctrineAnnotationReader();
        $reader = new AnnotationReader();

        $reader->setAnnotationReader($doctrineAnnotationReader);
        $this->assertAttributeSame($doctrineAnnotationReader, 'annotationReader', $reader, 'AnnotationReader not correct setted');
    }

    public function testGetAnnotations()
    {
        $reader = $this->getReader();

        $annotations = $reader->getAnnotations(get_class($this->getTestEntity()));

        $keys = array(
            AnnotationReaderInterface::SCOPE_CLASS,
            AnnotationReaderInterface::SCOPE_METHOD,
            AnnotationReaderInterface::SCOPE_PROPERTY
        );

        foreach ($keys as $scope) {
            $this->assertArrayHasKey($scope, $annotations, 'Key "' . $scope . '" not found');
        }

        $this->assertEquals($this->getTestedAnnotations(), $annotations, 'Structure of Result not equal');
    }

    public function testParentGetAnnotations()
    {
        $reader = $this->getReader();

        $annotations = $reader->getAnnotations(get_class($this->getTestParentEntity()));

        $keys = array(
            AnnotationReaderInterface::SCOPE_CLASS,
            AnnotationReaderInterface::SCOPE_METHOD,
            AnnotationReaderInterface::SCOPE_PROPERTY
        );

        foreach ($keys as $scope) {
            $this->assertArrayHasKey($scope, $annotations, 'Key "' . $scope . '" not found');
        }

        $this->assertEquals($this->getTestedParentAnnotations(), $annotations, 'Structure of Result not equal');

        $typeAnnotations = $reader->getAnnotationsByType(get_class($this->getTestParentEntity()), 'TestAnnotationInterface', AnnotationReaderInterface::SCOPE_PROPERTY);
        $this->assertArrayHasKey('testProperty', $typeAnnotations);

        $this->assertEquals('parent', $typeAnnotations['testProperty']->key);
    }

    /**
     * @return AnnotationReader
     */
    private function getReader()
    {
        $reader = new AnnotationReader();
        $reader->setAnnotationReader(new DoctrineAnnotationReader());
        return $reader;
    }

    /**
     * @return TestEntity
     */
    private function getTestEntity()
    {
        return new TestEntity();
    }

    /**
     * @return TestParentEntity
     */
    private function getTestParentEntity()
    {
        return new TestParentEntity();
    }

    /**
     * @return array
     */
    private function getTestedAnnotations()
    {
        return array(
            AnnotationReaderInterface::SCOPE_CLASS    => array(),
            AnnotationReaderInterface::SCOPE_METHOD   => array(),
            AnnotationReaderInterface::SCOPE_PROPERTY => array(
                'testProperty' => array(
                    'TestAnnotationInterface' => array(
                        new TestAnnotation()
                    )
                )
            )
        );
    }

    /**
     * @return array
     */
    private function getTestedParentAnnotations()
    {
        $testAnnotation = new TestAnnotation();
        $testAnnotation->key = 'parent';

        return array(
            AnnotationReaderInterface::SCOPE_CLASS    => array(),
            AnnotationReaderInterface::SCOPE_METHOD   => array(),
            AnnotationReaderInterface::SCOPE_PROPERTY => array(
                'testProperty' => array(
                    'TestAnnotationInterface' => array(
                        $testAnnotation,
                        new TestAnnotation(),
                    )
                )
            )
        );
    }
}