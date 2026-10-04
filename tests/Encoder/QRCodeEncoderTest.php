<?php
declare(strict_types=1);

use Raxos\Barcode\Encoder\QRCodeEncoder;
use Raxos\Barcode\Enum\QRCodeErrorCorrectionLevel;

covers(QRCodeEncoder::class);

it('creates deterministic square boolean matrices for every correction level', function (QRCodeErrorCorrectionLevel $level): void {
    $encoder = new QRCodeEncoder($level);
    $matrix = $encoder->encode('1234567890');
    expect($encoder->encode('1234567890'))->toBe($matrix)->and($encoder->encode('1234567891'))->not->toBe($matrix);
    foreach ($matrix as $row) {
        expect(count($row))->toBe(count($matrix))->and(array_all($row, static fn(mixed $module): bool => is_bool($module)))->toBeTrue();
    }
})->with(QRCodeErrorCorrectionLevel::cases());
