<?php
declare(strict_types=1);

use Raxos\Barcode\Renderer\SVGRenderer;
use RaxosTests\Barcode\MatrixBarcode;

covers(SVGRenderer::class);

it('coalesces horizontal modules while preserving geometry and colors', function (): void {
    $renderer = new SVGRenderer(2, 3, '#ffffff', '#ff0000');
    $svg = simplexml_load_string($renderer->render(new MatrixBarcode([[true, true, false, true], [false, true, true, false]])));
    $rectangles = $svg->xpath('//*[local-name()="rect"]');
    expect($renderer->mimeType)->toBe('image/svg+xml')->and((string)$svg['width'])->toBe('14')
        ->and((string)$svg['height'])->toBe('10')->and($rectangles)->toHaveCount(4)
        ->and((string)$rectangles[1]['x'])->toBe('3')->and((string)$rectangles[1]['y'])->toBe('3')
        ->and((string)$rectangles[1]['width'])->toBe('4')->and((string)$rectangles[1]['height'])->toBe('2')
        ->and((string)$rectangles[3]['x'])->toBe('5')->and((string)$rectangles[3]['y'])->toBe('5');
});

it('escapes color attributes so supplied values cannot inject SVG markup', function (): void {
    $color = 'red"/><script>unit</script><rect fill="red';
    $output = new SVGRenderer(backgroundColor: $color, foregroundColor: $color)->render(new MatrixBarcode([[true]]));
    $xml = simplexml_load_string($output);
    expect($xml->xpath('//*[local-name()="script"]'))->toBe([])
        ->and((string)$xml->xpath('//*[local-name()="rect"]')[0]['fill'])->toBe($color);
});
