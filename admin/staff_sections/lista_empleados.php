<?php
// Datos simulados de empleados
$empleados = [
    [
        'id' => 1001,
        'nombre' => 'Roberto Martínez García',
        'puesto' => 'Director General',
        'area' => 'Dirección',
        'plantel' => 'El Zapote',
        'salario_base' => 25000.00,
        'email' => 'roberto.martinez@iefk.edu.mx',
        'telefono' => '555-0101',
        'fecha_ingreso' => '2018-03-15',
        'tipo_contrato' => 'Indefinido',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 2,
        'prestamos_activos' => 0,
        'horario' => '07:00-16:00',
        'ultima_asistencia' => '2025-08-13 07:15',
        'faltas_mes' => 0,
        'antiguedad_anos' => 7.4,
        'proxima_evaluacion' => '2025-09-01'
    ],
    [
        'id' => 1015,
        'nombre' => 'Sandra López Ramírez',
        'puesto' => 'Maestra de Preescolar',
        'area' => 'Docencia',
        'plantel' => 'El Zapote',
        'salario_base' => 12800.00,
        'email' => 'sandra.lopez@iefk.edu.mx',
        'telefono' => '555-0115',
        'fecha_ingreso' => '2020-08-01',
        'tipo_contrato' => 'Indefinido',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 1,
        'prestamos_activos' => 1,
        'horario' => '07:30-14:30',
        'ultima_asistencia' => '2025-08-13 07:28',
        'faltas_mes' => 1,
        'antiguedad_anos' => 5.0,
        'proxima_evaluacion' => '2025-08-30'
    ],
    [
        'id' => 1023,
        'nombre' => 'Diego Hernández Silva',
        'puesto' => 'Coordinador Académico',
        'area' => 'Coordinación',
        'plantel' => 'Insurgentes',
        'salario_base' => 18500.00,
        'email' => 'diego.hernandez@iefk.edu.mx',
        'telefono' => '555-0123',
        'fecha_ingreso' => '2019-01-10',
        'tipo_contrato' => 'Indefinido',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 0,
        'prestamos_activos' => 0,
        'horario' => '08:00-16:00',
        'ultima_asistencia' => '2025-08-13 07:55',
        'faltas_mes' => 0,
        'antiguedad_anos' => 6.6,
        'proxima_evaluacion' => '2025-12-15'
    ],
    [
        'id' => 1034,
        'nombre' => 'María Fernández López',
        'puesto' => 'Recepcionista',
        'area' => 'Administrativo',
        'plantel' => 'Lindavista',
        'salario_base' => 9800.00,
        'email' => 'maria.fernandez@iefk.edu.mx',
        'telefono' => '555-0134',
        'fecha_ingreso' => '2025-07-01',
        'tipo_contrato' => 'Temporal',
        'modalidad_pago' => 'Efectivo',
        'status' => 'Activo',
        'hijos_estudiantes' => 0,
        'prestamos_activos' => 0,
        'horario' => '07:00-15:00',
        'ultima_asistencia' => '2025-08-13 06:58',
        'faltas_mes' => 0,
        'antiguedad_anos' => 0.1,
        'proxima_evaluacion' => '2025-10-01'
    ],
    [
        'id' => 1042,
        'nombre' => 'Carlos Rodríguez Silva',
        'puesto' => 'Conserje',
        'area' => 'Mantenimiento',
        'plantel' => 'Insurgentes',
        'salario_base' => 8500.00,
        'email' => 'carlos.rodriguez@iefk.edu.mx',
        'telefono' => '555-0142',
        'fecha_ingreso' => '2025-07-15',
        'tipo_contrato' => 'Temporal',
        'modalidad_pago' => 'Efectivo',
        'status' => 'Activo',
        'hijos_estudiantes' => 1,
        'prestamos_activos' => 0,
        'horario' => '06:00-14:00',
        'ultima_asistencia' => '2025-08-13 05:55',
        'faltas_mes' => 2,
        'antiguedad_anos' => 0.1,
        'proxima_evaluacion' => '2025-09-15'
    ],
    [
        'id' => 1038,
        'nombre' => 'Lucia Ramírez González',
        'puesto' => 'Administradora',
        'area' => 'Administrativo',
        'plantel' => 'El Zapote',
        'salario_base' => 16500.00,
        'email' => 'lucia.ramirez@iefk.edu.mx',
        'telefono' => '555-0138',
        'fecha_ingreso' => '2021-02-01',
        'tipo_contrato' => 'Indefinido',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 0,
        'prestamos_activos' => 2,
        'horario' => '08:00-17:00',
        'ultima_asistencia' => '2025-08-13 07:45',
        'faltas_mes' => 0,
        'antiguedad_anos' => 4.5,
        'proxima_evaluacion' => '2025-11-01'
    ],
    [
        'id' => 1029,
        'nombre' => 'José Antonio Morales',
        'puesto' => 'Maestro de Primaria',
        'area' => 'Docencia',
        'plantel' => 'Lindavista',
        'salario_base' => 13200.00,
        'email' => 'jose.morales@iefk.edu.mx',
        'telefono' => '555-0129',
        'fecha_ingreso' => '2022-09-01',
        'tipo_contrato' => 'Indefinido',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 3,
        'prestamos_activos' => 1,
        'horario' => '07:30-15:30',
        'ultima_asistencia' => '2025-08-12 15:30',
        'faltas_mes' => 1,
        'antiguedad_anos' => 2.9,
        'proxima_evaluacion' => '2025-09-01'
    ],
    [
        'id' => 1047,
        'nombre' => 'Ana García Mendoza',
        'puesto' => 'Maestra de Preescolar',
        'area' => 'Docencia',
        'plantel' => 'El Zapote',
        'salario_base' => 12500.00,
        'email' => 'ana.garcia@iefk.edu.mx',
        'telefono' => '555-0147',
        'fecha_ingreso' => '2025-08-01',
        'tipo_contrato' => 'Temporal',
        'modalidad_pago' => 'Transferencia',
        'status' => 'Activo',
        'hijos_estudiantes' => 0,
        'prestamos_activos' => 0,
        'horario' => '07:30-14:30',
        'ultima_asistencia' => '2025-08-13 07:32',
        'faltas_mes' => 0,
        'antiguedad_anos' => 0.04,
        'proxima_evaluacion' => '2025-11-01'
    ]
];

// Aplicar filtros si existen
$filtro_area = $_GET['area'] ?? '';
$filtro_plantel = $_GET['plantel'] ?? '';
$filtro_status = $_GET['status'] ?? '';
$busqueda = $_GET['search'] ?? '';

$empleados_filtrados = array_filter($empleados, function($emp) use ($filtro_area, $filtro_plantel, $filtro_status, $busqueda) {
    $match_area = empty($filtro_area) || $emp['area'] === $filtro_area;
    $match_plantel = empty($filtro_plantel) || $emp['plantel'] === $filtro_plantel;
    $match_status = empty($filtro_status) || $emp['status'] === $filtro_status;
    $match_search = empty($busqueda) || 
                   stripos($emp['nombre'], $busqueda) !== false ||
                   stripos($emp['puesto'], $busqueda) !== false ||
                   stripos($emp['email'], $busqueda) !== false;
    
    return $match_area && $match_plantel && $match_status && $match_search;
});

$total_empleados = count($empleados_filtrados);
?>

<!-- ===================== LISTA DE EMPLEADOS ===================== -->
<div class="lista-empleados">
    <!-- Header con Filtros y Búsqueda -->
    <div class="employees-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-users"></i> Lista de Empleados
            </h2>
            <p style="color: var(--gray-600);">
                Mostrando <?= $total_empleados ?> de <?= count($empleados) ?> empleados
            </p>
        </div>
        <div class="header-actions">
            <button class="btn btn-success" onclick="addNewEmployee()">
                <i class="fas fa-user-plus"></i> Nuevo Empleado
            </button>
            <button class="btn btn-warning" onclick="exportEmployees()">
                <i class="fas fa-file-excel"></i> Exportar
            </button>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="filters-section">
        <div class="search-container">
            <div class="search-box">
                <input type="text" 
                       id="employee-search" 
                       placeholder="Buscar por nombre, puesto o email..." 
                       value="<?= htmlspecialchars($busqueda) ?>"
                       onkeypress="if(event.key==='Enter') searchEmployees()">
                <button class="search-btn" onclick="searchEmployees()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <div class="filters-row">
            <select id="filter-area" onchange="applyFilters()">
                <option value="">Todas las Áreas</option>
                <option value="Dirección" <?= $filtro_area === 'Dirección' ? 'selected' : '' ?>>Dirección</option>
                <option value="Docencia" <?= $filtro_area === 'Docencia' ? 'selected' : '' ?>>Docencia</option>
                <option value="Administrativo" <?= $filtro_area === 'Administrativo' ? 'selected' : '' ?>>Administrativo</option>
                <option value="Coordinación" <?= $filtro_area === 'Coordinación' ? 'selected' : '' ?>>Coordinación</option>
                <option value="Mantenimiento" <?= $filtro_area === 'Mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
            </select>
            
            <select id="filter-plantel" onchange="applyFilters()">
                <option value="">Todos los Planteles</option>
                <option value="El Zapote" <?= $filtro_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                <option value="Insurgentes" <?= $filtro_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                <option value="Lindavista" <?= $filtro_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
            </select>
            
            <select id="filter-status" onchange="applyFilters()">
                <option value="">Todos los Estados</option>
                <option value="Activo" <?= $filtro_status === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $filtro_status === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                <option value="Suspendido" <?= $filtro_status === 'Suspendido' ? 'selected' : '' ?>>Suspendido</option>
            </select>
            
            <button class="btn btn-secondary" onclick="clearFilters()">
                <i class="fas fa-times"></i> Limpiar
            </button>
        </div>
    </div>

    <!-- Grid de Empleados -->
    <div class="employees-grid">
        <?php foreach ($empleados_filtrados as $empleado): ?>
        <div class="employee-card" onclick="viewEmployeeFile(<?= $empleado['id'] ?>)">
            <!-- Header de la Tarjeta -->
            <div class="employee-card-header">
                <div class="employee-avatar">
                    <?= strtoupper(substr($empleado['nombre'], 0, 1) . substr(strstr($empleado['nombre'], ' '), 1, 1)) ?>
                </div>
                <div class="employee-basic-info">
                    <h3><?= $empleado['nombre'] ?></h3>
                    <p class="employee-position"><?= $empleado['puesto'] ?></p>
                    <p class="employee-id">ID: <?= $empleado['id'] ?></p>
                </div>
                <div class="employee-status">
                    <span class="badge badge-<?= strtolower($empleado['status']) === 'activo' ? 'active' : 'inactive' ?>">
                        <?= $empleado['status'] ?>
                    </span>
                </div>
            </div>

            <!-- Información Principal -->
            <div class="employee-main-info">
                <div class="info-row">
                    <div class="info-item">
                        <i class="fas fa-building"></i>
                        <span><?= $empleado['plantel'] ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tag"></i>
                        <span><?= $empleado['area'] ?></span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span><?= $empleado['email'] ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span><?= $empleado['telefono'] ?></span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <span>Ingreso: <?= date('d/m/Y', strtotime($empleado['fecha_ingreso'])) ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span><?= $empleado['horario'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Información Financiera -->
            <div class="employee-financial-info">
                <div class="salary-info">
                    <div class="salary-amount">
                        $<?= number_format($empleado['salario_base']) ?>
                    </div>
                    <div class="salary-label">Salario Base</div>
                </div>
                <div class="payment-method">
                    <i class="fas fa-<?= $empleado['modalidad_pago'] === 'Transferencia' ? 'university' : 'money-bill' ?>"></i>
                    <span><?= $empleado['modalidad_pago'] ?></span>
                </div>
            </div>

            <!-- Indicadores -->
            <div class="employee-indicators">
                <?php if ($empleado['hijos_estudiantes'] > 0): ?>
                <div class="indicator children">
                    <i class="fas fa-baby"></i>
                    <span><?= $empleado['hijos_estudiantes'] ?> hijo(s)</span>
                </div>
                <?php endif; ?>
                
                <?php if ($empleado['prestamos_activos'] > 0): ?>
                <div class="indicator loans">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span><?= $empleado['prestamos_activos'] ?> préstamo(s)</span>
                </div>
                <?php endif; ?>
                
                <?php if ($empleado['faltas_mes'] > 0): ?>
                <div class="indicator absences">
                    <i class="fas fa-calendar-times"></i>
                    <span><?= $empleado['faltas_mes'] ?> falta(s)</span>
                </div>
                <?php endif; ?>
                
                <div class="indicator seniority">
                    <i class="fas fa-award"></i>
                    <span><?= number_format($empleado['antiguedad_anos'], 1) ?> años</span>
                </div>
            </div>

            <!-- Última Actividad -->
            <div class="employee-last-activity">
                <div class="activity-item">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Última entrada: <?= date('d/m H:i', strtotime($empleado['ultima_asistencia'])) ?></span>
                </div>
                <div class="activity-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Próxima evaluación: <?= date('d/m/Y', strtotime($empleado['proxima_evaluacion'])) ?></span>
                </div>
            </div>

            <!-- Acciones -->
            <div class="employee-actions">
                <button class="btn btn-primary btn-sm" onclick="viewEmployeeFile(<?= $empleado['id'] ?>); event.stopPropagation();">
                    <i class="fas fa-eye"></i> Ver Ficha
                </button>
                <button class="btn btn-warning btn-sm" onclick="editEmployee(<?= $empleado['id'] ?>); event.stopPropagation();">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="btn btn-info btn-sm" onclick="generateQR(<?= $empleado['id'] ?>); event.stopPropagation();">
                    <i class="fas fa-qrcode"></i> QR
                </button>
                <button class="btn btn-secondary btn-sm" onclick="showEmployeeMenu(<?= $empleado['id'] ?>); event.stopPropagation();">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Resumen de Estadísticas -->
    <?php if ($total_empleados > 0): ?>
    <div class="employees-summary">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
            <i class="fas fa-chart-bar"></i> Resumen de Empleados Mostrados
        </h3>
        <div class="summary-stats">
            <div class="summary-item">
                <div class="summary-number"><?= $total_empleados ?></div>
                <div class="summary-label">Total Empleados</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">$<?= number_format(array_sum(array_column($empleados_filtrados, 'salario_base'))) ?></div>
                <div class="summary-label">Nómina Total</div>
            </div>
            <div class="summary-item">
                <div class="summary-number"><?= array_sum(array_column($empleados_filtrados, 'prestamos_activos')) ?></div>
                <div class="summary-label">Préstamos Activos</div>
            </div>
            <div class="summary-item">
                <div class="summary-number"><?= array_sum(array_column($empleados_filtrados, 'hijos_estudiantes')) ?></div>
                <div class="summary-label">Hijos Estudiantes</div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="no-employees">
        <div class="no-employees-icon">
            <i class="fas fa-users-slash"></i>
        </div>
        <h3>No se encontraron empleados</h3>
        <p>No hay empleados que coincidan con los filtros aplicados.</p>
        <button class="btn btn-primary" onclick="clearFilters()">
            <i class="fas fa-refresh"></i> Limpiar Filtros
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .lista-empleados {
        animation: fadeIn 0.5s ease;
    }

    .employees-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .filters-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .search-container {
        margin-bottom: 1.5rem;
    }

    .search-box {
        position: relative;
        max-width: 500px;
    }

    .search-box input {
        width: 100%;
        padding: 1rem 3rem 1rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .search-btn {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: var(--primary-color);
        border: none;
        color: var(--dark);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .search-btn:hover {
        background: var(--primary-dark);
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)) auto;
        gap: 1rem;
        align-items: center;
    }

    .filters-row select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        color: var(--dark);
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .filters-row select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .employees-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .employee-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
    }

    .employee-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .employee-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--primary-light);
        border-bottom: 1px solid var(--gray-200);
    }

    .employee-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-color);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        border: 3px solid var(--white);
    }

    .employee-basic-info {
        flex: 1;
    }

    .employee-basic-info h3 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .employee-position {
        color: var(--gray-600);
        font-weight: 600;
        margin: 0;
        font-size: 0.9rem;
    }

    .employee-id {
        color: var(--gray-500);
        font-size: 0.8rem;
        margin: 0.25rem 0 0 0;
    }

    .employee-main-info {
        padding: 1.5rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--gray-700);
    }

    .info-item i {
        color: var(--primary-color);
        width: 16px;
    }

    .employee-financial-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-top: 1px solid var(--gray-200);
        border-bottom: 1px solid var(--gray-200);
    }

    .salary-amount {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--success-color);
    }

    .salary-label {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .payment-method {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .payment-method i {
        color: var(--info-color);
    }

    .employee-indicators {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
    }

    .indicator {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .indicator.children {
        background: var(--info-light);
        color: var(--info-color);
    }

    .indicator.loans {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .indicator.absences {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .indicator.seniority {
        background: var(--success-light);
        color: var(--success-color);
    }

    .employee-last-activity {
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-top: 1px solid var(--gray-200);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-item i {
        color: var(--primary-color);
        width: 14px;
    }

    .employee-actions {
        display: flex;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background: var(--white);
    }

    .employees-summary {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
    }

    .summary-item {
        text-align: center;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
    }

    .summary-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .summary-label {
        color: var(--gray-600);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .no-employees {
        text-align: center;
        padding: 3rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .no-employees-icon {
        font-size: 3rem;
        color: var(--gray-400);
        margin-bottom: 1rem;
    }

    .no-employees h3 {
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .no-employees p {
        color: var(--gray-500);
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .employees-header {
            flex-direction: column;
            gap: 1rem;
        }

        .employees-grid {
            grid-template-columns: 1fr;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .employee-actions {
            flex-wrap: wrap;
        }

        .summary-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para buscar empleados
    function searchEmployees() {
        const search = document.getElementById('employee-search').value;
        applyFilters();
    }

    // Función para aplicar filtros
    function applyFilters() {
        const search = document.getElementById('employee-search').value;
        const area = document.getElementById('filter-area').value;
        const plantel = document.getElementById('filter-plantel').value;
        const status = document.getElementById('filter-status').value;
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (area) params.append('area', area);
        if (plantel) params.append('plantel', plantel);
        if (status) params.append('status', status);
        
        const url = `?section=lista_empleados&${params.toString()}`;
        window.location.href = url;
    }

    // Función para limpiar filtros
    function clearFilters() {
        document.getElementById('employee-search').value = '';
        document.getElementById('filter-area').value = '';
        document.getElementById('filter-plantel').value = '';
        document.getElementById('filter-status').value = '';
        window.location.href = '?section=lista_empleados';
    }

    // Función para generar código QR
    function generateQR(employeeId) {
        alert(`Generar Código QR\n\nEmpleado ID: ${employeeId}\n\nSe generará un código QR único para:\n• Control de asistencia\n• Acceso a sistemas\n• Identificación rápida`);
    }

    // Función para mostrar menú de empleado
    function showEmployeeMenu(employeeId) {
        alert(`Menú de Empleado ${employeeId}\n\nOpciones disponibles:\n• Ver historial de pagos\n• Gestionar préstamos\n• Solicitar permisos\n• Ver evaluaciones\n• Contactar HR`);
    }

    // Función para agregar empleado
    function addNewEmployee() {
        alert('Agregar Nuevo Empleado\n\nSe abrirá el formulario de registro con los siguientes campos:\n• Datos personales\n• Información laboral\n• Datos de contacto\n• Configuración de nómina\n• Asignación de horarios');
    }

    // Función para exportar empleados
    function exportEmployees() {
        if(confirm('¿Exportar lista de empleados?\n\nSe generará un archivo Excel con:\n• Lista completa filtrada\n• Información de contacto\n• Datos laborales\n• Estado de nómina')) {
            alert('Generando archivo de exportación...\n\nEl archivo incluirá todos los empleados mostrados con sus datos completos.');
        }
    }

    // Animaciones al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.employee-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 50);
        });
    });
</script>
