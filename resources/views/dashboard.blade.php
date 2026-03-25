<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-100">
                    Painel principal
                </div>
                <h2 class="mt-3 text-2xl font-bold text-white sm:text-3xl">
                    Dashboard
                </h2>
                <p class="mt-1 text-sm text-emerald-100/85 sm:text-base">
                    Acompanhe análises, envie novos documentos e consulte o histórico do sistema.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row">
                @if(\Illuminate\Support\Facades\Route::has('agro.create'))
                    <a href="{{ route('agro.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-emerald-900 shadow-sm transition hover:bg-emerald-50">
                        Nova análise
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('agro.index'))
                    <a href="{{ route('agro.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                        Ver histórico
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                Status
            </div>
            <div class="mt-3 text-2xl font-bold text-slate-900">
                Online
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Ambiente autenticado e pronto para operação.
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                Acesso
            </div>
            <div class="mt-3 text-2xl font-bold text-slate-900">
                {{ auth()->user()->name }}
            </div>
            <p class="mt-2 truncate text-sm leading-6 text-slate-600">
                {{ auth()->user()->email }}
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                Fluxo
            </div>
            <div class="mt-3 text-2xl font-bold text-slate-900">
                OCR + Parecer
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Extração, conferência e organização da análise documental.
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                Experiência
            </div>
            <div class="mt-3 text-2xl font-bold text-slate-900">
                Mobile First
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Layout responsivo para uso confortável em desktop e celular.
            </p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">
                        Bem-vindo ao Agro Seguro Scanner
                    </h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Use o painel para iniciar novas análises de notas fiscais, revisar documentos já enviados
                        e acompanhar o fluxo de conferência com uma estrutura mais clara.
                    </p>
                </div>

                <div class="inline-flex w-fit items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Ambiente autenticado
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-sm font-semibold text-slate-900">1. Envio</div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Faça upload da nota em imagem ou PDF para iniciar a análise.
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-sm font-semibold text-slate-900">2. Extração</div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        O sistema processa o OCR e organiza os dados encontrados.
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-sm font-semibold text-slate-900">3. Revisão</div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Consulte o parecer, o conteúdo bruto e os arquivos gerados.
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900">
                Ações rápidas
            </h3>

            <div class="mt-5 space-y-3">
                @if(\Illuminate\Support\Facades\Route::has('agro.create'))
                    <a href="{{ route('agro.create') }}"
                       class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                        <span>Iniciar nova análise</span>
                        <span class="text-emerald-700">→</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('agro.index'))
                    <a href="{{ route('agro.index') }}"
                       class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                        <span>Consultar histórico</span>
                        <span class="text-emerald-700">→</span>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-800 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                        <span>Atualizar perfil</span>
                        <span class="text-emerald-700">→</span>
                    </a>
                @endif
            </div>

            <div class="mt-6 rounded-2xl bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-900">
                    Próximo foco
                </div>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Melhorar a visualização das análises, separar melhor OCR e parecer final,
                    e estabilizar o processamento do relatório.
                </p>
            </div>
        </div>
    </section>
</x-app-layout>