<!DOCTYPE html>
<html lang="es" class="h-full">
@include('clients.components.head', ['title' => 'Registro de Viajeros'])

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display h-screen overflow-hidden">
  <div class="h-screen flex">
    {{-- Sidebar (izquierda) --}}
    @include('clients.components.menu_lateral')

    <main class="flex-1 min-w-0 flex flex-col lg:ml-64">
      @include('clients.components.nav')
      <div class="flex-1 min-w-0 overflow-y-auto p-4 lg:p-8">
        @yield('content')
      </div>
    </main>
  </div>
@include('clients.components.loading')
   @include('clients.components.scripts') 
  <script>
    function toggleSidebar(open) {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      if (!sidebar || !backdrop) return;

      if (open) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100');
        document.body.classList.add('overflow-hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100');
        document.body.classList.remove('overflow-hidden');
      }
    }

    function closeSidebar() {
      toggleSidebar(false);
    }

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        toggleSidebar(false);
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
