<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use DateTime;
use Era269\Normalizable\Adapter\DateTimeToRfc3339NormalizableAdapter;
use PHPUnit\Framework\TestCase;

class DateTimeToRfc3339NormalizableAdapterTest extends TestCase
{
    private DateTime $datetime;
    private DateTimeToRfc3339NormalizableAdapter $adapter;

    public function testNormalize(): void
    {
        self::assertEquals(
            [
                '@type' => $this->datetime::class,
                'dateTime' => $this->datetime->format(DATE_RFC3339),
            ],
            $this->adapter->normalize()
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->datetime = new DateTime();
        $this->adapter = new DateTimeToRfc3339NormalizableAdapter($this->datetime);
    }
}
