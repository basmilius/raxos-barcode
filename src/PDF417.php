<?php
declare(strict_types=1);

namespace Raxos\Barcode;

use Raxos\Barcode\Encoder\PDF417Encoder;
use Raxos\Barcode\Enum\BarcodeFormat;

/**
 * Class PDF417
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode
 * @since 2.1.0
 */
final readonly class PDF417 extends Barcode
{

    /**
     * PDF417 constructor.
     *
     * @param string $data
     * @param int $columns
     * @param int $securityLevel
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function __construct(
        string $data,
        public int $columns = 4,
        public int $securityLevel = 2
    )
    {
        parent::__construct($data, BarcodeFormat::PDF417, new PDF417Encoder($this->columns, $this->securityLevel));
    }

}
