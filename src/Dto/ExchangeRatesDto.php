<?php

declare(strict_types=1);

namespace NjoguAmos\Jenga\Dto;

class ExchangeRatesDto
{
    public function __construct(
        /** The amount you wish to convert */
        public int $amount,

        /** The currency code of the currency (in ISO 4217 format) that is being converted from */
        public string $currencyCode,

        /** The currency code (in ISO 4217 format) of the currency being converted to */
        public string $toCurrency,

        /** Bank account registered in your JengaHQ. Default to test bank account. */
        public ?string $accountNumber = null,

        /** the country for which rates are being requested. Valid values are KE, TZ, UG, RW.*/
        public ?string $countryCode = null,
    ) {
    }
}
