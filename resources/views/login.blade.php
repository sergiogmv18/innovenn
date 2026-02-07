<!DOCTYPE html>
<html lang="es" class="h-full">
@include('clients.components.head', ['title' => 'Iniciar sesión'])
<body class="h-full text-slate-900">
  <div class="min-h-screen flex items-center justify-center px-4 py-12"
       style="background: radial-gradient(circle at 50% 20%, #e8f1ff 0%, #f7fbff 45%, #ffffff 100%);">

    <div class="w-full max-w-md">
      <div class="mb-6 text-center">
        <div class="mx-auto mb-4 size-12 rounded-xl bg-primary/10 flex items-center justify-center">
          <svg width="24" height="24" class="text-primary" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M6 10h12a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2Z"
                  stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
          </svg>
        </div>

        <h1 class="text-2xl font-bold tracking-tight">Iniciar sesión</h1>
        <p class="mt-1 text-sm text-slate-500">Accede al panel</p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="p-6 sm:p-7">
          <form action="{{ route('signIn') }}" class="space-y-4">
            @csrf

            <div>
              <label for="userName" class="block text-sm font-semibold text-slate-700">Usuario</label>
              <input id="userName" name="email_address" type="email" required autocomplete="username"
                     class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-medium
                            text-slate-900 placeholder:text-slate-400 shadow-sm
                            focus:border-primary focus:ring-primary"
                     placeholder="tu@correo.com">
            </div>

            <div>
              <label for="userPassword" class="block text-sm font-semibold text-slate-700">Contraseña</label>
              <input id="userPassword" name="password" type="password" required autocomplete="current-password"
                     class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-medium
                            text-slate-900 placeholder:text-slate-400 shadow-sm
                            focus:border-primary focus:ring-primary"
                     placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full rounded-xl bg-primary px-4 py-3 text-sm font-bold text-white
                           shadow-lg shadow-primary/25 hover:bg-primary/90 transition">
              Entrar
            </button>
          </form>
        </div>

        <div class="border-t border-slate-200 px-6 py-4 text-center text-xs text-slate-500">
          Travelers Register · Cloud PMS
        </div>
      </div>
    </div>
  </div>
</body>
</html>

