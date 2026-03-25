@extends('layouts.app')

@section('content')
    @php
        $status = strtolower((string) $scan->status);
        $statusLabel = strtoupper((string) $scan->status ?: 'sem status');

        $statusClasses = match ($status) {
            'concluido', 'concluida', 'finalizado', 'finalizada' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'erro', 'error', 'falha' => 'bg-red-100 text-red-800 border-red-200',
            'processando', 'em_processamento', 'pendente' => 'bg-amber-100 text-amber-800 border-amber-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    @endphp

    <section class="grid gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <div class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                        Resultado da análise
                    </div>

                    <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">
                        Análise #{{ $scan->id }}
                    </h1>

                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">
                        Visualize os dados principais da nota, acompanhe o status do processamento,
                        consulte o parecer completo e revise o texto bruto extraído pelo OCR.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('agro.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        ← Voltar
                    </a>

                    @if($scan->file_path)
                        <a href="{{ route('agro.download', $scan) }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                            Baixar arquivo da nota
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    Status
                </div>
                <div class="mt-3">
                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] {{ $statusClasses }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    CNPJ emitente
                </div>
                <div class="mt-3 text-base font-bold text-slate-900 break-all">
                    {{ $scan->cnpj_emitente ?? '-' }}
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    CNPJ comprador
                </div>
                <div class="mt-3 text-base font-bold text-slate-900 break-all">
                    {{ $scan->cnpj_comprador ?? '-' }}
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    Valor total
                </div>
                <div class="mt-3 text-base font-bold text-slate-900">
                    {{ $scan->valor_total ? 'R$ '.number_format($scan->valor_total, 2, ',', '.') : '-' }}
                </div>
            </div>
        </div>

        @if($scan->status === 'error' || $scan->status === 'erro')
            <div class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <div class="text-sm font-bold text-red-800">
                    Erro no processamento
                </div>
                <p class="mt-2 text-sm leading-6 text-red-700">
                    {{ $scan->error_message ?: 'Ocorreu um erro durante a análise.' }}
                </p>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">
                        Dados principais
                    </h2>

                    <div class="mt-5 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                CNPJ emitente
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900 break-all">
                                {{ $scan->cnpj_emitente ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                CNPJ comprador
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900 break-all">
                                {{ $scan->cnpj_comprador ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                Valor total
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $scan->valor_total ? 'R$ '.number_format($scan->valor_total, 2, ',', '.') : '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                Data de emissão
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $scan->data_emissao?->format('d/m/Y') ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                Empresa autorizada
                            </div>
                            <div class="mt-2">
                                @if(is_null($scan->empresa_autorizada))
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        Não consta na base
                                    </span>
                                @elseif($scan->empresa_autorizada)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                        Sim, autorizada
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                        Não autorizada
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">
                        Ações
                    </h2>

                    <div class="mt-5 space-y-3">
                        @if($scan->file_path)
                            <a href="{{ route('agro.download', $scan) }}"
                               class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                                <span>Baixar arquivo original</span>
                                <span class="text-emerald-700">→</span>
                            </a>
                        @endif

                        <a href="{{ route('agro.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                            <span>Voltar ao histórico</span>
                            <span class="text-emerald-700">→</span>
                        </a>

                        <a href="{{ route('agro.create') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                            <span>Nova análise</span>
                            <span class="text-emerald-700">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @if($scan->parecer_texto)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-lg font-bold text-slate-900">
                                Parecer completo
                            </h2>
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-emerald-700">
                                Resultado
                            </span>
                        </div>

                        <div class="mt-5 rounded-2xl bg-slate-50 p-4 sm:p-5">
                            <pre class="whitespace-pre-wrap break-words font-sans text-sm leading-7 text-slate-700">{{ $scan->parecer_texto }}</pre>
                        </div>
                    </div>
                @endif

                @if($scan->raw_text)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-bold text-slate-900">
                                Texto OCR (bruto)
                            </h3>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-700">
                                OCR
                            </span>
                        </div>

                        <div class="mt-5 max-h-[420px] overflow-auto rounded-2xl border border-slate-200 bg-slate-950 p-4 sm:p-5">
                            <pre class="whitespace-pre-wrap break-words font-mono text-xs leading-6 text-slate-100">{{ $scan->raw_text }}</pre>
                        </div>
                    </div>
                @endif

                @if(!$scan->parecer_texto && !$scan->raw_text)
                    <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                            ⏳
                        </div>
                        <h2 class="mt-4 text-xl font-bold text-slate-900">
                            Conteúdo ainda indisponível
                        </h2>
                        <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                            Esta análise ainda não possui texto OCR ou parecer final disponível para exibição.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection