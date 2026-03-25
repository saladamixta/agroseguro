<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AgroAnalyzerService
{
    /**
     * Gera o relatório técnico completo usando OpenAI,
     * analisando TODOS os dados da nota (texto OCR, campos extraídos, Receita, base local).
     */
    public function analyze(array $payload): string
    {
        $apiKey = config('services.openai.key');
        $model  = config('services.openai.model', 'gpt-4.1');

        if (!$apiKey) {
            Log::error('OPENAI_API_KEY não configurada.');
            return 'Erro: OpenAI não configurada (OPENAI_API_KEY ausente).';
        }

        $rawTextoNota = $payload['raw_text'] ?? '';
        $dadosNota    = $payload['nota']     ?? [];
        $receitaEmit  = $payload['receita_emitente']  ?? null;
        $receitaComp  = $payload['receita_comprador'] ?? null;
        $autorizada   = $payload['empresa_autorizada'] ?? null;

        // PROMPT dizendo que tem que analisar a nota TODA, igual o relatório antigo
        $systemPrompt = <<<PROMPT
Você é um perito em fiscalização de agrotóxicos e análise de notas fiscais eletrônicas.

Seu trabalho é produzir um RELATÓRIO TÉCNICO COMPLETO, no mesmo estilo dos exemplos abaixo:

- Começa com o cabeçalho "AgroSeguro" na primeira linha e "scanner" na segunda.
- Depois vem a seção "Dados Gerais", listando:
  - Estado (UF) da operação, se conseguir deduzir.
  - Situação na base local de empresas: "Empresa encontrada na base", "Empresa NÃO encontrada na base", "Empresa INAPTA", etc.

- Em seguida, a seção "Dados da Receita Federal" com os principais campos do JSON da Receita:
  - Razão Social
  - Nome fantasia
  - CNPJ
  - Abertura
  - Situação
  - Telefone
  - E-mail
  - Endereço completo
  - Atividade principal (código + descrição)
  - Atividades secundárias relevantes

- Depois escreva uma seção "Parecer Técnico" detalhada, com blocos numerados como:
  1. PARECER TÉCNICO DE ANÁLISE DE NOTA FISCAL ELETRÔNICA
  2. CABEÇALHO – Dados extraídos + Validações + Conclusão do bloco
  3. DESTINATÁRIO OU REMETENTE – idem
  4. CÁLCULO DO IMPOSTO – idem
  5. TRANSPORTADOR E VOLUMES TRANSPORTADOS – idem
  6. DADOS DOS PRODUTOS OU SERVIÇOS – idem
  7. CÁLCULO DO ISSQN – se não se aplicar, explique
  8. DADOS ADICIONAIS – ex.: informações complementares, dados de pagamento, observações fiscais
  9. CONCLUSÕES FINAIS – resumo das conformidades/inconformidades
  10. FUNDAMENTAÇÃO LEGAL APLICÁVEL – cite dispositivos da Lei 7.802/1989, Decreto 4.074/2002, Resoluções ANTT e normas de ICMS/IPI quando forem pertinentes.

Em cada bloco:
- Liste primeiro os "Dados extraídos" a partir do texto da nota fiscal (OCR) e dos JSONs enviados.
- Depois escreva "**Validações:**" analisando se os dados estão coerentes com uma operação regular de venda de agrotóxicos
  (emitente autorizado, tributos destacados, dados de transporte, lote/validade, etc.).
- Termine com "**Conclusão do bloco:**" em frase única, dizendo CONFORMIDADE, INCONFORMIDADE ou GRAVE INCONFORMIDADE, com breve explicação.

Na seção 9 (Conclusões finais):
- Diga claramente se, com base em todas as informações, a operação aparenta ser REGULAR, IRREGULAR ou com GRAVE INCONFORMIDADE.
- Resuma as principais falhas encontradas.
- Faça recomendações de providências (rejeitar a NF, comunicar órgãos de fiscalização, aprofundar análise, etc.).

No rodapé:
- Inclua uma linha como: "Relatório gerado automaticamente · HASH interno do sistema."
- Não invente nomes de pessoas nem de órgãos que não estejam mencionados na nota ou na legislação padrão.

Regras importantes:
- Escreva sempre em português do Brasil.
- Não invente valores, datas ou CNPJs que não estejam nos dados.
- Se uma informação não aparecer nos dados, escreva "não informado".
- Analise a NOTA INTEIRA: cabeçalho, destinatário, produtos, tributos, transportador, dados adicionais, etc.
  Não foque apenas em emitente/destinatário.
- Use apenas texto simples (sem HTML), com quebras de linha e marcadores simples.
PROMPT;

        // juntamos tudo num JSON para o modelo ler
        $userData = [
            'nota_texto_ocr'        => $rawTextoNota,
            'nota_campos_extraidos' => $dadosNota,
            'empresa_autorizada'    => $autorizada,
            'receita_emitente'      => $receitaEmit,
            'receita_comprador'     => $receitaComp,
        ];

        $userPrompt = "A seguir estão os dados da nota fiscal, do CNPJ e da base local em formato JSON. Use TODAS as informações possíveis:\n\n"
            . json_encode($userData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        try {
            $response = Http::withToken($apiKey)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'       => $model,
                    'temperature' => 0.1,
                    'max_tokens'  => 4500,
                    'messages'    => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user',   'content' => $userPrompt],
                    ],
                ]);

            if ($response->failed()) {
                Log::error('Falha ao chamar OpenAI em AgroAnalyzerService', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return 'Erro ao gerar parecer via OpenAI (HTTP ' . $response->status() . ').';
            }

            $content = $response->json('choices.0.message.content');

            if (!is_string($content) || trim($content) === '') {
                Log::error('Resposta vazia da OpenAI em AgroAnalyzerService', [
                    'json' => $response->json(),
                ]);

                return 'Erro: OpenAI retornou resposta vazia ao gerar o parecer.';
            }

            return trim($content);
        } catch (\Throwable $e) {
            Log::error('Exceção ao chamar OpenAI em AgroAnalyzerService', [
                'error' => $e->getMessage(),
            ]);

            return 'Erro interno ao gerar o parecer: ' . $e->getMessage();
        }
    }
}
