@php
use App\Models\Room;
@endphp
@extends('main')

@section('title', 'Habitaciones')


@section('content')
@php
$vl = $statusCounts[Room::STATUS_VL] ?? 0;
$vs = $statusCounts[Room::STATUS_VS] ?? 0;
$ol = $statusCounts[Room::STATUS_OL] ?? 0;
$os = $statusCounts[Room::STATUS_OS] ?? 0;
$oxs = $statusCounts[Room::STATUS_OXS] ?? 0;
$fdu = $statusCounts[Room::STATUS_FDU] ?? 0;
@endphp

<style>
    :root {
        --bg: #0b0f17;
        --panel: #121826;
        --card: #0f1625;
        --stroke: rgba(148, 163, 184, 0.16);
        --text: #e7edf5;
        --muted: #9aa7ba;
        --vl: #14b87a;
        --vs: #a8b0bc;
        --ol: #4cc2ff;
        --os: #ff5c5c;
        --oxs: #ffb020;
        --fdu: #a78bfa;
    }

    .rooms-wrap {
        background: radial-gradient(900px 420px at 8% -10%, rgba(20, 184, 166, 0.12), transparent),
            radial-gradient(700px 360px at 92% 0%, rgba(76, 194, 255, 0.12), transparent),
            linear-gradient(180deg, #0b1220 0%, #0a0f1a 100%);
        color: var(--text);
        border-radius: 18px;
        padding: 20px 22px 28px;
        border: 1px solid var(--stroke);
        margin-top: 2em;
    }

    .rooms-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    /* .rooms-title {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.2px;
        margin: 0;
    } */

    /* .rooms-subtitle {
        font-size: 12px;
        color: var(--muted);
        margin: 4px 0 0;
    } */

    .page-title {
        margin: 0;
        font-weight: 800;
    }

    .page-subtitle {
        margin-top: 4px;
        font-size: 14px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .stat-card {
        background: var(--panel);
        border: 1px solid var(--stroke);
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        min-height: 64px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--muted);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .pill {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 999px;
        font-weight: 600;
        border: 1px solid var(--stroke);
        background: var(--card);
    }

    .legend {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 10px;
        margin-bottom: 16px;
    }

    .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--muted);
        background: var(--panel);
        border: 1px solid var(--stroke);
        padding: 6px 10px;
        border-radius: 999px;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 10px;
    }

    .room-card {
        background: var(--card);
        border: 1px solid var(--stroke);
        border-radius: 12px;
        padding: 10px;
        min-height: 90px;
        display: grid;
        gap: 6px;
        position: relative;
        overflow: hidden;
    }

    .room-actions {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
    }

    .action-btn {
        border: 1px solid var(--stroke);
        background: rgba(15, 23, 42, 0.7);
        color: var(--text);
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 10px;
        cursor: pointer;
    }

    .action-btn:hover {
        background: rgba(15, 23, 42, 0.9);
    }

    .action-menu {
        position: fixed;
        min-width: 190px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
        padding: 8px;
        z-index: 99999;
        display: none;
    }

    .action-menu a,
    .action-menu button {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 10px;
        border-radius: 10px;
        text-decoration: none;
        color: #222;
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 14px;
        text-align: left;
    }

    .action-menu a:hover,
    .action-menu button:hover {
        background: rgba(100, 181, 246, .12);
    }

    .menu-divider {
        height: 1px;
        background: rgba(0, 0, 0, .08);
        margin: 6px 0;
    }

    .room-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--muted);
        opacity: 0.9;
    }

    .room-code {
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    .room-name {
        font-size: 12px;
        color: var(--muted);
    }

    .room-meta {
        font-size: 11px;
        color: var(--muted);
    }

    .status-VL::before {
        background: var(--vl);
    }

    .status-VS::before {
        background: var(--vs);
    }

    .status-OL::before {
        background: var(--ol);
    }

    .status-OS::before {
        background: var(--os);
    }

    .status-OxS::before {
        background: var(--oxs);
    }

    .status-FDU::before {
        background: var(--fdu);
    }

    .badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 8px;
        align-self: start;
        /* background: rgba(15, 23, 42, 0.6); */
        /* border: 1px solid var(--stroke); */
    }

    .badge-VL {
        color: var(--vl);
    }

    .badge-VS {
        color: var(--vs);
    }

    .badge-OL {
        color: var(--ol);
    }

    .badge-OS {
        color: var(--os);
    }

    .badge-OxS {
        color: var(--oxs);
    }

    .badge-FDU {
        color: var(--fdu);
    }

    @media (max-width: 600px) {
        .rooms-wrap {
            padding: 16px;
        }

        .rooms-title {
            font-size: 18px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>


<section class="section section-stats">
    <div class="row">

        <div class="col s12 m12 l12">
            <div class="left">
                <h5 class="page-title">Habitaciones</h5>
                <div class="left grey-text">
                    Resumen operativo en tiempo real
                </div>
            </div>
            <div class="right" style="margin-top:8px;">
                <form method="GET" action="{{ route('roomIndex', Session::get('user')->uuid) }}" style="display:flex;gap:8px;align-items:center;">
                    <input type="date" name="date" value="{{ $selectedDate ?? '' }}" style="height:34px;border-radius:8px;border:1px solid var(--stroke);background:#0f1625;color:var(--text);padding:0 10px;">
                    <button type="submit" class="action-btn">Buscar</button>
                </form>
            </div>
            <br>

            <div class="rooms-wrap">
                <!-- <div class="rooms-header">
                    <div>
                        <h4 class="rooms-title">Habitaciones</h4>
                        <p class="rooms-subtitle">Resumen operativo en tiempo real</p>
                    </div>
                    <div class="pill">UCT: {{ $totalRooms }}</div>
                </div> -->

                <div class="stats-grid">
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">VL</p>
                            <p class="stat-value">{{ $vl }}</p>
                        </div>
                        <span class="pill">Vac. limpia</span>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">VS</p>
                            <p class="stat-value">{{ $vs }}</p>
                        </div>
                        <span class="pill">Vac. sucia</span>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">Vacantes / %</p>
                            <p class="stat-value">{{ $vacantCount }} / {{ $vacantPercent }}%</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">OL</p>
                            <p class="stat-value">{{ $ol }}</p>
                        </div>
                        <span class="pill">Ocp. limpia</span>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">OS</p>
                            <p class="stat-value">{{ $os }}</p>
                        </div>
                        <span class="pill">Ocp. sucia</span>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">OxS</p>
                            <p class="stat-value">{{ $oxs }}</p>
                        </div>
                        <span class="pill">Por salir</span>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">Ocupadas / %</p>
                            <p class="stat-value">{{ $occupiedCount }} / {{ $occupiedPercent }}%</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div>
                            <p class="stat-label">FDU</p>
                            <p class="stat-value">{{ $fdu }}</p>
                        </div>
                        <span class="pill">{{ $fduPercent }}%</span>
                    </div>
                </div>

                <div class="legend">
                    <span class="legend-item"><span class="dot" style="background: var(--vl);"></span> VL Vacante limpia</span>
                    <span class="legend-item"><span class="dot" style="background: var(--vs);"></span> VS Vacante sucia</span>
                    <span class="legend-item"><span class="dot" style="background: var(--ol);"></span> OL Ocupada limpia</span>
                    <span class="legend-item"><span class="dot" style="background: var(--os);"></span> OS Ocupada sucia</span>
                    <span class="legend-item"><span class="dot" style="background: var(--oxs);"></span> OxS Por salir</span>
                    <span class="legend-item"><span class="dot" style="background: var(--fdu);"></span> FDU Fuera de uso</span>
                </div>

                <div class="rooms-grid">
                    @forelse ($rooms as $room)
                    @php
                        $status = $room->effective_status ?? $room->status;
                    @endphp
                    <div class="room-card status-{{ $status }}">
                        <div class="room-actions">
                            <button type="button" class="action-btn"
                                onclick="toggleMenu(event, 'menu-{{ $room->uuid }}')">
                                Acciones
                            </button>
                        </div>
                        <div id="menu-{{ $room->uuid }}" class="action-menu" aria-hidden="true">
                            @if ($status == Room::STATUS_VL)
                                <a href="{{route('showFormRegisterTravel', parameters:Session::get('user')->uuid) }}">
                                    <i class="material-icons" style="font-size:16px;color:var(--vl);">login</i> Check-in
                                </a>
                            @else
                            @if ($status == Room::STATUS_OXS)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--oxs);">exit_to_app</i> Check-out
                                </a>
                            @endif
                            @endif
                            @if ($status != Room::STATUS_VL)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--vl);">check_circle</i> VL Vacante limpia
                                </a>
                            @endif
                            @if ($status != Room::STATUS_VS)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--vs);">cleaning_services</i> VS Vacante sucia
                                </a>
                            @endif
                            @if ($status != Room::STATUS_OL)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--ol);">hotel</i> OL Ocupada limpia
                                </a>
                            @endif
                            @if ($status != Room::STATUS_OS)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--os);">report_problem</i> OS Ocupada sucia
                                </a>
                            @endif
                            @if ($status != Room::STATUS_OXS)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--oxs);">schedule</i> OxS Por salir
                                </a>
                            @endif
                            @if ($status != Room::STATUS_FDU)
                                <a href="">
                                    <i class="material-icons" style="font-size:16px;color:var(--fdu);">block</i> FDU Fuera de uso
                                </a>
                            @endif
                        </div>
                        <span class="badge badge-{{ $status }}">{{ $status }}</span>
                        <div class="room-code">#{{ $room->number }}</div>
                        <div class="room-name">{{ $room->name }}</div>
                        <div class="room-meta">{{ $room->beds_count }} camas · {{ $room->bed_type }}</div>
                        <div class="room-meta">{{ $room->people_count }} personas</div>
                    </div>
                    @empty
                    <div class="room-card">
                        <div class="room-code">Sin habitaciones</div>
                        <div class="room-name">Registra habitaciones para ver el panel</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', closeAllMenus);
        document.addEventListener('scroll', closeAllMenus, true);
        window.addEventListener('resize', closeAllMenus);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAllMenus();
        });
    });

    function closeAllMenus() {
        document.querySelectorAll('.action-menu').forEach(m => m.style.display = 'none');
    }

    function toggleMenu(e, menuId) {
        e.preventDefault();
        e.stopPropagation();
        const menu = document.getElementById(menuId);
        const isOpen = menu.style.display === 'block';
        closeAllMenus();
        if (isOpen) return;
        const rect = e.currentTarget.getBoundingClientRect();
        menu.style.display = 'block';
        let top = rect.bottom + 8;
        let left = rect.right - menu.offsetWidth;
        const pad = 10;
        if (left < pad) left = pad;
        if (top + menu.offsetHeight > window.innerHeight - pad) {
            top = rect.top - menu.offsetHeight - 8;
        }
        if (top < pad) top = pad;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
    }
</script>
@endpush
