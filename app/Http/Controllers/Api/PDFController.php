<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function gerar(Request $request)
    {
        $dados = $request->all();

        // Renderiza a view com os dados recebidos
        $pdf = Pdf::loadView('pdf.cotacao', ['dados' => $dados]);

        return $pdf->download('cotacao.pdf');
    }
}
