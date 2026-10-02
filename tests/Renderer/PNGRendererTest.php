<?php
declare(strict_types=1);

use Raxos\Barcode\Renderer\PNGRenderer;
use RaxosTests\Barcode\MatrixBarcode;

covers(PNGRenderer::class);

it('renders a valid PNG without leaking output into the caller buffer', function (): void {
    $renderer = new PNGRenderer(2, 1);
    ob_start();
    echo 'before';
    $png = $renderer->render(new MatrixBarcode([[true, false]]));
    echo 'after';
    expect(ob_get_clean())->toBe('beforeafter')->and($renderer->mimeType)->toBe('image/png')
        ->and(substr($png, 0, 8))->toBe("\x89PNG\r\n\x1a\n");
    $image = imagecreatefromstring($png);
    expect(imagesx($image))->toBe(6)->and(imagesy($image))->toBe(4);
});

it('restores the callers output buffer when rendering fails', function (): void {
    $level = ob_get_level();
    try {
        expect(fn () => new PNGRenderer(1, 0)->render(new MatrixBarcode([])))->toThrow(ValueError::class);
        expect(ob_get_level())->toBe($level);
    } finally {
        while (ob_get_level() > $level) {
            ob_end_clean();
        }
    }
});
