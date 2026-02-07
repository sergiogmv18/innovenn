<header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 sticky top-0 z-10">
  <div class="flex items-center gap-4">
    <button type="button"
            class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition"
            onclick="toggleSidebar(true)"
            aria-label="Open menu">
      <span class="material-symbols-outlined text-xl">menu</span>
    </button>
    <h2 class="text-lg font-bold text-slate-800 dark:text-white">
      @yield('title', 'Operational Dashboard')
    </h2>

    <div class="hidden sm:block h-4 w-px bg-slate-300 dark:bg-slate-700"></div>

    <div class="hidden sm:flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-full">
      <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">BCV Rate:</span>
      <span class="text-sm font-bold text-primary">36.50 VED/USD</span>
    </div>
  </div>

  <div class="flex items-center gap-4">
    <div class="relative">
      <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 cursor-pointer p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
        notifications
      </span>
      <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
    </div>

    <div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800">
      <div class="text-right">
        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ Session::get('user')->name ?? 'Admin' }}</p>
        <p class="text-[10px] text-slate-500 uppercase tracking-wider font-medium">Hotel Manager</p>
      </div>
    </div>
  </div>
</header>
