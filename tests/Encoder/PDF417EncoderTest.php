<?php
declare(strict_types=1);

use Raxos\Barcode\Encoder\PDF417Encoder;
use Raxos\Error\InvalidArgumentException;

covers(PDF417Encoder::class);

it('encodes different accepted payloads into different matrices', function (): void {
    $encoder = new PDF417Encoder(4, 2);
    $first = $encoder->encode('Raxos 1234567890');
    expect($first)->not->toBe($encoder->encode('Raxos 1234567891'));
    expect(count($first))->toBeGreaterThanOrEqual(3);
    expect(count($first))->toBeLessThanOrEqual(90);
});

it('rejects payloads exceeding the selected dimensions instead of truncating', function (): void {
    $encoder = new PDF417Encoder(4, 2);
    expect(fn() => $encoder->encode(str_repeat('A', 1_000) . 'X'))->toThrow(InvalidArgumentException::class);
    expect(fn() => $encoder->encode(str_repeat('A', 1_000) . 'Y'))->toThrow(InvalidArgumentException::class);
});
