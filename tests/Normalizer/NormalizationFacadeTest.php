<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizer;

use Era269\Normalizable\KeyDecorator\AsIsKeyDecorator;
use Era269\Normalizable\Normalizer\NormalizationFacade;
use LogicException;
use PHPUnit\Framework\TestCase;

class NormalizationFacadeTest extends TestCase
{
    /**
     * @var NormalizationFacade
     */
    private $normalizationFacade;

    public function __construct()
    {
        parent::__construct();
        $this->normalizationFacade = new NormalizationFacade(new AsIsKeyDecorator(), []);
    }

    public function testNormalize(): void
    {
        self::expectException(LogicException::class);
        $this->normalizationFacade->normalize('some_value');
    }

    public function testSupports(): void
    {
        self::assertTrue(
            $this->normalizationFacade->supports('some_value')
        );
    }
}
