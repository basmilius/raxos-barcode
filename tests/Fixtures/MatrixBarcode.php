<?php
declare(strict_types=1);

namespace RaxosTests\Barcode;

use Raxos\Barcode\Barcode;
use Raxos\Barcode\Enum\BarcodeFormat;
use Raxos\Contract\Barcode\EncoderInterface;

final readonly class MatrixBarcode extends Barcode
{
    public function __construct(array $matrix)
    {
        parent::__construct('unit', BarcodeFormat::QR, new readonly class($matrix) implements EncoderInterface {
            public function __construct(private array $matrix) {}

            public function encode(string $data): array
            {
                return $this->matrix;
            }
        });
    }
}
