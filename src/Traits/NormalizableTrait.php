<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\Normalizer\KeyDecoratorInterface;
use Era269\Normalizable\NormalizerInterface;

trait NormalizableTrait
{
    /**
     * @var NormalizerInterface
     */
    private $normalizer;
    /**
     * @var KeyDecoratorInterface
     */
    private $keyDecorator;

    /**
     * @inheritDoc
     */
    public function normalize(): array
    {
        return $this->getAutoNormalized();
    }

    /**
     * @param array<int|string, mixed> $objectVars
     *
     * @return array<int|string, mixed>
     */
    private function getAutoNormalized(array $objectVars = []): array
    {
        $normalized = [];
        foreach (array_merge($this->getObjectVars(), $objectVars) as $key => $var) {
            $normalizedVar = isset($this->normalizer) ? $this->normalizer->normalize($var) : $var;
            $decoratedKey = isset($this->keyDecorator) ? $this->keyDecorator->decorate($key) : $key;
            $normalized[$decoratedKey] = $normalizedVar;
        }

        return $normalized;
    }

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        $this->normalizer = $normalizer;
    }

    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void
    {
        $this->keyDecorator = $keyDecorator;
    }

    /**
     * @return array<int|string, mixed>
     */
    private function getObjectVars(): array
    {
        $objectVars = get_object_vars($this);
        unset($objectVars['normalizer'], $objectVars['keyDecorator']);

        return $objectVars;
    }
}
