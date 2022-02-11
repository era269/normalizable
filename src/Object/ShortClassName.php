<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

final class ShortClassName extends StringObject
{
    /**
     * @param object $object
     */
    public function __construct($object)
    {
        $className = get_class($object);
        $offset = strrpos($className, '\\');
        $offset = $offset === false
            ? 0
            : $offset + 1;

        parent::__construct(
            substr($className, $offset)
        );
    }
}
