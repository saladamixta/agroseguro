@extends('layouts.app')

@section('content')
    <section class="grid gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                        Histórico
                    </div>
                    <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">
                        Minhas análises
                    </h1>
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">
                        Consulte as notas já processadas, acompanhe o status de cada análise
                        e abra o resultado completo sempre que precisar revisar os dados.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('agro.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                        + Nova análise de nota
                    </a>
                </div>
            </div>
        </div>

        @if($scans->isEmpty())
            <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                    📄
                </div>
                <h2 class="mt-4 text-xl font-bold text-slate-900">
                    Nenhuma análise encontrada
                </h2>
                <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                    Você ainda não possui notas analisadas. Envie seu primeiro arquivo para começar
                    o processamento do OCR e a geração do parecer.
                </p>

                <div class="mt-6">
                    <a href="{{ route('agro.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                        Enviar primeira análise
                    </a>
                </div>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Total
                    </div>
                    <div class="mt-3 text-2xl font-bold text-slate-900">
                        {{ $scans->total() }}
                    </div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        análises registradas no histórico.
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Página atual
                    </div>
                    <div class="mt-3 text-2xl font-bold text-slate-900">
                        {{ $scans->currentPage() }}
                    </div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        navegação paginada da consulta.
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Exibindo
                    </div>
                    <div class="mt-3 text-2xl font-bold text-slate-900">
                        {{ $scans->count() }}
                    </div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        itens nesta página.
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Ação
                    </div>
                    <div class="mt-3 text-lg font-bold text-slate-900">
                        Revisão rápida
                    </div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        abra qualquer análise para ver OCR, parecer e arquivos.
                    </p>
                </div>
            </div>

            <div class="space-y-4 xl:hidden">
                @foreach($scans as $scan)
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Análise #{{ $scan->id }}
                                </div>
                                <div class="mt-2 text-base font-bold text-slate-900">
                                    {{ $scan->cnpj_emitente ?? 'CNPJ não identificado' }}
                                </div>
                            </div>

                            @php
                                $status = strtoupper((string) $scan->status);
                                $statusClasses = match ($scan->status) {
                                    'concluido', 'concluida', 'finalizado', 'finalizada' => 'bg-emerald-100 text-emerald-800',
                                    'erro', 'falha' => 'bg-red-100 text-red-800',
                                    'processando', 'em_processamento', 'pendente' => 'bg-amber-100 text-amber-800',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp

                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $statusClasses }}">
                                {{ $status ?: 'SEM STATUS' }}
                            </span>
                        </div>

                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                    Valor
                                </div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $scan->valor_total ? 'R$ '.number_format($scan->valor_total, 2, ',', '.') : '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                    Criado em
                                </div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $scan->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-200 p-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                Empresa autorizada
                            </div>

                            <div class="mt-2">
                                @if(is_null($scan->empresa_autorizada))
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        Não consta
                                    </span>
                                @elseif($scan->empresa_autorizada)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                        Autorizada
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                        Não autorizada
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="{{ route('agro.show', $scan) }}"
                               class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                Ver análise completa
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm xl:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">CNPJ emitente</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Valor</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Empresa autorizada</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Criado em</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($scans as $scan)
                                @php
                                    $status = strtoupper((string) $scan->status);
                                    $statusClasses = match ($scan->status) {
                                        'concluido', 'concluida', 'finalizado', 'finalizada' => 'bg-emerald-100 text-emerald-800',
                                        'erro', 'falha' => 'bg-red-100 text-red-800',
                                        'processando', 'em_processamento', 'pendente' => 'bg-amber-100 text-amber-800',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp

                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                        {{ $scan->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700">
                                        {{ $scan->cnpj_emitente ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700">
                                        {{ $scan->valor_total ? 'R$ '.number_format($scan->valor_total, 2, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if(is_null($scan->empresa_autorizada))
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                                Não consta
                                            </span>
                                        @elseif($scan->empresa_autorizada)
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                                Autorizada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                                Não autorizada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $statusClasses }}">
                                            {{ $status ?: 'SEM STATUS' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700">
                                        {{ $scan->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('agro.show', $scan) }}"
                                           class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:px-6">
                {{ $scans->links() }}
            </div>
        @endif
    </section>
@endsection