<?php
declare(strict_types=1);

namespace Raxos\Barcode;

use Raxos\Barcode\Enum\BarcodeFormat;
use Raxos\Contract\Barcode\{BarcodeInterface, EncoderInterface};
use function count;

/**
 * Class Barcode
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode
 * @since 2.1.0
 */
abstract readonly class Barcode implements BarcodeInterface
{

    public int $height;
    public int $width;
    public array $matrix;

    /**
     * Barcode constructor.
     *
     * @param string $data
     * @param BarcodeFormat $format
     * @param EncoderInterface $encoder
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function __construct(
        public string $data,
        public BarcodeFormat $format,
        protected EncoderInterface $encoder
    )
    {
        $this->matrix = $this->encoder->encode($this->data);

        $this->height = count($this->matrix);
        $this->width = isset($this->matrix[0]) ? count($this->matrix[0]) : 0;
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function renderPng(
        int $scale = 8,
        int $margin = 16,
        string $backgroundColor = '#ffffff',
        string $foregroundColor = '#000000'
    ): string
    {
        return new Renderer\PNGRenderer(
            $scale,
            $margin,
            $backgroundColor,
            $foregroundColor
        )->render($this);
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function renderSvg(
        int $scale = 8,
        int $margin = 16,
        string $backgroundColor = '#ffffff',
        string $foregroundColor = '#000000'
    ): string
    {
        return new Renderer\SVGRenderer(
            $scale,
            $margin,
            $backgroundColor,
            $foregroundColor
        )->render($this);
    }

}
