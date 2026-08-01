<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfHelper
{
    public static function generate(string $html, string $filename = 'document.pdf')
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
