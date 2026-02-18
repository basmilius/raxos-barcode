<?php
declare(strict_types=1);

namespace Raxos\Barcode\Enum;

/**
 * Enum BarcodeFormat
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Enum
 * @since 2.1.0
 */
enum BarcodeFormat: string
{
//    case AZTEC = 'aztec';
//    case CODE128 = 'code128';
//    case DATAMATRIX = 'datamatrix';
//    case EAN13 = 'ean13';
    case PDF417 = 'pdf417';
    case QR = 'qr';
}
