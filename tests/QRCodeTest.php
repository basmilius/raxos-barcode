<?php
declare(strict_types=1);

use chillerlan\QRCode\QRCode as QRReader;
use Raxos\Barcode\Enum\{BarcodeFormat, QRCodeErrorCorrectionLevel};
use Raxos\Barcode\QRCode;

covers(QRCode::class);

it('produces readable PNG codes for numeric, text and Unicode payloads at each correction level', function (string $payload, QRCodeErrorCorrectionLevel $level): void {
    $barcode = new QRCode($payload, $level);
    $decoded = new QRReader()->readFromBlob($barcode->renderPng(4, 16));
    expect((string)$decoded)->toBe($payload)->and($barcode->format)->toBe(BarcodeFormat::QR)
        ->and($barcode->data)->toBe($payload)->and($barcode->width)->toBe($barcode->height)
        ->and($barcode->errorCorrectionLevel)->toBe($level);
})->with(['0', '123456789012345', 'HELLO WORLD', 'Passly é😀'])->with(QRCodeErrorCorrectionLevel::cases());
