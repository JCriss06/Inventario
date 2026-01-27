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
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }
        
        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 10px;
        }
        
        .summary {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .summary-card {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-card.entradas {
            background-color: #dcfce7;
            border-left: 4px solid #16a34a;
        }
        
        .summary-card.salidas {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
        }
        
        .summary-card h3 {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }
        
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f3f4f6;
            border-radius: 5px;
            font-size: 9px;
        }
        
        .filters p {
            margin: 3px 0;
        }
        
        .filters strong {
            color: #1e40af;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        thead {
            background-color: #2563eb;
            color: white;
        }
        
        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: #eff6ff;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge.entrada {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge.salida {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
        
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Reporte de Inventario</h1>
        <p>TSM Sistemas Integrales</p>
        <p>Generado: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card entradas">
            <h3>Total Entradas</h3>
            <div class="value">{{ $totalEntradas }}</div>
        </div>
        <div class="summary-card salidas">
            <h3>Total Salidas</h3>
            <div class="value">{{ $totalSalidas }}</div>
        </div>
        <div class="summary-card" style="background-color: #dbeafe; border-left: 4px solid #2563eb;">
            <h3>Movimientos Registrados</h3>
            <div class="value">{{ $reportes->count() }}</div>
        </div>
    </div>

    @if($request->filled('periodo') || $request->filled('producto') || $request->filled('tipo') || ($request->filled('fecha_inicio') && $request->filled('fecha_fin')))
    <div class="filters">
        <strong>Filtros Aplicados:</strong><br>
        @if($request->filled('periodo'))
            <p><strong>Período:</strong> {{ ucfirst($request->periodo) }}</p>
        @endif
        @if($request->filled('producto'))
            <p><strong>Producto:</strong> {{ \App\Models\Product::find($request->producto)?->clave ?? 'N/A' }}</p>
        @endif
        @if($request->filled('tipo'))
            <p><strong>Tipo:</strong> {{ ucfirst($request->tipo) }}</p>
        @endif
        @if($request->filled('fecha_inicio') && $request->filled('fecha_fin'))
            <p><strong>Rango de Fechas:</strong> {{ $request->fecha_inicio }} al {{ $request->fecha_fin }}</p>
        @endif
    </div>
    @endif

    @if($reportes->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Clave</th>
                <th style="width: 20%;">Descripción</th>
                <th style="width: 12%;">Marca</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 10%;">Tipo</th>
                <th style="width: 16%;">Fecha</th>
                <th style="width: 10%;">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportes as $reporte)
            <tr>
                <td><strong>{{ $reporte->product->clave ?? 'N/A' }}</strong></td>
                <td>{{ $reporte->product->descripcion ?? 'N/A' }}</td>
                <td>{{ $reporte->product->marca ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $reporte->cantidad }}</td>
                <td style="text-align: center;">
                    <span class="badge {{ strtolower($reporte->tipo_reporte) }}">
                        {{ ucfirst($reporte->tipo_reporte) }}
                    </span>
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
        <p>Reporte generado automáticamente el {{ now()->format('d \d\e F \d\e Y \a \l\a\s H:i:s') }}</p>
    </div>
</body>
</html>
