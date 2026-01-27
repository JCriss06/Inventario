<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table {
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        .header-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .logo-img {
            max-width: 60px;
            height: auto;
            padding-right: 15px;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
        }

        .company-sub {
            font-size: 9px;
            color: #666;
        }

        .header-right {
            text-align: right;
        }

        .header-right-title {
            font-size: 11px;
            font-weight: bold;
            color: #e74c3c;
            text-transform: uppercase;
        }

        .header-right-date {
            font-size: 9px;
            color: #666;
        }

        .kpi-table {
            margin-bottom: 15px;
        }

        .kpi-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #e0e0e0;
            background-color: #f9fafb;
            width: 25%;
        }

        .kpi-label {
            font-size: 9px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        .kpi-table td:nth-child(1) {
            border-left: 4px solid #27ae60;
        }

        .kpi-table td:nth-child(1) .kpi-value {
            color: #27ae60;
        }

        .kpi-table td:nth-child(2) {
            border-left: 4px solid #e74c3c;
        }

        .kpi-table td:nth-child(2) .kpi-value {
            color: #e74c3c;
        }

        .kpi-table td:nth-child(3) {
            border-left: 4px solid #3498db;
        }

        .kpi-table td:nth-child(3) .kpi-value {
            color: #3498db;
        }

        .kpi-table td:nth-child(4) {
            border-left: 4px solid #95a5a6;
        }

        .kpi-table td:nth-child(4) .kpi-value {
            color: #95a5a6;
        }

        .filters-box {
            background-color: #f8f9fa;
            border-left: 3px solid #3498db;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 8px;
            margin-top: 10px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }

        .data-table {
            margin-bottom: 10px;
            font-size: 9px;
        }

        .data-table thead {
            background-color: #34495e;
            color: white;
        }

        .data-table th {
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2c3e50;
            font-size: 8px;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 7px 6px;
            border: 1px solid #e0e0e0;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-entrada {
            background-color: #d5f4e6;
            color: #27ae60;
        }

        .badge-salida {
            background-color: #fadbd8;
            color: #e74c3c;
        }

        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
            text-align: right;
            font-size: 8px;
            color: #999;
        }

        .empty-state {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td style="width: 80px;">
                <img src="{{ $logoBase64 }}" alt="Logo" class="logo-img">
            </td>
            <td style="width: auto;">
                <div class="company-name">TSM Sistemas Integrales</div>
                <div class="company-sub">Sistema de Gestión de Inventario</div>
            </td>
            <td style="width: 150px;">
                <div class="header-right-title">Reporte de Movimientos</div>
                <div class="header-right-date">{{ now()->format('d/m/Y H:i:s') }}</div>
            </td>
        </tr>
    </table>

    <!-- KPIs -->
    <table class="kpi-table">
        <tr>
            <td>
                <div class="kpi-label">Entradas</div>
                <div class="kpi-value">{{ $totalEntradas }}</div>
            </td>
            <td>
                <div class="kpi-label">Salidas</div>
                <div class="kpi-value">{{ $totalSalidas }}</div>
            </td>
            <td>
                <div class="kpi-label">Movimientos</div>
                <div class="kpi-value">{{ $reportes->count() }}</div>
            </td>
            <td>
                <div class="kpi-label">Período</div>
                <div class="kpi-value">Mes</div>
            </td>
        </tr>
    </table>

    <!-- FILTROS -->
    @if($request->filled('periodo') || $request->filled('producto') || $request->filled('tipo') || ($request->filled('fecha_inicio') && $request->filled('fecha_fin')))
    <div class="filters-box">
        <strong>Filtros Aplicados:</strong><br>
        @if($request->filled('periodo'))
            <strong>Período:</strong> {{ ucfirst($request->periodo) }}<br>
        @endif
        @if($request->filled('producto'))
            <strong>Producto:</strong> {{ \App\Models\Product::find($request->producto)?->clave ?? 'N/A' }}<br>
        @endif
        @if($request->filled('tipo'))
            <strong>Tipo:</strong> {{ ucfirst($request->tipo) }}<br>
        @endif
        @if($request->filled('fecha_inicio') && $request->filled('fecha_fin'))
            <strong>Rango:</strong> {{ $request->fecha_inicio }} al {{ $request->fecha_fin }}<br>
        @endif
    </div>
    @endif

    <!-- TABLA -->
    <div class="section-title">Detalle de Movimientos</div>

    @if($reportes->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%">#</th>
                <th style="width: 10%">Clave</th>
                <th style="width: 18%">Descripción</th>
                <th style="width: 12%">Marca</th>
                <th style="width: 8%; text-align: center">Cant.</th>
                <th style="width: 10%; text-align: center">Tipo</th>
                <th style="width: 16%">Fecha</th>
                <th style="width: 12%">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportes as $key => $reporte)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td><strong>{{ $reporte->product->clave ?? 'N/A' }}</strong></td>
                <td>{{ substr($reporte->product->descripcion ?? 'N/A', 0, 28) }}</td>
                <td>{{ $reporte->product->marca ?? 'N/A' }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $reporte->cantidad }}</td>
                <td style="text-align: center;">
                    @if(strtolower($reporte->tipo_reporte) === 'entrada')
                        <span class="badge badge-entrada">Ent</span>
                    @else
                        <span class="badge badge-salida">Sal</span>
                    @endif
                </td>
                <td>{{ $reporte->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $reporte->user->name ?? 'Sistema' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        No hay movimientos de inventario con los filtros aplicados.
    </div>
    @endif

    <div class="footer">
        TSM Sistemas Integrales © 2026 | Generado: {{ now()->format('d \d\e F \d\e Y') }}
    </div>
</body>
</html>
