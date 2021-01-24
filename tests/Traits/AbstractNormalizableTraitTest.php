<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Traits;

use DateTime;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Era269\Normalizable\AbstractNormalizableObject
 */
class AbstractNormalizableTraitTest extends TestCase
{
    private const NORMALIZED = [
        'normalizedDataKey' => 'normalizedDataValue'
    ];

    private const NORMALIZABLE_TRAIT_MOCK_CLASS_NAME = 'UnitTestAbstractNormalizableTraitMock';

    private const TYPE_FIELD_NAME_DEFAULT = '@type';
    private const TYPE_FIELD_NAME_CUSTOM  = '#type-field-name';

    public function testNormalize(): void
    {
        /** @var NormalizableInterface&MockObject $normalizable */
        $normalizable = self::getMockForTrait(AbstractNormalizableTrait::class, [], self::NORMALIZABLE_TRAIT_MOCK_CLASS_NAME);
        $normalizable
            ->method('getNormalized')
            ->willReturn(self::NORMALIZED);

        self::assertEquals(
            $normalizable->normalize(),
            [self::TYPE_FIELD_NAME_DEFAULT => self::NORMALIZABLE_TRAIT_MOCK_CLASS_NAME] + self::NORMALIZED
        );
    }

    /**
     * @dataProvider normalizeWithCustomTypeFieldNameDataProvider
     * @param array<string, mixed> $normalized
     */
    public function testNormalizeWithCustomTypeFieldName(string $typeFieldName, array $normalized, ?object $normalizableObject = null): void
    {
        $normalizable = $this->createNormalizable($typeFieldName, $normalized, $normalizableObject);
        self::assertEquals(
            $normalizable->normalize(),
            [$typeFieldName => get_class($normalizableObject ?? $normalizable)] + $normalized
        );
    }

    /**
     * @return array<int, array<int, array<string, string>|DateTime|string|null>>
     */
    public function normalizeWithCustomTypeFieldNameDataProvider(): array
    {
        return [
            [self::TYPE_FIELD_NAME_DEFAULT, self::NORMALIZED, new DateTime()],
            [self::TYPE_FIELD_NAME_DEFAULT, self::NORMALIZED, null],
            [self::TYPE_FIELD_NAME_DEFAULT, [], new DateTime()],
            [self::TYPE_FIELD_NAME_DEFAULT, [], null],
            [self::TYPE_FIELD_NAME_CUSTOM, self::NORMALIZED, new DateTime()],
            [self::TYPE_FIELD_NAME_CUSTOM, self::NORMALIZED, null],
            [self::TYPE_FIELD_NAME_CUSTOM, [], new DateTime()],
            [self::TYPE_FIELD_NAME_CUSTOM, [], null],
        ];
    }

    /**
     * @param array<string, mixed> $normalized
     */
    private function createNormalizable(string $typeFieldName, array $normalized, ?object $normalizableObject = null): NormalizableInterface
    {
        return new class($typeFieldName, $normalized, $normalizableObject) implements NormalizableInterface {
            use AbstractNormalizableTrait;

            private string $typeFieldName;
            /**
             * @var array<string, mixed> $normalized
             */
            private array $normalized;
            private ?object $normalizableObject;

            /**
             * @param array<string, mixed> $normalized
             */
            public function __construct(string $typeFieldName, array $normalized, ?object $normalizableObject = null)
            {
                $this->typeFieldName = $typeFieldName;
                $this->normalized = $normalized;
                $this->normalizableObject = $normalizableObject;
            }

            protected function getTypeFieldName(): string
            {
                return $this->typeFieldName;
            }

            /**
             * @return  array<string, mixed> $normalized
             */
            protected function getNormalized(): array
            {
                return $this->normalized;
            }

            protected function getObjectForNormalization(): object
            {
                return $this->normalizableObject
                    ?? $this;
            }
        };
    }
}
