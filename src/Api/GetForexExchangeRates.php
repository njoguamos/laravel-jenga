<?php

namespace  NjoguAmos\Jenga\Api;

use NjoguAmos\Jenga\Connectors\DefaultJengaConnector;
use Sammyjo20\Saloon\Http\SaloonRequest;

class GetForexExchangeRates extends SaloonRequest
{
    protected ?string $connector = DefaultJengaConnector::class;

    protected ?string $method = 'POST';

    public function __construct(
        public int $amount,
        public string $currencyCode,
        public string $toCurrency,
        public ?string $accountNumber = null,
        public ?string $countryCode = null,
    ) {
        $this->accountNumber = $this->accountNumber ?: config(key: 'jenga.account');
        $this->countryCode = $this->countryCode ?: config(key: 'jenga.country');
    }

    public function defineEndpoint(): string
    {
        return '/v3-apis//transaction-api/v3.0/foreignExchangeRates';
    }
}
