<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\KeyDecoratorInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\NormalizationFacadeInterface;
use Era269\Normalizable\NormalizerInterface;
use LogicException;

class NormalizationFacade implements NormalizationFacadeInterface
{
    /**
     * @var NormalizerInterface[]
     */
    private $normalizers = [];
    /**
     * @var KeyDecoratorInterface
     */
    private $keyDecorator;

    /**
     * @param iterable|NormalizerInterface[] $normalizers
     */
    public function __construct(KeyDecoratorInterface $keyDecorator, iterable $normalizers)
    {
        $this->keyDecorator = $keyDecorator;
        foreach ($normalizers as $normalizer) {
            if ($normalizer instanceof NormalizationFacadeAwareInterface) {
                $normalizer->setNormalizationFacade($this);
            }
            $this->normalizers[] = $normalizer;
        }
    }

    /**
     * @inheritDoc
     */
    public function normalize($value)
    {
        return $this->getNormalizer($value)
            ->normalize($value);
    }

    /**
     * @param null|int|float|string|bool|array<mixed, mixed>|object $value
     */
    private function getNormalizer($value): NormalizerInterface
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($value)) {
                return $normalizer;
            }
        }
        throw new LogicException("Proper normalizer wasn't set");
    }

    /**
     * @inheritDoc
     */
    public function supports($value): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function decorate($value)
    {
        return $this->keyDecorator
            ->decorate($value);
    }
}
