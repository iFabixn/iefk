<?php
// Datos simulados de nómina
$fecha_actual = date('Y-m-d');
$mes_actual = date('m');
$ano_actual = date('Y');

// Periodo de nómina actual
$periodo_actual = [
    'inicio' => date('Y-m-01'),
    'fin' => date('Y-m-t'),
    'quincenal_1' => date('Y-m-01') . ' al ' . date('Y-m-15'),
    'quincenal_2' => date('Y-m-16') . ' al ' . date('Y-m-t'),
    'tipo' => $_GET['tipo'] ?? 'quincenal'
];

// Resumen de nómina
$resumen_nomina = [
    'total_empleados' => 42,
    'empleados_activos' => 39,
    'empleados_temporales' => 8,
    'total_nomina_bruta' => 587500.00,
    'total_deducciones' => 120375.00,
    'total_nomina_neta' => 467125.00,
    'total_prestaciones' => 58750.00,
    'promedio_salarial' => 15064.10
];

// Empleados para nómina (datos extendidos)
$empleados_nomina = [
    [
        'id' => 1001,
        'nombre' => 'Roberto Martínez García',
        'puesto' => 'Director General',
        'area' => 'Dirección',
        'plantel' => 'El Zapote',
        'salario_base' => 25000.00,
        'dias_trabajados' => 30,
        'horas_extra' => 5,
        'bonos' => 2500.00,
        'prestaciones' => 2500.00,
        'deduccion_imss' => 625.00,
        'deduccion_isr' => 3750.00,
        'otras_deducciones' => 0.00,
        'descuentos' => 0.00,
        'prestamo_deduccion' => 0.00,
        'neto_pagar' => 20625.00,
        'status_pago' => 'Pendiente',
        'modalidad_pago' => 'Transferencia',
        'cuenta_bancaria' => '1234567890'
    ],
    [
        'id' => 1015,
        'nombre' => 'Sandra López Ramírez',
        'puesto' => 'Maestra de Preescolar',
        'area' => 'Docencia',
        'plantel' => 'El Zapote',
        'salario_base' => 12800.00,
        'dias_trabajados' => 29,
        'horas_extra' => 2,
        'bonos' => 500.00,
        'prestaciones' => 1280.00,
        'deduccion_imss' => 320.00,
        'deduccion_isr' => 1280.00,
        'otras_deducciones' => 0.00,
        'descuentos' => 0.00,
        'prestamo_deduccion' => 800.00,
        'neto_pagar' => 10900.00,
        'status_pago' => 'Pagado',
        'modalidad_pago' => 'Transferencia',
        'cuenta_bancaria' => '9876543210'
    ],
    [
        'id' => 1023,
        'nombre' => 'Diego Hernández Silva',
        'puesto' => 'Coordinador Académico',
        'area' => 'Coordinación',
        'plantel' => 'Insurgentes',
        'salario_base' => 18500.00,
        'dias_trabajados' => 30,
        'horas_extra' => 3,
        'bonos' => 1000.00,
        'prestaciones' => 1850.00,
        'deduccion_imss' => 462.50,
        'deduccion_isr' => 2220.00,
        'otras_deducciones' => 0.00,
        'descuentos' => 0.00,
        'prestamo_deduccion' => 0.00,
        'neto_pagar' => 15817.50,
        'status_pago' => 'Pendiente',
        'modalidad_pago' => 'Transferencia',
        'cuenta_bancaria' => '5555666677'
    ],
    [
        'id' => 1034,
        'nombre' => 'María Fernández López',
        'puesto' => 'Recepcionista',
        'area' => 'Administrativo',
        'plantel' => 'Lindavista',
        'salario_base' => 9800.00,
        'dias_trabajados' => 30,
        'horas_extra' => 0,
        'bonos' => 200.00,
        'prestaciones' => 980.00,
        'deduccion_imss' => 245.00,
        'deduccion_isr' => 490.00,
        'otras_deducciones' => 0.00,
        'descuentos' => 0.00,
        'prestamo_deduccion' => 0.00,
        'neto_pagar' => 8265.00,
        'status_pago' => 'Procesando',
        'modalidad_pago' => 'Efectivo',
        'cuenta_bancaria' => ''
    ],
    [
        'id' => 1042,
        'nombre' => 'Carlos Rodríguez Silva',
        'puesto' => 'Conserje',
        'area' => 'Mantenimiento',
        'plantel' => 'Insurgentes',
        'salario_base' => 8500.00,
        'dias_trabajados' => 28,
        'horas_extra' => 8,
        'bonos' => 0.00,
        'prestaciones' => 850.00,
        'deduccion_imss' => 212.50,
        'deduccion_isr' => 340.00,
        'otras_deducciones' => 0.00,
        'descuentos' => 150.00,
        'prestamo_deduccion' => 0.00,
        'neto_pagar' => 7247.50,
        'status_pago' => 'Pendiente',
        'modalidad_pago' => 'Efectivo',
        'cuenta_bancaria' => ''
    ]
];

// Aplicar filtros
$filtro_area = $_GET['area'] ?? '';
$filtro_plantel = $_GET['plantel'] ?? '';
$filtro_status = $_GET['status_pago'] ?? '';

$empleados_filtrados = array_filter($empleados_nomina, function($emp) use ($filtro_area, $filtro_plantel, $filtro_status) {
    $match_area = empty($filtro_area) || $emp['area'] === $filtro_area;
    $match_plantel = empty($filtro_plantel) || $emp['plantel'] === $filtro_plantel;
    $match_status = empty($filtro_status) || $emp['status_pago'] === $filtro_status;
    
    return $match_area && $match_plantel && $match_status;
});
?>

<!-- ===================== NÓMINA Y SALARIOS ===================== -->
<div class="nomina-salarios">
    <!-- Header Principal -->
    <div class="nomina-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-calculator"></i> Nómina y Salarios
            </h2>
            <p style="color: var(--gray-600);">
                Periodo: <?= date('F Y', strtotime($periodo_actual['inicio'])) ?> 
                (<?= $periodo_actual['tipo'] === 'quincenal' ? 'Quincenal' : 'Mensual' ?>)
            </p>
        </div>
        <div class="header-actions">
            <select id="periodo-tipo" onchange="changePeriodType()">
                <option value="quincenal" <?= $periodo_actual['tipo'] === 'quincenal' ? 'selected' : '' ?>>Quincenal</option>
                <option value="mensual" <?= $periodo_actual['tipo'] === 'mensual' ? 'selected' : '' ?>>Mensual</option>
                <option value="semanal" <?= $periodo_actual['tipo'] === 'semanal' ? 'selected' : '' ?>>Semanal</option>
            </select>
            <button class="btn btn-success" onclick="processPayroll()">
                <i class="fas fa-play"></i> Procesar Nómina
            </button>
            <button class="btn btn-warning" onclick="exportPayroll()">
                <i class="fas fa-file-excel"></i> Exportar
            </button>
        </div>
    </div>

    <!-- Resumen de Nómina -->
    <div class="nomina-summary">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-chart-pie"></i> Resumen del Periodo
        </h3>
        <div class="summary-grid">
            <div class="summary-card total">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <div class="card-number"><?= $resumen_nomina['total_empleados'] ?></div>
                    <div class="card-label">Total Empleados</div>
                    <div class="card-detail">
                        <?= $resumen_nomina['empleados_activos'] ?> activos, 
                        <?= $resumen_nomina['empleados_temporales'] ?> temporales
                    </div>
                </div>
            </div>

            <div class="summary-card bruto">
                <div class="card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-content">
                    <div class="card-number">$<?= number_format($resumen_nomina['total_nomina_bruta']) ?></div>
                    <div class="card-label">Nómina Bruta</div>
                    <div class="card-detail">Salarios + Prestaciones + Bonos</div>
                </div>
            </div>

            <div class="summary-card deducciones">
                <div class="card-icon">
                    <i class="fas fa-minus-circle"></i>
                </div>
                <div class="card-content">
                    <div class="card-number">$<?= number_format($resumen_nomina['total_deducciones']) ?></div>
                    <div class="card-label">Total Deducciones</div>
                    <div class="card-detail">IMSS + ISR + Préstamos</div>
                </div>
            </div>

            <div class="summary-card neto">
                <div class="card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-content">
                    <div class="card-number">$<?= number_format($resumen_nomina['total_nomina_neta']) ?></div>
                    <div class="card-label">Nómina Neta</div>
                    <div class="card-detail">Total a Pagar</div>
                </div>
            </div>

            <div class="summary-card prestaciones">
                <div class="card-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="card-content">
                    <div class="card-number">$<?= number_format($resumen_nomina['total_prestaciones']) ?></div>
                    <div class="card-label">Prestaciones</div>
                    <div class="card-detail">Aguinaldo + Prima Vacacional</div>
                </div>
            </div>

            <div class="summary-card promedio">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-content">
                    <div class="card-number">$<?= number_format($resumen_nomina['promedio_salarial']) ?></div>
                    <div class="card-label">Promedio Salarial</div>
                    <div class="card-detail">Por empleado</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Nómina -->
    <div class="nomina-filters">
        <div class="filters-row">
            <select id="filter-area" onchange="applyPayrollFilters()">
                <option value="">Todas las Áreas</option>
                <option value="Dirección" <?= $filtro_area === 'Dirección' ? 'selected' : '' ?>>Dirección</option>
                <option value="Docencia" <?= $filtro_area === 'Docencia' ? 'selected' : '' ?>>Docencia</option>
                <option value="Administrativo" <?= $filtro_area === 'Administrativo' ? 'selected' : '' ?>>Administrativo</option>
                <option value="Coordinación" <?= $filtro_area === 'Coordinación' ? 'selected' : '' ?>>Coordinación</option>
                <option value="Mantenimiento" <?= $filtro_area === 'Mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
            </select>
            
            <select id="filter-plantel" onchange="applyPayrollFilters()">
                <option value="">Todos los Planteles</option>
                <option value="El Zapote" <?= $filtro_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                <option value="Insurgentes" <?= $filtro_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                <option value="Lindavista" <?= $filtro_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
            </select>
            
            <select id="filter-status" onchange="applyPayrollFilters()">
                <option value="">Todos los Estados</option>
                <option value="Pendiente" <?= $filtro_status === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="Procesando" <?= $filtro_status === 'Procesando' ? 'selected' : '' ?>>Procesando</option>
                <option value="Pagado" <?= $filtro_status === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
            </select>
            
            <button class="btn btn-primary" onclick="calculateAll()">
                <i class="fas fa-calculator"></i> Calcular Todo
            </button>
            
            <button class="btn btn-info" onclick="generateReports()">
                <i class="fas fa-file-invoice"></i> Recibos
            </button>
        </div>
    </div>

    <!-- Tabla de Nómina -->
    <div class="nomina-table-container">
        <div class="table-header">
            <h3 style="color: var(--primary-color);">
                <i class="fas fa-table"></i> Detalle de Nómina
            </h3>
            <div class="table-actions">
                <button class="btn btn-sm btn-success" onclick="selectAll()">
                    <i class="fas fa-check-double"></i> Seleccionar Todo
                </button>
                <button class="btn btn-sm btn-warning" onclick="processSelected()">
                    <i class="fas fa-credit-card"></i> Pagar Seleccionados
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="nomina-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all" onchange="toggleSelectAll()"></th>
                        <th>Empleado</th>
                        <th>Puesto</th>
                        <th>Días Trab.</th>
                        <th>Salario Base</th>
                        <th>H. Extra</th>
                        <th>Bonos</th>
                        <th>Prestaciones</th>
                        <th>Bruto</th>
                        <th>IMSS</th>
                        <th>ISR</th>
                        <th>Préstamos</th>
                        <th>Descuentos</th>
                        <th>Total Deduc.</th>
                        <th>Neto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados_filtrados as $emp): 
                        $total_bruto = $emp['salario_base'] + $emp['bonos'] + $emp['prestaciones'] + ($emp['horas_extra'] * 150);
                        $total_deducciones = $emp['deduccion_imss'] + $emp['deduccion_isr'] + $emp['prestamo_deduccion'] + $emp['otras_deducciones'] + $emp['descuentos'];
                        $neto_real = $total_bruto - $total_deducciones;
                    ?>
                    <tr class="employee-row" data-employee="<?= $emp['id'] ?>">
                        <td><input type="checkbox" class="employee-select" value="<?= $emp['id'] ?>"></td>
                        <td>
                            <div class="employee-info">
                                <strong><?= $emp['nombre'] ?></strong>
                                <small>ID: <?= $emp['id'] ?></small>
                            </div>
                        </td>
                        <td><?= $emp['puesto'] ?></td>
                        <td class="text-center"><?= $emp['dias_trabajados'] ?></td>
                        <td class="amount">$<?= number_format($emp['salario_base']) ?></td>
                        <td class="text-center"><?= $emp['horas_extra'] ?></td>
                        <td class="amount">$<?= number_format($emp['bonos']) ?></td>
                        <td class="amount">$<?= number_format($emp['prestaciones']) ?></td>
                        <td class="amount gross">$<?= number_format($total_bruto) ?></td>
                        <td class="amount deduction">$<?= number_format($emp['deduccion_imss']) ?></td>
                        <td class="amount deduction">$<?= number_format($emp['deduccion_isr']) ?></td>
                        <td class="amount deduction">$<?= number_format($emp['prestamo_deduccion']) ?></td>
                        <td class="amount deduction">$<?= number_format($emp['descuentos']) ?></td>
                        <td class="amount total-deduction">$<?= number_format($total_deducciones) ?></td>
                        <td class="amount net">$<?= number_format($neto_real) ?></td>
                        <td>
                            <span class="status-badge status-<?= strtolower($emp['status_pago']) ?>">
                                <?= $emp['status_pago'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-primary" onclick="editPayroll(<?= $emp['id'] ?>)" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info" onclick="viewPayrollDetail(<?= $emp['id'] ?>)" title="Ver Detalle">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success" onclick="generatePayStub(<?= $emp['id'] ?>)" title="Recibo">
                                    <i class="fas fa-receipt"></i>
                                </button>
                                <?php if ($emp['status_pago'] === 'Pendiente'): ?>
                                <button class="btn btn-sm btn-warning" onclick="processPayment(<?= $emp['id'] ?>)" title="Procesar Pago">
                                    <i class="fas fa-credit-card"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="totals-row">
                        <td colspan="4"><strong>TOTALES:</strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'salario_base'))) ?></strong></td>
                        <td class="text-center"><strong><?= array_sum(array_column($empleados_filtrados, 'horas_extra')) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'bonos'))) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'prestaciones'))) ?></strong></td>
                        <td class="amount gross"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'salario_base')) + array_sum(array_column($empleados_filtrados, 'bonos')) + array_sum(array_column($empleados_filtrados, 'prestaciones'))) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'deduccion_imss'))) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'deduccion_isr'))) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'prestamo_deduccion'))) ?></strong></td>
                        <td class="amount"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'descuentos'))) ?></strong></td>
                        <td class="amount total-deduction"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'deduccion_imss')) + array_sum(array_column($empleados_filtrados, 'deduccion_isr')) + array_sum(array_column($empleados_filtrados, 'prestamo_deduccion')) + array_sum(array_column($empleados_filtrados, 'descuentos'))) ?></strong></td>
                        <td class="amount net"><strong>$<?= number_format(array_sum(array_column($empleados_filtrados, 'neto_pagar'))) ?></strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="quick-actions">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
            <i class="fas fa-bolt"></i> Acciones Rápidas
        </h3>
        <div class="actions-grid">
            <button class="action-card" onclick="bulkSalaryIncrease()">
                <i class="fas fa-arrow-up"></i>
                <h4>Aumento Masivo</h4>
                <p>Aplicar aumento salarial por porcentaje o cantidad fija</p>
            </button>
            
            <button class="action-card" onclick="bulkBonusAssignment()">
                <i class="fas fa-gift"></i>
                <h4>Asignar Bonos</h4>
                <p>Asignar bonos especiales o incentivos</p>
            </button>
            
            <button class="action-card" onclick="bulkDeductionUpdate()">
                <i class="fas fa-minus-circle"></i>
                <h4>Actualizar Deducciones</h4>
                <p>Modificar deducciones de IMSS, ISR, préstamos</p>
            </button>
            
            <button class="action-card" onclick="generatePayrollReports()">
                <i class="fas fa-chart-bar"></i>
                <h4>Reportes de Nómina</h4>
                <p>Generar reportes detallados por periodo</p>
            </button>
            
            <button class="action-card" onclick="bankFileGeneration()">
                <i class="fas fa-university"></i>
                <h4>Archivo Bancario</h4>
                <p>Generar archivo para transferencias bancarias</p>
            </button>
            
            <button class="action-card" onclick="payrollCalendar()">
                <i class="fas fa-calendar-alt"></i>
                <h4>Calendario de Pagos</h4>
                <p>Ver y configurar fechas de pago</p>
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .nomina-salarios {
        animation: fadeIn 0.5s ease;
    }

    .nomina-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary-color);
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .header-actions select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        color: var(--dark);
        cursor: pointer;
    }

    .nomina-summary {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .summary-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        transition: var(--transition);
        border-left: 4px solid;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .summary-card.total {
        border-left-color: var(--info-color);
    }

    .summary-card.bruto {
        border-left-color: var(--primary-color);
    }

    .summary-card.deducciones {
        border-left-color: var(--danger-color);
    }

    .summary-card.neto {
        border-left-color: var(--success-color);
    }

    .summary-card.prestaciones {
        border-left-color: var(--warning-color);
    }

    .summary-card.promedio {
        border-left-color: var(--purple);
    }

    .card-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .summary-card.total .card-icon {
        color: var(--info-color);
    }

    .summary-card.bruto .card-icon {
        color: var(--primary-color);
    }

    .summary-card.deducciones .card-icon {
        color: var(--danger-color);
    }

    .summary-card.neto .card-icon {
        color: var(--success-color);
    }

    .summary-card.prestaciones .card-icon {
        color: var(--warning-color);
    }

    .summary-card.promedio .card-icon {
        color: var(--purple);
    }

    .card-content {
        flex: 1;
    }

    .card-number {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .card-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.25rem;
    }

    .card-detail {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .nomina-filters {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)) auto auto;
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

    .nomina-table-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--primary-light);
        border-bottom: 1px solid var(--gray-200);
    }

    .table-header h3 {
        margin: 0;
    }

    .table-actions {
        display: flex;
        gap: 1rem;
    }

    .table-responsive {
        overflow-x: auto;
        max-height: 600px;
        overflow-y: auto;
    }

    .nomina-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    .nomina-table th,
    .nomina-table td {
        padding: 0.75rem 0.5rem;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .nomina-table th {
        background: var(--gray-50);
        font-weight: 600;
        color: var(--dark);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .nomina-table tbody tr:hover {
        background: var(--primary-light);
    }

    .nomina-table .employee-info strong {
        display: block;
        color: var(--dark);
    }

    .nomina-table .employee-info small {
        color: var(--gray-600);
        font-size: 0.75rem;
    }

    .amount {
        text-align: right;
        font-weight: 600;
    }

    .amount.gross {
        color: var(--primary-color);
    }

    .amount.deduction {
        color: var(--danger-color);
    }

    .amount.total-deduction {
        color: var(--danger-color);
        font-weight: bold;
    }

    .amount.net {
        color: var(--success-color);
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pendiente {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .status-procesando {
        background: var(--info-light);
        color: var(--info-color);
    }

    .status-pagado {
        background: var(--success-light);
        color: var(--success-color);
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
    }

    .totals-row {
        background: var(--primary-light);
        font-weight: bold;
    }

    .totals-row td {
        border-top: 2px solid var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
    }

    .quick-actions {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .action-card {
        background: var(--gray-50);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid transparent;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .action-card:hover {
        background: var(--primary-light);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .action-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
    }

    .action-card h4 {
        margin: 0;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .action-card p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
        text-align: center;
    }

    @media (max-width: 768px) {
        .nomina-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .header-actions select {
            width: 100%;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
        }

        .table-actions {
            width: 100%;
            justify-content: center;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para cambiar tipo de periodo
    function changePeriodType() {
        const tipo = document.getElementById('periodo-tipo').value;
        const params = new URLSearchParams(window.location.search);
        params.set('tipo', tipo);
        window.location.href = `?section=nomina_salarios&${params.toString()}`;
    }

    // Función para aplicar filtros de nómina
    function applyPayrollFilters() {
        const area = document.getElementById('filter-area').value;
        const plantel = document.getElementById('filter-plantel').value;
        const status = document.getElementById('filter-status').value;
        
        const params = new URLSearchParams();
        if (area) params.append('area', area);
        if (plantel) params.append('plantel', plantel);
        if (status) params.append('status_pago', status);
        
        const url = `?section=nomina_salarios&${params.toString()}`;
        window.location.href = url;
    }

    // Función para seleccionar todos los empleados
    function toggleSelectAll() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.employee-select');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }

    function selectAll() {
        const checkboxes = document.querySelectorAll('.employee-select');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        document.getElementById('select-all').checked = true;
    }

    // Funciones de acciones de nómina
    function processPayroll() {
        if(confirm('¿Procesar toda la nómina?\n\nEsto calculará automáticamente:\n• Salarios base\n• Horas extra\n• Bonos y prestaciones\n• Deducciones (IMSS, ISR)\n• Descuentos de préstamos\n\n¿Continuar?')) {
            alert('Procesando nómina...\n\nCalculando salarios, deducciones y netos para todos los empleados.\n\nEsto puede tomar unos minutos.');
        }
    }

    function calculateAll() {
        alert('Calcular Toda la Nómina\n\nRecalculando automáticamente:\n• Salarios proporcionales por días trabajados\n• Horas extra con tarifas especiales\n• Bonos de productividad\n• Deducciones actualizadas\n• Préstamos pendientes');
    }

    function processSelected() {
        const selected = document.querySelectorAll('.employee-select:checked');
        if (selected.length === 0) {
            alert('Por favor seleccione al menos un empleado.');
            return;
        }
        
        if(confirm(`¿Procesar pago para ${selected.length} empleado(s) seleccionado(s)?\n\nSe generarán las transferencias bancarias y recibos correspondientes.`)) {
            alert('Procesando pagos seleccionados...\n\nGenerando transferencias bancarias y actualizando estados de pago.');
        }
    }

    function editPayroll(employeeId) {
        alert(`Editar Nómina - Empleado ${employeeId}\n\nSe abrirá el editor de nómina con:\n• Salario base editable\n• Horas extra\n• Bonos especiales\n• Deducciones adicionales\n• Préstamos activos`);
    }

    function viewPayrollDetail(employeeId) {
        alert(`Detalle de Nómina - Empleado ${employeeId}\n\nMostrando:\n• Desglose completo de cálculos\n• Histórico de pagos\n• Deducciones detalladas\n• Comparativo con periodos anteriores`);
    }

    function generatePayStub(employeeId) {
        alert(`Generar Recibo - Empleado ${employeeId}\n\nGenerando recibo de nómina en PDF con:\n• Desglose completo\n• Datos fiscales\n• Firma digital\n• Código QR de verificación`);
    }

    function processPayment(employeeId) {
        alert(`Procesar Pago - Empleado ${employeeId}\n\nIniciando proceso de pago:\n• Validación de datos bancarios\n• Generación de transferencia\n• Actualización de estado\n• Envío de notificación`);
    }

    function exportPayroll() {
        alert('Exportar Nómina\n\nGenerando archivo Excel con:\n• Datos completos de nómina\n• Resumen por áreas\n• Totales y subtotales\n• Información bancaria\n• Deducciones detalladas');
    }

    function generateReports() {
        alert('Generar Recibos Masivos\n\nGenerando recibos de nómina para todos los empleados:\n• Recibos individuales en PDF\n• Archivo ZIP con todos los recibos\n• Lista de control\n• Resumen ejecutivo');
    }

    // Acciones rápidas
    function bulkSalaryIncrease() {
        alert('Aumento Salarial Masivo\n\nOpciones disponibles:\n• Aumento por porcentaje\n• Aumento por cantidad fija\n• Aumento por categoría\n• Aumento por evaluación\n• Aumento por antiguedad');
    }

    function bulkBonusAssignment() {
        alert('Asignación Masiva de Bonos\n\nTipos de bonos:\n• Bono de productividad\n• Bono de puntualidad\n• Bono por objetivos\n• Aguinaldo proporcional\n• Bonos especiales');
    }

    function bulkDeductionUpdate() {
        alert('Actualización Masiva de Deducciones\n\nActualizar:\n• Porcentajes de IMSS\n• Tablas de ISR\n• Descuentos de préstamos\n• Pensión alimenticia\n• Otros descuentos');
    }

    function generatePayrollReports() {
        alert('Reportes de Nómina\n\nReportes disponibles:\n• Resumen ejecutivo\n• Análisis por departamento\n• Comparativo periodos\n• Proyecciones\n• Reportes fiscales');
    }

    function bankFileGeneration() {
        alert('Archivo Bancario\n\nGenerando archivo para:\n• Transferencias SPEI\n• Depósitos a cuentas\n• Formato banco específico\n• Validación de CLABE\n• Conciliación bancaria');
    }

    function payrollCalendar() {
        alert('Calendario de Pagos\n\nConfiguración:\n• Fechas de corte\n• Fechas de pago\n• Periodos quincenal/mensual\n• Días festivos\n• Anticipos programados');
    }

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada para las tarjetas de resumen
        const cards = document.querySelectorAll('.summary-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Actualizar contador de seleccionados
        const checkboxes = document.querySelectorAll('.employee-select');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
    });

    function updateSelectedCount() {
        const selected = document.querySelectorAll('.employee-select:checked').length;
        const total = document.querySelectorAll('.employee-select').length;
        
        if (selected > 0) {
            console.log(`${selected} de ${total} empleados seleccionados`);
        }
    }
</script>
