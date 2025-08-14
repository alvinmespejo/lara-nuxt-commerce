<?php

namespace App\Services;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use NumberFormatter;
use Symfony\Component\Translation\Formatter\IntlFormatter;

class MoneyService
{
    protected ?BaseMoney $money = null;

    /**
     * Undocumented function
     *
     * @param integer|string $amount
     */
    public function __construct(int|string $amount)
    {
        $this->money = new BaseMoney($amount, new Currency('USD'));
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
     * @param MoneyService $money
     */
    public function add(MoneyService $money): MoneyService
    {
        $this->money = $this->money->add($money->instance());

        return $this;
    }

    public function formatted(): string
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_US', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }

    public function instance(): BaseMoney
    {
        return $this->money;
    }
}
