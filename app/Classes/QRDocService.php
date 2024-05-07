<?php

namespace App\Classes;

class QRDocService
{
    public function generate(string $html)
    {
        $snappy = new \Knp\Snappy\Pdf(env('WKHTML_PDF_BINARY'));

        return $snappy->getOutputFromHtml($html, [
            'margin-bottom' => '3',
            'margin-left' => '0',
            'margin-right' => '0',
            'margin-top' => '3',
        ]);
    }
}
