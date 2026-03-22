<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\Product;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Crear productos
$productos = [
    ['clave' => 'SERV-001', 'descripcion' => 'Servidor Dell PowerEdge R750 - 2x Xeon Gold 6348', 'marca' => 'Dell', 'stock' => 3],
    ['clave' => 'SERV-002', 'descripcion' => 'Servidor HP ProLiant DL380 Gen10 - 2x Xeon Platinum', 'marca' => 'HP', 'stock' => 2],
    ['clave' => 'SERV-003', 'descripcion' => 'Servidor Lenovo ThinkSystem SR650 - 2x Xeon Silver', 'marca' => 'Lenovo', 'stock' => 5],
    ['clave' => 'CAM-001', 'descripcion' => 'Cámara de vigilancia Hikvision IP 4K 8MP', 'marca' => 'Hikvision', 'stock' => 12],
    ['clave' => 'CAM-002', 'descripcion' => 'Cámara de vigilancia Dahua 5MP Dome', 'marca' => 'Dahua', 'stock' => 8],
    ['clave' => 'CAM-003', 'descripcion' => 'Cámara Uniview Bullet 2K', 'marca' => 'Uniview', 'stock' => 6],
    ['clave' => 'PC-001', 'descripcion' => 'Computadora Dell OptiPlex 7090 Desktop', 'marca' => 'Dell', 'stock' => 15],
    ['clave' => 'PC-002', 'descripcion' => 'Computadora Lenovo ThinkCentre M90', 'marca' => 'Lenovo', 'stock' => 10],
    ['clave' => 'PC-003', 'descripcion' => 'Laptop Dell XPS 15 - i7 - 32GB RAM - 1TB SSD', 'marca' => 'Dell', 'stock' => 4],
    ['clave' => 'MONITOR-001', 'descripcion' => 'Monitor LG 27" 4K UltraFine USB-C', 'marca' => 'LG', 'stock' => 8],
    ['clave' => 'MONITOR-002', 'descripcion' => 'Monitor Dell 24" P2423DE IPS', 'marca' => 'Dell', 'stock' => 11],
    ['clave' => 'TECLADO-001', 'descripcion' => 'Teclado Logitech MX Keys - Wireless', 'marca' => 'Logitech', 'stock' => 25],
    ['clave' => 'MOUSE-001', 'descripcion' => 'Mouse Logitech MX Master 3S - Wireless', 'marca' => 'Logitech', 'stock' => 20],
    ['clave' => 'SWITCH-001', 'descripcion' => 'Switch Cisco Catalyst 2960-X 48 Puertos Gigabit', 'marca' => 'Cisco', 'stock' => 2],
    ['clave' => 'SWITCH-002', 'descripcion' => 'Switch Netgear ProSAFE GS110 16 Puertos', 'marca' => 'Netgear', 'stock' => 3],
    ['clave' => 'ROUTER-001', 'descripcion' => 'Router MikroTik hEX PoE', 'marca' => 'MikroTik', 'stock' => 4],
    ['clave' => 'FIREWALL-001', 'descripcion' => 'Firewall Fortinet FortiGate 100F', 'marca' => 'Fortinet', 'stock' => 1],
    ['clave' => 'PRINTER-001', 'descripcion' => 'Impresora HP LaserJet Pro M428fdw', 'marca' => 'HP', 'stock' => 2],
];

foreach ($productos as $datos) {
    try {
        Product::create($datos);
        echo "✓ Creado: {$datos['clave']}\n";
    } catch (\Exception $e) {
        echo "✗ Error al crear {$datos['clave']}: {$e->getMessage()}\n";
    }
}

echo "\n✅ Datos de prueba creados exitosamente\n";
