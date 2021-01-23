<?php
declare(strict_types=1);


namespace Era269\Normalizable\Adapter;


use DateTimeInterface;
use Era269\Normalizable\AbstractNormalizableObject;

abstract class AbstractDateTimeToNormalizableAdapter extends AbstractNormalizableObject
{
    private DateTimeInterface $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    public function getNormalized(): array
    {
        return [
            $this->getDateTimeFieldName() => $this->getObjectForNormalization()->format(
                $this->getDateTimeFormat()
            )
        ];
    }

    protected function getDateTimeFieldName(): string
    {
        return 'dateTime';
    }

    final protected function getObjectForNormalization(): DateTimeInterface
    {
        return $this->dateTime;
    }

    abstract protected function getDateTimeFormat(): string;
}
