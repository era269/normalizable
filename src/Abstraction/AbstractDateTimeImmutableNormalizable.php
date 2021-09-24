<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use DateTime;
use DateTimeImmutable;
use Era269\Normalizable\DenormalizableInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractDateTimeNormalizableTrait;

abstract class AbstractDateTimeImmutableNormalizable extends DateTimeImmutable implements NormalizableInterface, DenormalizableInterface
{
    use AbstractDateTimeNormalizableTrait;

    /**
     * @inheritDoc
     */
    public static function createFromMutable(DateTime $object): self
    {
        /** @var self $dateTimeImmutable */
        $dateTimeImmutable = parent::createFromMutable($object);

        return $dateTimeImmutable;
    }
}
