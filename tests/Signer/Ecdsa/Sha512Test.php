<?php
declare(strict_types=1);

namespace Lcobucci\JWT\Tests\Signer\Ecdsa;

use Lcobucci\JWT\Signer\Ecdsa;
use Lcobucci\JWT\Signer\Ecdsa\Sha512;
use Lcobucci\JWT\Signer\InvalidKeyProvided;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\OpenSSL;
use PHPUnit\Framework\Attributes as PHPUnit;

use const OPENSSL_ALGO_SHA512;

#[PHPUnit\CoversClass(Ecdsa::class)]
#[PHPUnit\CoversClass(Ecdsa\MultibyteStringConverter::class)]
#[PHPUnit\CoversClass(Ecdsa\Sha512::class)]
#[PHPUnit\CoversClass(OpenSSL::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(Key\InMemory::class)]
final class Sha512Test extends EcdsaTestCase
{
    protected function algorithm(): Ecdsa
    {
        return new Sha512($this->pointsManipulator);
    }

    protected function algorithmId(): string
    {
        return 'ES512';
    }

    protected function signatureAlgorithm(): int
    {
        return OPENSSL_ALGO_SHA512;
    }

    protected function pointLength(): int
    {
        return 132;
    }

    protected function keyLength(): int
    {
        return 521;
    }

    protected function verificationKey(): Key
    {
        return self::$ecdsaKeys['public_ec512'];
    }

    protected function signingKey(): Key
    {
        return self::$ecdsaKeys['private_ec512'];
    }

    /** {@inheritDoc} */
    public static function incompatibleKeys(): iterable
    {
        yield '256 bits' => ['private', 256];
        yield '384 bits' => ['private_ec384', 384];
    }
}
