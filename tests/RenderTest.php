<?php
declare(strict_types=1);

use Raxos\Barcode\Enum\QRCodeErrorCorrectionLevel;
use Raxos\Barcode\QRCode;

it('renders valid PNG and SVG at every QR correction level', function (QRCodeErrorCorrectionLevel $level): void {
    $qr = new QRCode('https://passly.example/é😀', $level);
    $png = $qr->renderPng(scale: 2, margin: 4);
    $image = imagecreatefromstring($png);
    expect($image)->toBeInstanceOf(GdImage::class)
        ->and(imagesx($image))->toBe($qr->width * 2 + 8)
        ->and(imagesy($image))->toBe($qr->height * 2 + 8)
        ->and($qr->width)->toBe($qr->height);
    $svg = simplexml_load_string($qr->renderSvg(scale: 2, margin: 4));
    expect($svg->getName())->toBe('svg')->and((string)$svg['width'])->toBe((string)($qr->width * 2 + 8));
})->with(QRCodeErrorCorrectionLevel::cases());

it('selects a larger QR version as the payload grows', function (): void {
    $short = new QRCode('A');
    $long = new QRCode(str_repeat('A', 250));
    expect($short->width)->toBe(21)->and($long->width)->toBeGreaterThan($short->width);
});
