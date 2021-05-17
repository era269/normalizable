<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Traits;

use DateTime;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Era269\Normalizable\Abstraction\AbstractNormalizable
 */
class AbstractNormalizableTraitTest extends TestCase
{
    private const NORMALIZED = [
        'normalizedDataKey' => 'normalizedDataValue',
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

    public function testGetType(): void
    {
        /** @var NormalizableInterface&MockObject $normalizable */
        $normalizable = self::getMockForTrait(AbstractNormalizableTrait::class, [], self::NORMALIZABLE_TRAIT_MOCK_CLASS_NAME);

        self::assertEquals(
            self::NORMALIZABLE_TRAIT_MOCK_CLASS_NAME,
            $normalizable->getType()
        );
    }

    /**
     * @dataProvider normalizeWithCustomTypeFieldNameDataProvider
     *
     * @param object|null $normalizableObject
     * @param array<string, mixed> $normalized
     */
    public function testNormalizeWithCustomTypeFieldName(string $typeFieldName, array $normalized, $normalizableObject = null): void
    {
        $normalizable = $this->createNormalizable($typeFieldName, $normalized, $normalizableObject);
        self::assertEquals(
            $normalizable->normalize(),
            [$typeFieldName => get_class($normalizableObject ?? $normalizable)] + $normalized
        );
    }

    /**
     * @param array<string, mixed> $normalized
     * @param object|null $normalizableObject
     */
    private function createNormalizable(string $typeFieldName, array $normalized, $normalizableObject = null): NormalizableInterface
    {
        return new class($typeFieldName, $normalized, $normalizableObject) implements NormalizableInterface {
            use AbstractNormalizableTrait;

            /**
             * @var string
             */
            private $typeFieldName;
            /**
             * @var array<string, mixed> $normalized
             */
            private $normalized;
            /**
             * @var object|null
             */
            private $normalizableObject;

            /**
             * @param array<string, mixed> $normalized
             * @param object|null $normalizableObject
             */
            public function __construct(string $typeFieldName, array $normalized, $normalizableObject = null)
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

            /**
             * @return object
             */
            protected function getObjectForNormalization()
            {
                return $this->normalizableObject
                    ?? $this;
            }
        };
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
}
