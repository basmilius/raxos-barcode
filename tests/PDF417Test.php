<?php
declare(strict_types=1);

use Raxos\Barcode\Enum\BarcodeFormat;
use Raxos\Barcode\PDF417;

covers(PDF417::class);

it('preserves PDF417 settings and exposes a rectangular encoded matrix', function (): void {
    $barcode = new PDF417('Raxos 1234567890', 6, 3);
    expect($barcode->data)->toBe('Raxos 1234567890')->and($barcode->format)->toBe(BarcodeFormat::PDF417)
        ->and($barcode->columns)->toBe(6)->and($barcode->securityLevel)->toBe(3)
        ->and($barcode->width)->toBe(171)->and($barcode->height)->toBeGreaterThanOrEqual(3);
    foreach ($barcode->matrix as $row) {
        expect(count($row))->toBe($barcode->width);
    }
});
