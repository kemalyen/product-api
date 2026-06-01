<?php

namespace Tests\Unit\Rules;

use App\Rules\ValidProductPrice;
use PHPUnit\Framework\TestCase;

class ValidProductPriceTest extends TestCase
{
    public function test_price_must_be_positive(): void
    {
        $rule = new ValidProductPrice();

        $failed = false;
        $rule->validate('price', 0, function () use (&$failed) {
            $failed = true;
        });
        $this->assertTrue($failed);

        $failed = false;
        $rule->validate('price', -10, function () use (&$failed) {
            $failed = true;
        });
        $this->assertTrue($failed);
    }

    public function test_price_accepts_positive_values(): void
    {
        $rule = new ValidProductPrice();

        $failed = false;
        $rule->validate('price', 99.99, function () use (&$failed) {
            $failed = true;
        });
        $this->assertFalse($failed);

        $failed = false;
        $rule->validate('price', 100, function () use (&$failed) {
            $failed = true;
        });
        $this->assertFalse($failed);
    }

    public function test_price_rejects_more_than_two_decimals(): void
    {
        $rule = new ValidProductPrice();

        $failed = false;
        $rule->validate('price', 99.999, function () use (&$failed) {
            $failed = true;
        });
        $this->assertTrue($failed);
    }

    public function test_price_accepts_two_decimals(): void
    {
        $rule = new ValidProductPrice();

        $failed = false;
        $rule->validate('price', 99.99, function () use (&$failed) {
            $failed = true;
        });
        $this->assertFalse($failed);
    }
}
