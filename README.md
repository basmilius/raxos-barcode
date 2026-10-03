<a href="https://bas.dev">
    <img src="https://bmcdn.nl/assets/branding/logo.svg" alt="Bas Milius" height="48" />
</a>

---

# Raxos Barcode

Generate QR codes and PDF417 barcodes, then render them as PNG bytes or SVG documents.

[Documentation](https://raxos.dev/barcode/) | [Packagist](https://packagist.org/packages/raxos/barcode) | [Raxos](https://github.com/basmilius/raxos)

- QR error correction levels L, M, Q and H.
- PDF417 column and security-level configuration, with payload capacity checks.
- Configurable scale, margins and foreground/background colors.

## Installation

Requires PHP 8.5 or later. Enable the `ctype`, `gd` PHP extensions. Composer checks the remaining package and extension dependencies declared in [composer.json](composer.json).

```sh
composer require "raxos/barcode:^3.2"
```

## Usage

```php
<?php
declare(strict_types=1);

use Raxos\Barcode\Enum\QRCodeErrorCorrectionLevel;
use Raxos\Barcode\PDF417;
use Raxos\Barcode\QRCode;

require __DIR__ . '/vendor/autoload.php';

$qr = new QRCode('https://example.com/tickets/42', QRCodeErrorCorrectionLevel::H);
$pdf417 = new PDF417('TICKET-0042', columns: 6, securityLevel: 3);

$png = $qr->renderPng(scale: 6, margin: 12);
$svg = $pdf417->renderSvg(scale: 4);
```

Render methods return strings. Write them to a file or serve them with the matching MIME type (`image/png` or `image/svg+xml`). The GD extension is a declared package requirement.

## Documentation

- [Creating barcodes](https://raxos.dev/barcode/creating-barcodes)
- [Rendering to PNG or SVG](https://raxos.dev/barcode/rendering)

## Testing

Run this library's Pest suite from the Raxos workspace:

```sh
git clone --recurse-submodules https://github.com/basmilius/raxos.git
cd raxos
composer install
vendor/bin/pest --testsuite=barcode
```

See [Testing Raxos](https://github.com/basmilius/raxos/blob/main/TESTING.md) for PHP extensions, integration services and coverage commands. The library's [Tests workflow](.github/workflows/tests.yml) also runs in GitHub Actions.

## License

[MIT](LICENSE). Copyright (c) 2017 - present Bas Milius.
