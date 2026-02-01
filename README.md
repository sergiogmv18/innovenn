# Sistema de Reservas para Hospedaje

Aplicacion web para gestionar reservas, calendario, check-in de viajeros, facturacion y exportacion de datos para autoridades turísticas. Incluye sincronizacion por iCal con Booking.com.

## Funcionalidades
- Calendario de reservas con altas, ediciones y eliminaciones.
- Reservas por habitacion con colores y validacion de fechas.
- Importacion/exportacion iCal para sincronizacion con Booking.com.
- Modulo contable: facturas y resumenes mensuales.
- Registro de viajeros y generacion de XML para hospedaje.
- Seguridad por token en endpoints de sincronizacion.

## Tecnologias
- Laravel 11 (PHP)
- MaterializeCSS
- FullCalendar.js
- MySQL o SQLite
- Vite + Tailwind (tooling)
- ICS Parser (u01jmg3/ics-parser)

## Requisitos
- PHP 8.2+
- Composer
- Node.js 18+ y npm
- Base de datos (MySQL o SQLite)

## Instalacion local
```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate
```

Opcional (SQLite):
```bash
type nul > database/database.sqlite
```

## Configuracion (.env)
Ajusta al menos:
- `APP_URL`
- `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `SYNC_TOKEN` (token para sincronizacion iCal)

## Ejecutar en desarrollo
```bash
php artisan serve
npm run dev
```

## Sincronizacion con Booking.com (iCal)
Endpoints publicos protegidos con `SYNC_TOKEN`:
- `GET /sync-booking/{token}`: importa reservas desde Booking.
- `GET /calendario.ics/{token}`: exporta reservas locales en formato iCal.

En `app/Http/Controllers/BookingController.php`, actualiza la URL del feed de Booking.com en el metodo `importToBooking`:
```
https://calendar.booking.com/ical/tu-hotel.ics
```

## Cron job (ejemplo)
```bash
wget -q -O - https://tudominio.com/sync-booking/tu_token > /dev/null 2>&1
```

## Scripts utiles
```bash
composer require u01jmg3/ics-parser
npm run dev
npm run build
```

## Pruebas
```bash
php artisan test
```

## Notas
- El endpoint de exportacion genera `calendario.ics` con las reservas en base de datos.
- La importacion evita duplicados por fecha y origen.
