<?php
declare(strict_types=1);

use Raxos\Barcode\Renderer\GDRenderer;
use Raxos\Contract\Barcode\BarcodeInterface;
use RaxosTests\Barcode\MatrixBarcode;

covers(GDRenderer::class);

it('fills the quiet zone and paints exactly the occupied module pixels', function (): void {
    $renderer = new readonly class(2, 1, '#ffffff', '#ff0000') extends GDRenderer {
        public string $mimeType;

        public function __construct(int $scale, int $margin, string $background, string $foreground)
        {
            parent::__construct($scale, $margin, $background, $foreground);
            $this->mimeType = 'image/png';
        }

        public function render(BarcodeInterface $barcode): string
        {
            return '';
        }

        public function image(BarcodeInterface $barcode): GdImage
        {
            return $this->createImage($barcode);
        }
    };
    $image = $renderer->image(new MatrixBarcode([[true, false], [false, true]]));
    expect(imagesx($image))->toBe(6)->and(imagesy($image))->toBe(6);
    for ($y = 0; $y < 6; $y++) {
        for ($x = 0; $x < 6; $x++) {
            $occupied = ($x >= 1 && $x <= 2 && $y >= 1 && $y <= 2) || ($x >= 3 && $x <= 4 && $y >= 3 && $y <= 4);
            expect(imagecolorat($image, $x, $y))->toBe($occupied ? 0xff0000 : 0xffffff);
        }
    }
});
