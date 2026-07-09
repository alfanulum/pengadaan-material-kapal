<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 shadow-lg border-b border-blue-900/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <div class="flex items-center">

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center">
                            <x-application-logo class="block h-7 w-auto fill-current text-white" />
                        </div>

                        <div class="hidden md:block">
                            <p class="text-white font-bold leading-tight">
                                PT PAL
                            </p>
                            <p class="text-xs text-blue-100">
                                Procurement System
                            </p>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'supply_chain')
                        <x-nav-link :href="route('supply-chain.vendors.index')" :active="request()->routeIs('supply-chain.vendors.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Vendor
                        </x-nav-link>

                        <x-nav-link :href="route('supply-chain.material-requests.index')" :active="request()->routeIs('supply-chain.material-requests.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Permintaan
                        </x-nav-link>

                        <x-nav-link :href="route('supply-chain.tenders.index')" :active="request()->routeIs('supply-chain.tenders.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Tender
                        </x-nav-link>

                        <x-nav-link :href="route('supply-chain.goods-receipt-reports.index')" :active="request()->routeIs('supply-chain.goods-receipt-reports.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Laporan Penerimaan
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'engineer')
                        <x-nav-link :href="route('material-requests.index')" :active="request()->routeIs('material-requests.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Pengajuan Material
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'planner')
                        <x-nav-link :href="route('planner.material-requests.index')" :active="request()->routeIs('planner.material-requests.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Verifikasi Pengajuan
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'gudang')
                        <x-nav-link :href="route('gudang.goods-receipts.index')" :active="request()->routeIs('gudang.goods-receipts.*')"
                            class="text-blue-100 hover:text-white border-transparent hover:border-blue-200">
                            Penerimaan Barang
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 border border-white/20 text-sm leading-4 font-medium rounded-xl text-white bg-white/10 hover:bg-white/20 focus:outline-none transition">
                            <div class="text-left">
                                <p class="font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-100 capitalize">
                                    {{ str_replace('_', ' ', Auth::user()->role) }}
                                </p>
                            </div>

                            <div>
                                <svg class="fill-current h-4 w-4 text-blue-100" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-blue-950 border-t border-white/10">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-white/10">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'supply_chain')
                <x-responsive-nav-link :href="route('supply-chain.vendors.index')" :active="request()->routeIs('supply-chain.vendors.*')" class="text-white hover:bg-white/10">
                    Vendor
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('supply-chain.material-requests.index')" :active="request()->routeIs('supply-chain.material-requests.*')" class="text-white hover:bg-white/10">
                    Permintaan
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('supply-chain.tenders.index')" :active="request()->routeIs('supply-chain.tenders.*')" class="text-white hover:bg-white/10">
                    Tender
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('supply-chain.goods-receipt-reports.index')" :active="request()->routeIs('supply-chain.goods-receipt-reports.*')" class="text-white hover:bg-white/10">
                    Laporan Penerimaan
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'engineer')
                <x-responsive-nav-link :href="route('material-requests.index')" :active="request()->routeIs('material-requests.*')" class="text-white hover:bg-white/10">
                    Pengajuan Material
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'planner')
                <x-responsive-nav-link :href="route('planner.material-requests.index')" :active="request()->routeIs('planner.material-requests.*')" class="text-white hover:bg-white/10">
                    Verifikasi Pengajuan
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'gudang')
                <x-responsive-nav-link :href="route('gudang.goods-receipts.index')" :active="request()->routeIs('gudang.goods-receipts.*')" class="text-white hover:bg-white/10">
                    Penerimaan Barang
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-100">{{ Auth::user()->email }}</div>
                <div class="text-xs text-blue-200 mt-1 capitalize">
                    {{ str_replace('_', ' ', Auth::user()->role) }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-white/10">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-white hover:bg-white/10">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
