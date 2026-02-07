<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Viajeros | Automatización Legal para Hoteles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-civit-blue { background-color: #00a1e4; } /* Azul vibrante de Civitfun */
        .text-civit-dark { color: #0b1c3f; } /* Azul marino profundo */
        .section-light { background-color: #f4f9ff; }
    </style>
</head>
<body class="bg-white text-slate-800">
    <nav class="sticky top-0 bg-white z-50 border-b border-gray-100 py-5">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <div class="text-2xl font-black text-civit-dark flex items-center">
                    <img src="https://via.placeholder.com/40x40/00a1e4/ffffff?text=C" alt="Logo" class="mr-2">
                    CivitGuest
                </div>
                <div class="hidden lg:flex space-x-6 text-sm font-semibold text-slate-600 uppercase tracking-wider">
                    <a href="#como-funciona" class="hover:text-blue-500">Soluciones</a>
                    <a href="#" class="hover:text-blue-500">Integraciones</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-sm font-bold text-slate-700 hover:text-blue-500">ES 🇪🇸</button>
                <a href="{{route('login')  }}" class="border-2 border-slate-900 text-slate-900 px-6 py-2 rounded-md font-bold text-sm hover:bg-slate-900 hover:text-white transition">LOGIN</a>
            </div>
        </div>
    </nav>

    <header class="py-16 md:py-24 overflow-hidden">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <p class="text-blue-500 font-bold uppercase tracking-widest text-xs mb-4">Registro de viajeros para hotel</p>
                <h1 class="text-5xl md:text-6xl font-extrabold text-civit-dark leading-tight mb-6">
                    Envía el registro de viajeros de forma <span class="text-blue-500">automática</span> y evita sanciones
                </h1>
                <p class="text-lg text-slate-600 mb-8">
                    Gestiona y envía automáticamente los reportes legales o partes de entrada a las autoridades. Cumple con las normativas sin preocupaciones ni multas.
                </p>
                <button class="bg-blue-500 text-white px-10 py-4 rounded-lg font-bold hover:bg-blue-600 transition shadow-lg shadow-blue-200 uppercase text-sm tracking-wide">
                    Solicitar una Demo
                </button>
            </div>
            <div class="relative flex justify-center">
                <div class="relative z-10 bg-white rounded-3xl shadow-2xl p-4 border border-gray-100">
                    <img src="{{ asset('img/screen.png') }}" alt="UI Screenshot" class="rounded-xl">
                </div>
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            </div>
        </div>
    </header>

    <section class="py-12 border-y border-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-40 grayscale">
                <span class="text-xl font-black italic uppercase">Barceló</span>
                <span class="text-xl font-black italic uppercase">Meliá</span>
                <span class="text-xl font-black italic uppercase">Marriott</span>
                <span class="text-xl font-black italic uppercase">Iberostar</span>
                <span class="text-xl font-black italic uppercase">Sercotel</span>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-24 section-light">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <p class="text-blue-500 font-bold uppercase tracking-widest text-xs mb-3">Cómo funciona</p>
                <h2 class="text-4xl font-extrabold text-civit-dark mb-6">Gestiona tus envíos de partes de viajeros fácilmente</h2>
                <p class="text-slate-500">Agiliza todos tus procesos y digitaliza tus envíos manuales ahorrando tiempo al personal de tu recepción.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-10 rounded-2xl border-b-4 border-blue-500 shadow-sm hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-8">
                        <i class="fas fa-link text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Integración completa</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Sincronización bidireccional con tu PMS y plataformas como SES.HOSPEDAJES, Mossos d'Esquadra y Ertzaintza.
                    </p>
                </div>

                <div class="bg-white p-10 rounded-2xl border-b-4 border-blue-500 shadow-sm hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-8">
                        <i class="fas fa-paper-plane text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Envío automático</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Olvida los procesos manuales. El envío de partes se hace automáticamente, sin que tengas que dedicar tiempo extra.
                    </p>
                </div>

                <div class="bg-white p-10 rounded-2xl border-b-4 border-blue-500 shadow-sm hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-8">
                        <i class="fas fa-bell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Estado y avisos</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Recibe notificaciones, revisa estados de envío e identifica errores para rectificarlos sin parones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-20">
        <div class="bg-civit-blue rounded-3xl p-10 md:p-16 text-white relative overflow-hidden">
            <div class="grid md:grid-cols-2 gap-10 items-center relative z-10">
                <div>
                    <h2 class="text-4xl font-extrabold mb-6">Experimenta la suite de CivitGuest en directo</h2>
                    <p class="text-blue-50 opacity-90 mb-0">Descubre cómo podemos transformar la recepción de tu hotel en pocos minutos.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-2xl">
                    <p class="text-civit-dark font-bold mb-4 text-sm">Correo electrónico corporativo</p>
                    <div class="flex flex-col space-y-4">
                        <input type="email" placeholder="ejemplo@hotel.com" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button class="w-full bg-slate-900 text-white font-bold py-3 rounded-lg hover:bg-black transition uppercase text-xs tracking-widest">Enviar</button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-4 leading-tight">
                        Nunca compartas información confidencial. Este sitio está protegido por reCAPTCHA.
                    </p>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        </div>
    </section>

    <footer class="bg-slate-900 py-12 text-white">
        <div class="container mx-auto px-6 text-center opacity-60 text-sm">
            <p>© 2026 CivitGuest Software. Parte de HBX Group. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>