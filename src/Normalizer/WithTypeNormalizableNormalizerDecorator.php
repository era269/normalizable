<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\NormalizationFacadeInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\Object\ShortClassName;
use Era269\Normalizable\Traits\NormalizationFacadeAwareTrait;
use Era269\Normalizable\TypeAwareInterface;

final class WithTypeNormalizableNormalizerDecorator implements NormalizerInterface, NormalizationFacadeAwareInterface
{
    use NormalizationFacadeAwareTrait;

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
            $normalized += [
                $this->getTypeFieldName() => $value instanceof TypeAwareInterface
                    ? $this->getNormalizationFacade()->normalize($value->getType())
                    : (string) new ShortClassName($value),
            ];
        }

        return $normalized;
    }

    /**
     * @return int|string
     */
    private function getTypeFieldName()
    {
        return $this->getNormalizationFacade()->decorate(
            self::FIELD_NAME_TYPE
        );
    }

    public function setNormalizationFacade(NormalizationFacadeInterface $normalizationFacade): void
    {
        $this->_normalizationFacade = $normalizationFacade;
        if ($this->decoratedNormalizer instanceof NormalizationFacadeAwareInterface) {
            $this->decoratedNormalizer->setNormalizationFacade($normalizationFacade);
        }
    }
}
