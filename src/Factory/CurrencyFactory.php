<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;

readonly class CurrencyFactory
{
    public function __construct(private CurrencyRepository $currencyRepository)
    {
    }

    public function processData(array $data): void
    {
        foreach ($data as $item) {
            $currency = $this->currencyRepository->findOneBy(['currencyCode' => $item['code']]);

            !$currency ? $this->createCurrency($item) : $this->updateCurrencyExchangeRate($currency, $item);
        }
    }

    private function createCurrency(array $item): void
    {
        $newCurrency = new Currency();
        $newCurrency->setName($item['currency']);
        $newCurrency->setCurrencyCode($item['code']);
        $newCurrency->setExchangeRate($item['mid']);
        $newCurrency->setUpdated(new \DateTimeImmutable());

        $this->currencyRepository->save($newCurrency, true);
    }

    private function updateCurrencyExchangeRate(Currency $currency, array $item): void
    {
        $currency->setExchangeRate($item['mid']);
        $currency->setUpdated(new \DateTimeImmutable());

        $this->currencyRepository->save($currency, true);
    }
}
