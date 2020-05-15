<?php

namespace App\Classes;

class PdfGenerator
{
    private $title;
    private $subtitle;
    private $filename;
    private $html;

    public function title(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function subtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function filename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function html(string $html)
    {
        $this->html = $html;
        return $this;
    }


    public function generate()
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('');
        $pdf->SetAuthor('');
        $pdf->SetTitle($this->title);
        $pdf->SetHeaderData(null, null, $this->title, $this->subtitle);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        
        $pdf->writeHTML($this->html, true, false, true, false, '');
        $pdf->lastPage();

        return $pdf->Output($this->filename, 'I');
    }
}
