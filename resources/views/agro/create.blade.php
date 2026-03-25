@extends('layouts.app')

@section('content')
    <section class="grid gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                        Nova análise
                    </div>
                    <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">
                        Enviar nota fiscal para análise
                    </h1>
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">
                        Faça o upload da nota em imagem ou PDF para iniciar o processamento do OCR
                        e a geração do parecer. O envio foi reorganizado para ficar mais claro,
                        moderno e confortável em desktop e mobile.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('agro.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Voltar ao histórico
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('agro.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Arquivo da nota
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            Selecione um arquivo em formato de imagem ou PDF. O sistema fará a leitura
                            do conteúdo e seguirá com a análise automática.
                        </p>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-emerald-200 bg-emerald-50/50 p-5 sm:p-6">
                        <label for="nota" class="block cursor-pointer">
                            <span class="mb-3 inline-flex items-center rounded-full bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700 shadow-sm">
                                Upload obrigatório
                            </span>

                            <div class="rounded-2xl bg-white p-5 shadow-sm">
                                <div class="text-base font-semibold text-slate-900">
                                    Arquivo da nota (imagem ou PDF)
                                </div>
                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    Toque ou clique abaixo para selecionar o documento que será enviado para análise.
                                </p>

                                <div class="mt-4">
                                    <input
                                        id="nota"
                                        type="file"
                                        name="nota"
                                        required
                                        class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-emerald-700"
                                    >
                                </div>

                                @error('nota')
                                    <div class="mt-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </label>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                            Enviar e analisar
                        </button>

                        <a href="{{ route('agro.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900">
                        Como funciona
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-sm font-semibold text-slate-900">1. Upload</div>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                Você envia a nota fiscal em imagem ou PDF.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-sm font-semibold text-slate-900">2. OCR</div>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                O sistema extrai o texto e organiza os dados encontrados.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-sm font-semibold text-slate-900">3. Parecer</div>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                A análise final fica disponível para consulta no histórico.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-amber-900">
                        Orientações
                    </h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-amber-900/90">
                        <li>• Prefira arquivos legíveis, sem cortes e com boa resolução.</li>
                        <li>• PDFs e imagens mais nítidos tendem a gerar melhor OCR.</li>
                        <li>• Após o envio, acompanhe o resultado no histórico de análises.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection