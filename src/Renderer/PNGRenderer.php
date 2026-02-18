<?php
declare(strict_types=1);

namespace Raxos\Barcode\Renderer;

use Raxos\Contract\Barcode\BarcodeInterface;
use function imagepng;
use function ob_get_clean;
use function ob_start;

/**
 * Class PNGRenderer
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Renderer
 * @since 2.1.0
 */
final readonly class PNGRenderer extends GDRenderer
{

    public string $mimeType;

    /**
     * PNGRenderer constructor.
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

        $this->mimeType = 'image/png';
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function render(BarcodeInterface $barcode): string
    {
        ob_start();
        imagepng($this->createImage($barcode));

        return ob_get_clean();
    }

}
