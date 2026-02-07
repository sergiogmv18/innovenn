@extends('main')

@section('showSearch', false)

@section('title', 'Inicio')

@section('content')


<!-- <div class="min-h-screen"> -->
  <div class="space-y-8">
    <!-- Top Actions & Quick Metrics -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
          <span class="material-symbols-outlined text-lg">calendar_month</span>
          Availability
        </button>
        <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all">
          <span class="material-symbols-outlined text-lg">add</span>
          New Reservation
        </button>
      </div>
    </div>
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-primary/10 rounded-lg">
            <span class="material-symbols-outlined text-primary">analytics</span>
          </div>
          <span class="text-emerald-500 text-xs font-bold flex items-center">
            <span class="material-symbols-outlined text-sm">trending_up</span> 5.2%
          </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Occupancy Rate</p>
        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">78.4%</h4>
        <p class="text-[11px] text-slate-400 mt-2">Target: 85% this month</p>
      </div>
      <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-indigo-500/10 rounded-lg">
            <span class="material-symbols-outlined text-indigo-500">payments</span>
          </div>
          <span class="text-emerald-500 text-xs font-bold flex items-center">
            <span class="material-symbols-outlined text-sm">trending_up</span> 12.4%
          </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Daily Revenue (USD)</p>
        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">$2,450.00</h4>
        <p class="text-[11px] text-slate-400 mt-2">Avg. Night: $112.00</p>
      </div>
      <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-amber-500/10 rounded-lg">
            <span class="material-symbols-outlined text-amber-500">currency_exchange</span>
          </div>
          <span class="text-slate-400 text-xs font-bold flex items-center">
            Stable
          </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Daily Revenue (VED)</p>
        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">Bs. 89.4k</h4>
        <p class="text-[11px] text-slate-400 mt-2">Includes VAT 16% + IGTF</p>
      </div>
      <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-rose-500/10 rounded-lg">
            <span class="material-symbols-outlined text-rose-500">cleaning_services</span>
          </div>
          <span class="text-rose-500 text-xs font-bold flex items-center">
            4 Pending
          </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Room Maintenance</p>
        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">12 Dirty</h4>
        <p class="text-[11px] text-slate-400 mt-2">3 Out of Order</p>
      </div>
    </div>
    <!-- Room Status Breakdown & Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Room Distribution Card -->
      <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
          <h5 class="text-sm font-bold text-slate-800 dark:text-white">Room Status Summary</h5>
          <button class="text-primary text-xs font-bold hover:underline">View Map</button>
        </div>
        <div class="p-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
          <div class="flex flex-col items-center p-4 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl border border-emerald-100 dark:border-emerald-500/20 text-center">
            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 mb-2">check_circle</span>
            <span class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">22</span>
            <span class="text-[10px] font-bold text-emerald-600/70 dark:text-emerald-400/70 uppercase">Vacant Clean</span>
          </div>
          <div class="flex flex-col items-center p-4 bg-primary/5 dark:bg-primary/10 rounded-xl border border-primary/10 dark:border-primary/20 text-center">
            <span class="material-symbols-outlined text-primary mb-2">sensor_door</span>
            <span class="text-2xl font-bold text-primary">45</span>
            <span class="text-[10px] font-bold text-primary/70 uppercase">Occupied</span>
          </div>
          <div class="flex flex-col items-center p-4 bg-amber-50 dark:bg-amber-500/10 rounded-xl border border-amber-100 dark:border-amber-500/20 text-center">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 mb-2">mop</span>
            <span class="text-2xl font-bold text-amber-700 dark:text-amber-300">12</span>
            <span class="text-[10px] font-bold text-amber-600/70 dark:text-amber-400/70 uppercase">Vacant Dirty</span>
          </div>
          <div class="flex flex-col items-center p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-center">
            <span class="material-symbols-outlined text-slate-400 mb-2">pending_actions</span>
            <span class="text-2xl font-bold text-slate-600 dark:text-slate-300">8</span>
            <span class="text-[10px] font-bold text-slate-400 uppercase">Incoming</span>
          </div>
          <div class="flex flex-col items-center p-4 bg-rose-50 dark:bg-rose-500/10 rounded-xl border border-rose-100 dark:border-rose-500/20 text-center">
            <span class="material-symbols-outlined text-rose-600 dark:text-rose-400 mb-2">construction</span>
            <span class="text-2xl font-bold text-rose-700 dark:text-rose-300">3</span>
            <span class="text-[10px] font-bold text-rose-600/70 dark:text-rose-400/70 uppercase">Out Service</span>
          </div>
        </div>
      </div>
      <!-- Financial Mini-Panel -->
      <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
          <h5 class="text-sm font-bold text-slate-800 dark:text-white">Fiscal Summary</h5>
          <div class="flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            <span class="text-[10px] font-bold text-slate-500 uppercase">Live</span>
          </div>
        </div>
        <div class="p-6 space-y-4">
          <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Daily Revenue USD</p>
            <p class="text-sm font-bold text-slate-900 dark:text-white">$2,450.00</p>
          </div>
          <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Daily Revenue VED</p>
            <p class="text-sm font-bold text-slate-900 dark:text-white">Bs. 89,425.00</p>
          </div>
          <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">VAT (16%) VED</p>
            <p class="text-sm font-bold text-rose-600">Bs. 14,308.00</p>
          </div>
          <div class="flex justify-between items-center">
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">IGTF (3%) USD</p>
            <p class="text-sm font-bold text-rose-600">$73.50</p>
          </div>
          <button class="w-full mt-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-bold py-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-all uppercase tracking-widest">
            Audit Fiscal Journal
          </button>
        </div>
      </div>
    </div>
    <!-- Recent Transactions Table -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <h5 class="text-sm font-bold text-slate-800 dark:text-white">Recent Transactions &amp; Invoices</h5>
        <div class="flex items-center gap-2">
          <div class="relative">
            <input class="text-xs border-slate-200 dark:border-slate-800 dark:bg-slate-900 rounded-lg pl-8 pr-4 py-1.5 focus:ring-primary focus:border-primary transition-all" placeholder="Search invoices..." type="text" />
            <span class="material-symbols-outlined text-sm absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400">search</span>
          </div>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/50 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
              <th class="px-6 py-4">Guest / Client</th>
              <th class="px-6 py-4">Room</th>
              <th class="px-6 py-4">Total Amount</th>
              <th class="px-6 py-4">Currency</th>
              <th class="px-6 py-4">Status</th>
              <th class="px-6 py-4">Fiscal Invoice</th>
              <th class="px-6 py-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
            <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-slate-500 text-xs">AM</div>
                  <div>
                    <p class="font-bold text-slate-900 dark:text-white">Alejandro Mendoza</p>
                    <p class="text-[11px] text-slate-400">ID: V-12.345.678</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">Suite 402</td>
              <td class="px-6 py-4">
                <p class="font-bold text-slate-900 dark:text-white">$450.00</p>
                <p class="text-[10px] text-slate-400">Bs. 16,425.00</p>
              </td>
              <td class="px-6 py-4 text-xs font-bold text-slate-500">USD / VED</td>
              <td class="px-6 py-4">
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 text-[10px] font-bold">PAID</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400">
                  <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                  <span class="text-xs font-medium">#F-0001423</span>
                </div>
              </td>
              <td class="px-6 py-4 text-right">
                <button class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded transition-all">
                  <span class="material-symbols-outlined text-slate-400 text-[18px]">more_vert</span>
                </button>
              </td>
            </tr>
            <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="size-8 rounded-full bg-indigo-200 dark:bg-indigo-900/40 flex items-center justify-center font-bold text-indigo-500 text-xs">BP</div>
                  <div>
                    <p class="font-bold text-slate-900 dark:text-white">Banesco Corp</p>
                    <p class="text-[11px] text-slate-400">RIF: J-0001234-5</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">Group (3 Rooms)</td>
              <td class="px-6 py-4">
                <p class="font-bold text-slate-900 dark:text-white">$1,200.00</p>
                <p class="text-[10px] text-slate-400">Bs. 43,800.00</p>
              </td>
              <td class="px-6 py-4 text-xs font-bold text-slate-500">USD</td>
              <td class="px-6 py-4">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 text-[10px] font-bold">PENDING</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-[10px] font-medium text-slate-400 italic">Not issued</span>
              </td>
              <td class="px-6 py-4 text-right">
                <button class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded transition-all">
                  <span class="material-symbols-outlined text-slate-400 text-[18px]">more_vert</span>
                </button>
              </td>
            </tr>
            <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-slate-500 text-xs">EM</div>
                  <div>
                    <p class="font-bold text-slate-900 dark:text-white">Elena Martínez</p>
                    <p class="text-[11px] text-slate-400">ID: V-18.990.123</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">Room 105</td>
              <td class="px-6 py-4">
                <p class="font-bold text-slate-900 dark:text-white">$85.00</p>
                <p class="text-[10px] text-slate-400">Bs. 3,102.50</p>
              </td>
              <td class="px-6 py-4 text-xs font-bold text-slate-500">VED (Pago Móvil)</td>
              <td class="px-6 py-4">
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 text-[10px] font-bold">PAID</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400">
                  <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                  <span class="text-xs font-medium">#F-0001424</span>
                </div>
              </td>
              <td class="px-6 py-4 text-right">
                <button class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded transition-all">
                  <span class="material-symbols-outlined text-slate-400 text-[18px]">more_vert</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs text-slate-500 font-medium">Showing 3 of 42 transactions</p>
        <div class="flex gap-2">
          <button class="p-1 border border-slate-200 dark:border-slate-700 rounded hover:bg-white dark:hover:bg-slate-900 transition-all">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
          </button>
          <button class="p-1 border border-slate-200 dark:border-slate-700 rounded hover:bg-white dark:hover:bg-slate-900 transition-all">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  @endsection
  <!-- </main> -->
<!-- </div> -->




