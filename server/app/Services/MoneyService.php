<?php

namespace App\Services;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Symfony\Component\Translation\Formatter\IntlFormatter;

class MoneyService
{
    protected ?Money $money = null;

    /**
     * Undocumented function
     *
     * @param integer|string $amount
     */
    public function __construct(int|string $amount)
    {
        $this->money = new Money($amount, new Currency('USD'));
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function amount(): string
    {
        return $this->money->getAmount();
    }

    /**
     * Undocumented function
     *
     * @param Money $amount
     * @return self
     */
    public function add(Money $amount): self
    {
        $this->money = $this->money->add($amount);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_US', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }

    public function getInstance()
    {
        return $this->money;
    }
}
