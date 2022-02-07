<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\KeyDecoratorAwareInterface;
use Era269\Normalizable\KeyDecoratorInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizerAwareInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\Object\ShortClassName;
use Era269\Normalizable\TypeAwareInterface;

final class WithTypeNormalizableNormalizerDecorator implements NormalizerInterface, NormalizerAwareInterface, KeyDecoratorAwareInterface
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
        if ($value instanceof NormalizableInterface && is_array($normalized)) {
            $normalized[self::FIELD_NAME_TYPE] = $value instanceof TypeAwareInterface
                ? $value->getType()
                : (string) new ShortClassName($value);
        }

        return $normalized;
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
