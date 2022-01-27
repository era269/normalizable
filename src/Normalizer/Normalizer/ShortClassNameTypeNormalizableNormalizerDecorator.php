<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizableWrapperInterface;
use Era269\Normalizable\Normalizer\KeyDecoratorAwareInterface;
use Era269\Normalizable\Normalizer\KeyDecoratorInterface;
use Era269\Normalizable\Normalizer\NormalizerAwareInterface;
use Era269\Normalizable\NormalizerInterface;

final class ShortClassNameTypeNormalizableNormalizerDecorator implements NormalizerInterface, NormalizerAwareInterface, KeyDecoratorAwareInterface
{
    private const FIELD_NAME_TYPE = '@type';
    /**
     * @var NormalizerInterface
     */
    private $decoratedNormalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->decoratedNormalizer = $normalizer;
    }

    /**
     * @inheritDoc
     */
    public function supports($value): bool
    {
        return $this->decoratedNormalizer
            ->supports($value);
    }

    /**
     * @inheritDoc
     */
    public function normalize($value)
    {
        $normalized = $this->decoratedNormalizer->normalize($value);
        if ($value instanceof NormalizableInterface) {
            $normalized[self::FIELD_NAME_TYPE] = $this->getShortClasName($value);
        }

        return $normalized;
    }

    private function getShortClasName(NormalizableInterface $value): string
    {
        $className = $value instanceof NormalizableWrapperInterface
            ? get_class($value->getWrappedObject())
            : get_class($value);
        $offset = strrpos($className, '\\');
        $offset = $offset === false
            ? 0
            : $offset + 1;

        return substr($className, $offset);
    }

    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void
    {
        if ($this->decoratedNormalizer instanceof KeyDecoratorAwareInterface) {
            $this->decoratedNormalizer->setKeyDecorator($keyDecorator);
        }
    }

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        if ($this->decoratedNormalizer instanceof NormalizerAwareInterface) {
            $this->decoratedNormalizer->setNormalizer($normalizer);
        }
    }
}
