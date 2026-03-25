<?php

namespace App\Http\Controllers;

use App\Models\AgroScan;
use App\Services\OcrService;
use App\Services\NotaFiscalParser;
use App\Services\CnpjService;
use App\Services\EmpresasAutorizadasService;
use App\Services\AgroAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgroScanController extends Controller
{
    public function index()
    {
        $scans = AgroScan::latest()->paginate(15);

        return view('agro.index', compact('scans'));
    }

    public function create()
    {
        return view('agro.create');
    }

    public function store(
    Request $request,
    OcrService $ocr,
    NotaFiscalParser $parser,
    CnpjService $cnpjService,
    EmpresasAutorizadasService $empresasService,
    AgroAnalyzerService $analyzer
) {
    $request->validate([
        'nota' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf'],
    ]);

    // 1) salva arquivo
    $path = $request->file('nota')->store('agro_notas', 'public');

    // 2) cria registro inicial
    $scan = AgroScan::create([
        'user_id'   => Auth::id() ?? 1, // ou outro padrão que você usar
        'file_path' => $path,
        'status'    => 'processing',
    ]);

    try {
        // 3) OCR (Azure) -> texto completo da nota
        $rawText = $ocr->extractTextFromStorage($path);

        if (!$rawText || !is_string($rawText)) {
            throw new \RuntimeException('Resposta inválida do OCR.');
        }

        // 4) Parser: tenta extrair CNPJ, valor, data, etc. do TEXTO COMPLETO
        $dadosNota     = $parser->parse($rawText);
        $cnpjEmitente  = $dadosNota['cnpj_emitente']  ?? null;
        $cnpjComprador = $dadosNota['cnpj_comprador'] ?? null;

        // 5) Consulta ReceitaWS (se houver CNPJ)
        $dadosReceitaEmitente  = $cnpjEmitente  ? $cnpjService->getDados($cnpjEmitente)  : null;
        $dadosReceitaComprador = $cnpjComprador ? $cnpjService->getDados($cnpjComprador) : null;

        // 6) Verifica se emitente está na base de empresas autorizadas
        $empresaAutorizada = $empresasService->isAutorizada($cnpjEmitente);

        // 7) Monta payload COMPLETO para a OpenAI
        $payload = [
            'raw_text'           => $rawText,               // TEXTO COMPLETO da nota (do Azure)
            'nota'               => $dadosNota,             // campos extraídos (CNPJ, valor, data etc.)
            'empresa_autorizada' => $empresaAutorizada,     // true/false ou texto
            'receita_emitente'   => $dadosReceitaEmitente,  // JSON grande da ReceitaWS
            'receita_comprador'  => $dadosReceitaComprador, // se quiser analisar também
        ];

        // 8) OpenAI gera o RELATÓRIO COMPLETO (vários blocos, igual sistema antigo)
        $parecer = $analyzer->analyze($payload);

        // 9) Atualiza registro no banco
        $scan->update([
            'raw_text'       => $rawText,                       // guarda o texto OCR bruto
            'cnpj_emitente'  => $cnpjEmitente,
            'cnpj_comprador' => $cnpjComprador,
            'valor_total'    => $dadosNota['valor_total']  ?? null,
            'data_emissao'   => $dadosNota['data_emissao'] ?? null,

            'dados_receita_emitente'  => $dadosReceitaEmitente,
            'dados_receita_comprador' => $dadosReceitaComprador,

            'empresa_autorizada' => $empresaAutorizada,
            'parecer_texto'      => $parecer,   // aqui vai o relatórião completo
            'status'             => 'done',
            'error_message'      => null,
        ]);
    } catch (\Throwable $e) {
        \Log::error('Erro ao processar AgroScan', [
            'scan_id' => $scan->id,
            'message' => $e->getMessage(),
        ]);

        $scan->update([
            'status'        => 'error',
            'error_message' => $e->getMessage(),
        ]);
    }

    return redirect()->route('agro.show', $scan);
}


    public function show(AgroScan $scan)
    {
        return view('agro.show', compact('scan'));
    }

    public function downloadFile(AgroScan $scan)
    {
        return Storage::disk('public')->download($scan->file_path);
    }
}
