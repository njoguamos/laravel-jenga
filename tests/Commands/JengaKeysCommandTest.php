<?php

test('it generate and replace private and public keys if they do not exists', function () {
    config()->set('jenga.private_key', '');
    config()->set('jenga.public_key', '');

    $this->artisan('jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(trans('jenga::jenga.keys.generated'));
});

test('it cannot generate and replace private and public keys if they exists', function () {
    $privateKey = "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA1BvVbYnuhGGmmIwUdUkFP+WG+tkXyf+o7DopD2MgDh+jwyvA
jwDbSENHOwRuIzYEPBePk1lcchTDraz6VbWbwnDWJNn6cQkDCozRvuN1JnYa88Yy
u7XFQyvskwpk2zgzJ3azuDYAZ0I4yBXAeamLXibOOjm9KFGrBhDMGUtQLVvayZTT
iyyJnDXh5bNISjZeWU1VEiksaMUYujrXmLKDIlFM8xlJJvmvijlwS23J9oP3co3u
Hhd14pGXHKOYXvyVt3Q1taFIps7zS2x2vsGCaK9cdHrExWQdF9fzN95QfagMp7f2
DSMQVhOsXTdZFXMOrkVtWOTlwUJucBGstKOjNwIDAQABAoIBADYvXhh7kgkTgSGb
N2a23rZyBkdyyhb6Tsb6HJ8nrXquLoGfXbOqflo5harX+OLZ278WLcFwpKMoFsz5
UYIvwLitZqdHYCkcKkC5tKNVLApFRaFc0n0NdHUydV8i2pz+AGNmeYbnlLbMPgEv
PVpXK5lDxI8vTNlN86i7Bci4aqULSLYQ9E4/yWOAEAkp9+O7lb6HKcYQ8SgpZ9d9
M0RmxP4Qgc7HdYGo8KzvFJHFtTxOmDMOjWShAxdk77QmnZAznmpmz4v4uUbwR8YK
P7oZV7Lvl1gfma/h+kYR5yd5kJtHSu2+Q2n8gLRfUeFGqD56d1O93VnhSJyhI/OR
zqNhZjECgYEA+zr273pOXDTHRbLVOrYDjxHY6DnD/OeV+qaiCOVFIjTdWAITMuvr
NwKn+Ez0nSBCmKiozdcOzzjxllRs7BhhNGwlQlJloJurfbGIbKb0lSFRQD0bXcxY
32lVscKotMP4lQmmTlALUxbPaCt/MmBsgXg7IA+lGe+I5evAOImE1tUCgYEA2CK6
uUtO6EUBYRC88oyXdlh5lsEM6GpsMHFIlHLeW2EmxTbaaWVf91LRg7lyL+UXEWQ6
zy/oZDuXZI3EVQN2Po2Pcs9V4GFa9FO8YODzdoaHos+f9pe841enZNHkSkXvWXKv
j9HjvVsoKGq3Lg9acLx9dMVmx8ilT1FvDcMz79sCgYBD4soJKgZ0mfpi1hESPU62
4T64eauA8l8vjMlqF/HXbWuGNYFUmDVF9xzGVp0evDHiqGh8vqkMy7lUQtnv7iKO
FM74neVCQe5UF53ipjae+ZLIBfsYHHjDXeY/E3ec6PuJ4kKjFLQKrrY60s4bIb0Q
OxnW7wNQ/84BOvQFEvvnRQKBgQDCwwjf0CzawNPtU9fv+SDDVBa88llfVgcH4A03
OAuG7JSzQiqurts7UzXZLVLoNdgDo/4alWEkcU6LHfS9ZtE2rPmGy67m8tOzN4GZ
CxxYwgGXhODwpOthMat1/m1pQHvebqolP02pZGtbgE5xAwTMcg3bG8byYKwWPZuF
G1HB4QKBgQC5xyHCNq2jQ9YAvja6oqohx59a9Y57R+Xb1Z42w64fouZcbysVWM1f
bfSXnsW49RLDH0Ynns8i5jb+LMdL6W7UujdqrgNMmcNF2GXxHqnYxD10SKRctio5
7gfs5SeS0jvcs7NLCRMhw/yol4pRg12HWcm/YsIpn/na/hUzHesJ+A==
-----END RSA PRIVATE KEY-----";

    $publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1BvVbYnuhGGmmIwUdUkF
P+WG+tkXyf+o7DopD2MgDh+jwyvAjwDbSENHOwRuIzYEPBePk1lcchTDraz6VbWb
wnDWJNn6cQkDCozRvuN1JnYa88Yyu7XFQyvskwpk2zgzJ3azuDYAZ0I4yBXAeamL
XibOOjm9KFGrBhDMGUtQLVvayZTTiyyJnDXh5bNISjZeWU1VEiksaMUYujrXmLKD
IlFM8xlJJvmvijlwS23J9oP3co3uHhd14pGXHKOYXvyVt3Q1taFIps7zS2x2vsGC
aK9cdHrExWQdF9fzN95QfagMp7f2DSMQVhOsXTdZFXMOrkVtWOTlwUJucBGstKOj
NwIDAQAB
-----END PUBLIC KEY-----";

    config()->set('jenga.private_key', $privateKey);
    config()->set('jenga.public_key', $publicKey);

    $this->artisan('jenga:keys')
        ->assertFailed()
        ->expectsOutput(trans('jenga::jenga.keys.exists'));
});
