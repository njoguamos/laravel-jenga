<?php

declare(strict_types=1);

namespace NjoguAmos\Jenga\Dto;

class IDVerificationDto
{
    public function __construct(
        /** The document id number */
        public string $documentNumber,

        /** First name as per identity document type */
        public string $firstName,

        /** Last name as per identity document type */
        public string $lastName,

        /** Date in of birth as per identity document type */
        public string $dateOfBirth,

        /** The document type of the customer. for example ID, PASSPORT, ALIENID */
        public ?string $documentType = null,

        /** The country in which the document relates to (only KE and RW enabled for now)*/
        public ?string $countryCode = null,
    ) {
    }
}
