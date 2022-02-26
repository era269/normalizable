<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\KeyDecorator\AsIsKeyDecorator;

class DefaultNormalizationFacade extends NormalizationFacade
{
    public function __construct()
    {
        parent::__construct(
            new AsIsKeyDecorator(),
            [
                new ScalarNormalizer(),
                new ArrayNormalizer(),
                new ListNormalizableToNormalizableAdapterNormalizer(),
                new WithTypeNormalizableNormalizerDecorator(
                    new NormalizableNormalizer()
                ),
                new ScalarableNormalizer(),
                new StringableNormalizer(),
                new FailNormalizer(),
            ]
        );
    }
}
