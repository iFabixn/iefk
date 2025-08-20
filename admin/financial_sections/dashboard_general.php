<!-- ===================== DASHBOARD GENERAL ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-chart-pie"></i>
        Dashboard Financiero General
    </h1>
    <p class="content-description">
        Resumen consolidado del estado financiero de los 3 planteles del Instituto Educativo Frida Kahlo
    </p>
</div>

<!-- ===================== ESTADÍSTICAS GENERALES ===================== -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">$124,500.00</div>
        <div class="stat-label-card">
            <i class="fas fa-coins"></i>
            Total Recaudado Hoy
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number">$856,750.00</div>
        <div class="stat-label-card">
            <i class="fas fa-chart-line"></i>
            Acumulado del Mes
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number">$45,200.00</div>
        <div class="stat-label-card">
            <i class="fas fa-hand-holding-usd"></i>
            Por Entregar
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number">$23,800.00</div>
        <div class="stat-label-card">
            <i class="fas fa-credit-card"></i>
            Gastos del Mes
        </div>
    </div>
</div>

<!-- ===================== PLANTELES OVERVIEW ===================== -->
<div class="planteles-grid">
    <!-- Plantel El Zapote -->
    <div class="plantel-card">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel El Zapote</h3>
                <p>Encargada: María González</p>
                <p>180 alumnos activos</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">$42,500</div>
                <div class="stat-label">Recaudado Hoy</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$15,200</div>
                <div class="stat-label">Por Entregar</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$8,500</div>
                <div class="stat-label">Gastos Mes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value badge badge-approved">Al día</div>
                <div class="stat-label">Estado</div>
            </div>
        </div>
        
        <div class="plantel-actions">
            <a href="?section=pagos&plantel=zapote" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                Ver Detalle
            </a>
            <button class="btn btn-success" onclick="showQuickStats('zapote')">
                <i class="fas fa-chart-bar"></i>
                Resumen
            </button>
        </div>
    </div>

    <!-- Plantel Río Nilo -->
    <div class="plantel-card">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel Río Nilo</h3>
                <p>Encargada: Carmen López</p>
                <p>165 alumnos activos</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">$38,200</div>
                <div class="stat-label">Recaudado Hoy</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$18,500</div>
                <div class="stat-label">Por Entregar</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$7,200</div>
                <div class="stat-label">Gastos Mes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value badge badge-warning">Pendiente</div>
                <div class="stat-label">Estado</div>
            </div>
        </div>
        
        <div class="plantel-actions">
            <a href="?section=pagos&plantel=rio_nilo" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                Ver Detalle
            </a>
            <button class="btn btn-success" onclick="showQuickStats('rio_nilo')">
                <i class="fas fa-chart-bar"></i>
                Resumen
            </button>
        </div>
    </div>

    <!-- Plantel Colinas -->
    <div class="plantel-card">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel Colinas</h3>
                <p>Encargada: Ana Rodríguez</p>
                <p>142 alumnos activos</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">$43,800</div>
                <div class="stat-label">Recaudado Hoy</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$11,500</div>
                <div class="stat-label">Por Entregar</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">$8,100</div>
                <div class="stat-label">Gastos Mes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value badge badge-approved">Al día</div>
                <div class="stat-label">Estado</div>
            </div>
        </div>
        
        <div class="plantel-actions">
            <a href="?section=pagos&plantel=colinas" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                Ver Detalle
            </a>
            <button class="btn btn-success" onclick="showQuickStats('colinas')">
                <i class="fas fa-chart-bar"></i>
                Resumen
            </button>
        </div>
    </div>
</div>

<!-- ===================== ALERTAS Y NOTIFICACIONES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-bell"></i>
        Alertas y Notificaciones Financieras
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Plantel</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Prioridad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <i class="fas fa-exclamation-triangle" style="color: var(--warning-color);"></i>
                        Pago Pendiente
                    </td>
                    <td>Río Nilo</td>
                    <td>Entrega de efectivo pendiente - $18,500</td>
                    <td>13/08/2025</td>
                    <td><span class="badge badge-warning">Media</span></td>
                    <td>
                        <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Ver Detalle
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-chart-line" style="color: var(--success-color);"></i>
                        Meta Alcanzada
                    </td>
                    <td>El Zapote</td>
                    <td>Meta mensual superada en 15%</td>
                    <td>12/08/2025</td>
                    <td><span class="badge badge-approved">Baja</span></td>
                    <td>
                        <button class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Felicitar
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-receipt" style="color: var(--info-color);"></i>
                        Gasto Inusual
                    </td>
                    <td>Colinas</td>
                    <td>Gasto en mantenimiento superior al promedio</td>
                    <td>11/08/2025</td>
                    <td><span class="badge badge-pending">Media</span></td>
                    <td>
                        <button class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Revisar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ===================== ACCIONES RÁPIDAS ===================== -->
<div class="content-body" style="margin-top: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-bolt"></i>
        Acciones Rápidas
    </h3>
    
    <div class="form-grid">
        <button class="btn btn-primary" onclick="generateDailyReport()">
            <i class="fas fa-file-pdf"></i>
            Generar Reporte Diario
        </button>
        
        <button class="btn btn-success" onclick="exportToExcel()">
            <i class="fas fa-file-excel"></i>
            Exportar a Excel
        </button>
        
        <button class="btn btn-warning" onclick="showPendingCollections()">
            <i class="fas fa-clock"></i>
            Recolecciones Pendientes
        </button>
        
        <button class="btn btn-secondary" onclick="openCalculator()">
            <i class="fas fa-calculator"></i>
            Calculadora Financiera
        </button>
    </div>
</div>

<!-- ===================== SCRIPT ESPECÍFICO ===================== -->
<script>
    // Función para mostrar estadísticas rápidas
    function showQuickStats(plantel) {
        const plantelNames = {
            'zapote': 'El Zapote',
            'rio_nilo': 'Río Nilo',
            'colinas': 'Colinas'
        };
        
        alert(`Estadísticas rápidas para ${plantelNames[plantel]}:\n\n` +
              `• Última recolección: Ayer\n` +
              `• Pagos registrados hoy: 45\n` +
              `• Gastos pendientes: 3\n` +
              `• Estado general: Operativo`);
    }

    // Función para generar reporte diario
    function generateDailyReport() {
        if(confirm('¿Generar reporte financiero del día de hoy?')) {
            // Aquí iría la lógica para generar el PDF
            alert('Generando reporte diario...\nEl archivo se descargará automáticamente.');
        }
    }

    // Función para exportar a Excel
    function exportToExcel() {
        if(confirm('¿Exportar todos los datos financieros a Excel?')) {
            // Aquí iría la lógica para generar el Excel
            alert('Exportando datos a Excel...\nEl archivo se descargará automáticamente.');
        }
    }

    // Función para mostrar recolecciones pendientes
    function showPendingCollections() {
        alert('Recolecciones Pendientes:\n\n' +
              '• Río Nilo: $18,500 (desde ayer)\n' +
              '• El Zapote: $15,200 (desde hoy)\n' +
              '• Colinas: $11,500 (desde hoy)');
    }

    // Función para abrir calculadora
    function openCalculator() {
        const calculation = prompt('Calculadora Financiera\n\nIngrese la operación a realizar:');
        if(calculation) {
            try {
                const result = eval(calculation);
                alert(`Resultado: ${formatCurrency(result)}`);
            } catch(e) {
                alert('Error en el cálculo. Verifique la operación.');
            }
        }
    }

    // Actualizar datos en tiempo real (simulado)
    setInterval(function() {
        // Aquí se actualizarían los datos desde el servidor
        console.log('Actualizando datos financieros...');
    }, 30000); // Cada 30 segundos
</script>
