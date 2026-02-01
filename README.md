# 🏨 Sistema de Reservas para Hospedaje - Laravel + Materialize + FullCalendar

Este sistema permite la gestión completa de reservas para un hospedaje con integración de calendario visual, sincronización con Booking.com mediante iCal, funcionalidades contables y herramientas de cumplimiento para autoridades turísticas.

---

## 🚀 Tecnologías Usadas

* **Laravel** (Backend PHP)
* **MaterializeCSS** (Diseño frontend)
* **FullCalendar.js** (Calendario interactivo)
* **MySQL** (Base de datos)
* **ICS Parser** (`u01jmg3/ics-parser`) para leer archivos iCal

---

## 📅 Módulo de Reservas

### Funciones principales:

* Crear, editar y eliminar reservas.
* Calendario mensual visual tipo Booking.
* Reservas divididas por habitación (3 habitaciones, 3 colores).
* Validación automática de fechas (fecha final no puede ser menor que fecha de entrada).
* Modal para gestión rápida desde el calendario.

---

## 🔄 Integración con Booking.com (vía iCal)

### Importación:

* Se obtiene el archivo `.ics` de Booking.
* Laravel lo lee y crea reservas nuevas si no existen.
* Automatizado por cron job (cada 30 minutos en Hostinger).

### Exportación:

* El sistema genera un `.ics` con todas las reservas locales.
* Booking puede leer este archivo para actualizar su disponibilidad.
* Protegido con token `SYNC_TOKEN` para evitar accesos no autorizados.

---

## 📈 Módulo Contable

### Características:

* Generación de **facturas** por cada huésped.
* Cálculo del **total mensual** generado por reservas.
* Exportación de registros contables para revisión o auditoría.

---

## 🧾 Módulo de Viajero / Check-in Online

### Funcionalidad:

* Huéspedes completan sus datos antes de llegar.
* Se almacena la información en la base de datos.
* Posibilidad de generar un **registro físico descargable (PDF)** para firma.

---

## 📤 XML para Hospedería

* El sistema genera un archivo XML compatible con los requisitos de hospedería local.
* Permite enviar informes de forma digital a la autoridad correspondiente.
* Cada reserva incluye información del viajero y la estadía.

---

## 🔐 Seguridad

* Los endpoints de sincronización están protegidos con un token seguro de 64 caracteres.
* Validaciones en formularios para evitar datos incorrectos o maliciosos.

---

## 📦 Archivos clave

* `/sync-booking/{token}`: importa reservas desde Booking.
* `/calendario.ics/{token}`: exporta reservas locales como iCal.
* `.env`: incluye el token `SYNC_TOKEN=...`

---
## Command para hacer 
* composer require u01jmg3/ics-parser

## Command to Hostinger 
* COMPOSER_MEMORY_LIMIT=-1 ~/composer2 require u01jmg3/ics-parser 

## 📅 Cron Job (Hostinger)

Ejemplo de cron job:

```bash
wget -q -O - https://tudominio.com/sync-booking/your_token > /dev/null 2>&1
```

Corre cada 30 minutos para mantener la sincronización activa.

---

## ✅ Estado actual

* [x] Calendario funcional (crear, editar, eliminar)
* [x] Colores por habitación
* [x] Validación de fechas
* [x] Importación desde Booking
* [x] Exportación .ics
* [x] Cron en Hostinger
* [x] Gestión contable mensual y por reserva
* [x] Check-in online
* [x] Generación de XML para hospedería

---

## 🛠 Ideas futuras (opcional)

* Filtros por habitación o estado en el calendario
* Enviar notificaciones por email automáticas
* Dashboard de KPIs (ocupación, ingresos, cancelaciones)
* API REST para terceros


