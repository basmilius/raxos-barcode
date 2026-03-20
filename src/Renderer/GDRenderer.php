<?php
declare(strict_types=1);

namespace Raxos\Barcode\Renderer;

use GdImage;
use Raxos\Contract\Barcode\BarcodeInterface;
use Raxos\Foundation\Util\ColorUtil;
use RuntimeException;
use function imagecolorallocate;
use function imagecreatetruecolor;
use function imagefill;
use function imagefilledrectangle;

/**
 * Class GDRenderer
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Renderer
 * @since 2.1.0
 */
abstract readonly class GDRenderer extends Renderer
{

    /**
     * Renders the barcode to a GD image.
     *
     * @param BarcodeInterface $barcode
     *
     * @return GdImage
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    protected function createImage(BarcodeInterface $barcode): GdImage
    {
        $matrix = $barcode->matrix;
        $matrixHeight = $barcode->height;
        $matrixWidth = $barcode->width;

        $imageWidth = $matrixWidth * $this->scale + $this->margin * 2;
        $imageHeight = $matrixHeight * $this->scale + $this->margin * 2;

        $image = imagecreatetruecolor($imageWidth, $imageHeight);

        if ($image === false) {
            throw new RuntimeException('Failed to create image.');
        }

        $background = imagecolorallocate($image, ...ColorUtil::hexToRgb($this->backgroundColor));
        $foreground = imagecolorallocate($image, ...ColorUtil::hexToRgb($this->foregroundColor));

        imagefill($image, 0, 0, $background);

        foreach ($matrix as $y => $row) {
            foreach ($row as $x => $column) {
                if (!$column) {
                    continue;
                }

                $x1 = $this->margin + $x * $this->scale;
                $y1 = $this->margin + $y * $this->scale;
                $x2 = $x1 + $this->scale - 1;
                $y2 = $y1 + $this->scale - 1;

                imagefilledrectangle($image, $x1, $y1, $x2, $y2, $foreground);
            }
        }

        return $image;
    }

}
