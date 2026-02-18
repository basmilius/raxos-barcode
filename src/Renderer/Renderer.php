<?php
declare(strict_types=1);

namespace Raxos\Barcode\Renderer;

use Raxos\Contract\Barcode\RendererInterface;

/**
 * Class Renderer
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Renderer
 * @since 2.1.0
 */
abstract readonly class Renderer implements RendererInterface
{

    /**
     * Renderer constructor.
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
        public int $scale,
        public int $margin,
        public string $backgroundColor,
        public string $foregroundColor
    ) {}

}
