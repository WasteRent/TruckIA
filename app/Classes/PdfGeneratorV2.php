<?php

namespace App\Classes;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PdfGeneratorV2
{
    private ?string $footer = null;

    private bool $skipFirstPageBottomMargin = false;

    private array $margins = [
        'marginTop' => '6mm',
        'marginRight' => '4mm',
        'marginBottom' => '20mm',
        'marginLeft' => '4mm',
    ];

    public function withFooter(string $footer): self
    {
        $this->footer = $footer;

        return $this;
    }

    public function withMargins(string $top, string $right, string $bottom, string $left): self
    {
        $this->margins = [
            'marginTop' => $top,
            'marginRight' => $right,
            'marginBottom' => $bottom,
            'marginLeft' => $left,
        ];

        return $this;
    }

    public function skipFirstPageBottomMargin(): self
    {
        $this->skipFirstPageBottomMargin = true;

        return $this;
    }

    public function generate(string $html): string
    {
        $htmlFile = tempnam(sys_get_temp_dir(), 'pdf_html_');
        $outputFile = tempnam(sys_get_temp_dir(), 'pdf_output_').'.pdf';

        file_put_contents($htmlFile, $html);

        $options = array_merge($this->margins, [
            'footer' => $this->footer,
            'skipFirstPageBottomMargin' => $this->skipFirstPageBottomMargin,
        ]);

        $scriptPath = base_path('libs/pdf-generator.js');
        $nodePath = config('services.playwright.node_binary', 'node');

        $process = new Process(
            [$nodePath, $scriptPath, $htmlFile, $outputFile],
            base_path(),
            null,
            json_encode($options),
            180 // 3 minutes timeout
        );

        $process->run();

        unlink($htmlFile);

        if (! $process->isSuccessful()) {
            if (file_exists($outputFile)) {
                unlink($outputFile);
            }
            throw new ProcessFailedException($process);
        }

        $pdfContent = file_get_contents($outputFile);
        unlink($outputFile);

        return $pdfContent;
    }
}
