<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CurrencyService;

class CurrencyTest extends TestCase
{
    public CurrencyService $currency;

    protected function setUp(): void
    {
        $this->currency = new CurrencyService();
    }

    public function test_convert_usd_to_euro_successful()
    {
        $this->assertEquals(
            98,
            $this->currency->convert(100, 'usd', 'euro')
        );
    }

    public function test_convert_usd_to_ngn_successful()
    {
        $this->assertEquals(
            38800,
            $this->currency->convert(100, 'usd', 'ngn')
        );
    }
}
