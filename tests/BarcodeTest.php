<?php
declare(strict_types=1);

use Raxos\Barcode\Barcode;
use Raxos\Barcode\Enum\BarcodeFormat;
use RaxosTests\Barcode\MatrixBarcode;

covers(Barcode::class);

it('derives dimensions from the encoded matrix and preserves the original data and format', function (): void {
    $matrix = [[true, false, true], [false, true, false]];
    $barcode = new MatrixBarcode($matrix);
    expect($barcode->data)->toBe('unit')->and($barcode->format)->toBe(BarcodeFormat::QR)
        ->and($barcode->matrix)->toBe($matrix)->and($barcode->width)->toBe(3)->and($barcode->height)->toBe(2)
        ->and(new MatrixBarcode([])->width)->toBe(0)->and(new MatrixBarcode([])->height)->toBe(0);
});

it('forwards render settings into PNG and SVG renderers', function (): void {
    $barcode = new MatrixBarcode([[true, false]]);
    $image = imagecreatefromstring($barcode->renderPng(3, 2, '#ffffff', '#ff0000'));
    expect(imagesx($image))->toBe(10)->and(imagesy($image))->toBe(7)->and(imagecolorat($image, 2, 2))->toBe(0xff0000);
    $svg = simplexml_load_string($barcode->renderSvg(3, 2, '#ffffff', '#ff0000'));
    expect((string)$svg['width'])->toBe('10')->and((string)$svg['height'])->toBe('7');
});
