<?php
declare(strict_types=1);

namespace Raxos\Barcode\Renderer;

use Raxos\Contract\Barcode\BarcodeInterface;
use function count;
use function implode;
use function sprintf;

/**
 * Class SVGRenderer
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Renderer
 * @since 2.1.0
 */
final readonly class SVGRenderer extends Renderer
{

    public string $mimeType;

    /**
     * SVGRenderer constructor.
     *
     * @param int $scale
     * @param int $margin
     * @param string $backgroundColor
     * @param string $foregroundColor
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function __construct(
        int $scale = 8,
        int $margin = 16,
        string $backgroundColor = '#ffffff',
        string $foregroundColor = '#000000'
    )
    {
        parent::__construct($scale, $margin, $backgroundColor, $foregroundColor);

        $this->mimeType = 'image/svg+xml';
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function render(BarcodeInterface $barcode): string
    {
        $matrix = $barcode->matrix;
        $matrixWidth = $barcode->width;
        $matrixHeight = $barcode->height;

        $imageWidth = ($matrixWidth * $this->scale) + ($this->margin * 2);
        $imageHeight = ($matrixHeight * $this->scale) + ($this->margin * 2);

        $svg = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $svg .= sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="%d" height="%d" viewBox="0 0 %d %d">' . "\n",
            $imageWidth,
            $imageHeight,
            $imageWidth,
            $imageHeight
        );

        $svg .= sprintf(
            '<rect width="100%%" height="100%%" fill="%s"/>',
            $this->backgroundColor
        );

        $svg .= $this->generatePaths($matrix);
        $svg .= '</svg>';

        return $svg;
    }

    /**
     * Generate the data paths.
     *
     * @param array $matrix
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    private function generatePaths(array $matrix): string
    {
        $paths = [];

        foreach ($matrix as $y => $row) {
            $x = 0;

            while ($x < count($row)) {
                if ($row[$x]) {
                    $width = 1;

                    while (($x + $width) < count($row) && $row[$x + $width]) {
                        $width++;
                    }

                    $rectX = $this->margin + ($x * $this->scale);
                    $rectY = $this->margin + ($y * $this->scale);
                    $rectWidth = $width * $this->scale;
                    $rectHeight = $this->scale;

                    $paths[] = sprintf(
                        '<rect x="%d" y="%d" width="%d" height="%d" fill="%s"/>',
                        $rectX,
                        $rectY,
                        $rectWidth,
                        $rectHeight,
                        $this->foregroundColor
                    );

                    $x += $width;
                } else {
                    $x++;
                }
            }
        }

        return implode($paths);
    }

}
