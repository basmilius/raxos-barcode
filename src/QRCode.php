<?php
declare(strict_types=1);

namespace Raxos\Barcode;

use Raxos\Barcode\Encoder\QRCodeEncoder;
use Raxos\Barcode\Enum\{BarcodeFormat, QRCodeErrorCorrectionLevel};

/**
 * Class QRCode
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode
 * @since 2.1.0
 */
final readonly class QRCode extends Barcode
{

    /**
     * QRCode constructor.
     *
     * @param string $data
     * @param QRCodeErrorCorrectionLevel $errorCorrectionLevel
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function __construct(
        string $data,
        public QRCodeErrorCorrectionLevel $errorCorrectionLevel = QRCodeErrorCorrectionLevel::M
    )
    {
        parent::__construct($data, BarcodeFormat::QR, new QRCodeEncoder($errorCorrectionLevel));
    }

}
