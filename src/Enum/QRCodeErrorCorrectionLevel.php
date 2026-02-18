<?php
declare(strict_types=1);

namespace Raxos\Barcode\Enum;

/**
 * Enum QRCodeErrorCorrectionLevel
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Enum
 * @since 2.1.0
 */
enum QRCodeErrorCorrectionLevel: int
{
    case L = 0;
    case M = 1;
    case Q = 2;
    case H = 3;
}
