<?php
declare(strict_types=1);

namespace Raxos\Barcode\Renderer;

use Raxos\Contract\Barcode\BarcodeInterface;
use RuntimeException;
use Throwable;
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

    /**
     * Advertises the renderer's output media type to HTTP consumers.
     *
     * @var string
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
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
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function render(BarcodeInterface $barcode): string
    {
        ob_start();

        try {
            imagepng($this->createImage($barcode));
            $result = ob_get_clean();
        } catch (Throwable $err) {
            ob_end_clean();

            throw $err;
        }

        if ($result === false) {
            throw new RuntimeException('Failed to capture PNG output.');
        }

        return $result;
    }

}
