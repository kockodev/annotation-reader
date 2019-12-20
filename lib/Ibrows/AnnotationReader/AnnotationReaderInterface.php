<?php

namespace Ibrows\AnnotationReader;

use Doctrine\Common\Annotations\Reader;

interface AnnotationReaderInterface
{
    const
        SCOPE_CLASS = 'class',
        SCOPE_METHOD = 'method',
        SCOPE_PROPERTY = 'property'
    ;

    /**
     * @param Reader $annotationReader
     * @return AnnotationReaderInterface
     */
    public function setAnnotationReader(Reader $annotationReader);

    /**
     * @param mixed $entity
     * @return array
     */
    public function getAnnotations($entity);

    /**
     * @param mixed $entity
     * @param string $type
     * @param string $scope
     * @return array
     */
    public function getAnnotationsByType($entity, $type, $scope);
}