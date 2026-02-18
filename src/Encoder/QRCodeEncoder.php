<?php
declare(strict_types=1);

namespace Raxos\Barcode\Encoder;

use chillerlan\QRCode\Common\{EccLevel, MaskPattern, Mode};
use chillerlan\QRCode\Data\{QRData, QRDataModeInterface};
use chillerlan\QRCode\QROptions;
use Raxos\Barcode\Enum\QRCodeErrorCorrectionLevel;
use Raxos\Contract\Barcode\EncoderInterface;

/**
 * Class QRCodeEncoder
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Barcode\Encoder
 * @since 2.1.0
 */
final readonly class QRCodeEncoder implements EncoderInterface
{

    /**
     * QRCodeEncoder constructor.
     *
     * @param QRCodeErrorCorrectionLevel $errorCorrectionLevel
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function __construct(
        public QRCodeErrorCorrectionLevel $errorCorrectionLevel = QRCodeErrorCorrectionLevel::M
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.1.0
     */
    public function encode(string $data): array
    {
        $segments = [];

        /** @var QRDataModeInterface $dataInterface */
        foreach (Mode::INTERFACES as $dataInterface) {
            if (!$dataInterface::validateString($data)) {
                continue;
            }

            $segments[] = new $dataInterface($data);
            break;
        }

        $options = new QROptions();
        $options->eccLevel = match ($this->errorCorrectionLevel) {
            QRCodeErrorCorrectionLevel::L => EccLevel::L,
            QRCodeErrorCorrectionLevel::M => EccLevel::M,
            QRCodeErrorCorrectionLevel::Q => EccLevel::Q,
            QRCodeErrorCorrectionLevel::H => EccLevel::H,
        };

        $data = new QRData($options, $segments);
        $matrix = $data->writeMatrix();

        $maskPattern = MaskPattern::getBestPattern($matrix);
        $matrix->setFormatInfo($maskPattern)->mask($maskPattern);

        return $matrix->getMatrix(true);
    }

}
