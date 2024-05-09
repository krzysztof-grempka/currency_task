<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\CurrencyFactory;
use Symfony\Component\HttpClient\HttpClient;

readonly class NbpApiService
{
    public function __construct(
        private string $nbpUrl,
        private CurrencyFactory $currencyFactory,
    ) {
    }

    public function getExchangeRatesFromTableA(): void
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $this->nbpUrl);

            $data = $response->toArray();

            isset($data[0]['rates']) && is_array($data[0]['rates'])
                ? $this->currencyFactory->processData($data[0]['rates'])
                : throw new \Exception('Invalid API response.');
        } catch (\Exception $e) {
            throw new \Exception('Failed to retrieve data. Error: '.$e->getMessage());
        }
    }
}
