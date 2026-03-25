<nav x-data="{ open: false }" class="relative z-30 px-4 pt-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-white/15 bg-white/10 shadow-[0_20px_60px_rgba(2,6,23,0.18)] backdrop-blur">
            <div class="flex h-18 items-center justify-between px-4 sm:px-6">
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/15 bg-white/95 shadow-sm">
                            <x-application-logo class="block h-7 w-auto fill-current text-emerald-800" />
                        </span>

                        <span class="hidden min-w-0 sm:block">
                            <span class="block truncate text-sm font-bold uppercase tracking-[0.18em] text-white">
                                Agro Seguro Scanner
                            </span>
                            <span class="block truncate text-xs text-emerald-100/80">
                                Painel de análises e conferências
                            </span>
                        </span>
                    </a>

                    <div class="hidden items-center gap-2 lg:flex">
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'bg-white text-emerald-900 shadow-sm' : 'text-white/85 hover:bg-white/10 hover:text-white' }} inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition">
                            Dashboard
                        </a>

                        @if(\Illuminate\Support\Facades\Route::has('agro.index'))
                            <a href="{{ route('agro.index') }}"
                               class="{{ request()->routeIs('agro.index') ? 'bg-white text-emerald-900 shadow-sm' : 'text-white/85 hover:bg-white/10 hover:text-white' }} inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition">
                                Análises
                            </a>
                        @endif

                        @if(\Illuminate\Support\Facades\Route::has('agro.create'))
                            <a href="{{ route('agro.create') }}"
                               class="{{ request()->routeIs('agro.create') ? 'bg-white text-emerald-900 shadow-sm' : 'text-white/85 hover:bg-white/10 hover:text-white' }} inline-flex items-center rounded-2xl px-4 py-2 text-sm font-semibold transition">
                                Nova análise
                            </a>
                        @endif
                    </div>
                </div>

                <div class="hidden items-center gap-3 sm:flex">
                    <div class="hidden text-right md:block">
                        <div class="max-w-[220px] truncate text-sm font-semibold text-white">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="max-w-[220px] truncate text-xs text-emerald-100/80">
                            {{ Auth::user()->email }}
                        </div>
                    </div>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 rounded-2xl border border-white/15 bg-white/95 px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-white">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-sm font-bold text-emerald-800">
                                    {{ strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>

                                <span class="hidden md:block">
                                    Conta
                                </span>

                                <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.512a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <div class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                                <div class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</div>
                            </div>

                            @if(\Illuminate\Support\Facades\Route::has('profile.edit'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    Perfil
                                </x-dropdown-link>
                            @endif

                            @if(\Illuminate\Support\Facades\Route::has('agro.create'))
                                <x-dropdown-link :href="route('agro.create')">
                                    Nova análise
                                </x-dropdown-link>
                            @endif

                            @if(\Illuminate\Support\Facades\Route::has('agro.index'))
                                <x-dropdown-link :href="route('agro.index')">
                                    Histórico de análises
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/10 p-2 text-white transition hover:bg-white/15">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-transition class="border-t border-white/10 px-4 py-4 sm:hidden">
                <div class="mb-4 rounded-2xl border border-white/10 bg-white/10 p-4">
                    <div class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="truncate text-xs text-emerald-100/80">{{ Auth::user()->email }}</div>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'bg-white text-emerald-900' : 'bg-white/10 text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition">
                        Dashboard
                    </a>

                    @if(\Illuminate\Support\Facades\Route::has('agro.index'))
                        <a href="{{ route('agro.index') }}"
                           class="{{ request()->routeIs('agro.index') ? 'bg-white text-emerald-900' : 'bg-white/10 text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition">
                            Análises
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('agro.create'))
                        <a href="{{ route('agro.create') }}"
                           class="{{ request()->routeIs('agro.create') ? 'bg-white text-emerald-900' : 'bg-white/10 text-white' }} flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition">
                            Nova análise
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition">
                            Perfil
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center rounded-2xl bg-red-500/90 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-500">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>