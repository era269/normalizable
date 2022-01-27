<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\Normalizer\KeyDecorator\AsIsKeyDecorator;

class DefaultNormalizationFacade extends NormalizationFacade
{
    public function __construct()
    {
        parent::__construct(
            new AsIsKeyDecorator(),
            [
                new NotObjectNormalizer(),
                new ListNormalizableToNormalizableAdapterNormalizer(),
                new ShortClassNameTypeNormalizableNormalizerDecorator(
                    new NormalizableNormalizer()
                ),
                new ScalarableNormalizer(),
                new StringableNormalizer(),
                new FailNormalizer(),
            ]
        );
    }
}
