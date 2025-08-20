<!-- ===================== REPORTES CONSOLIDADOS ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-chart-bar"></i>
        Reportes Financieros Consolidados
    </h1>
    <p class="content-description">
        Análisis financiero completo de todos los planteles del Instituto Educativo Frida Kahlo
    </p>
</div>

<!-- ===================== FILTROS DE REPORTE ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-filter"></i>
        Filtros de Consulta
    </h3>
    
    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">Período</label>
            <select class="form-input" id="periodo-reporte">
                <option value="hoy">Hoy</option>
                <option value="semana">Esta Semana</option>
                <option value="mes" selected>Este Mes</option>
                <option value="trimestre">Este Trimestre</option>
                <option value="anio">Este Año</option>
                <option value="personalizado">Período Personalizado</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Plantel</label>
            <select class="form-input" id="plantel-reporte">
                <option value="todos" selected>Todos los Planteles</option>
                <option value="zapote">El Zapote</option>
                <option value="rio_nilo">Río Nilo</option>
                <option value="colinas">Colinas</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Tipo de Reporte</label>
            <select class="form-input" id="tipo-reporte">
                <option value="completo" selected>Reporte Completo</option>
                <option value="ingresos">Solo Ingresos</option>
                <option value="gastos">Solo Gastos</option>
                <option value="balance">Balance Neto</option>
            </select>
        </div>
        
        <div class="form-group">
            <button class="btn btn-primary" onclick="generarReporte()" style="margin-top: 1.75rem;">
                <i class="fas fa-search"></i>
                Generar Reporte
            </button>
        </div>
    </div>
    
    <!-- Fechas personalizadas (oculto por defecto) -->
    <div id="fechas-personalizadas" style="display: none; margin-top: 1rem;">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Fecha Inicial</label>
                <input type="date" class="form-input" id="fecha-inicio">
            </div>
            <div class="form-group">
                <label class="form-label">Fecha Final</label>
                <input type="date" class="form-input" id="fecha-fin">
            </div>
        </div>
    </div>
</div>

<!-- ===================== RESUMEN EJECUTIVO ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-chart-pie"></i>
        Resumen Ejecutivo - Agosto 2025
    </h3>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">$856,750.00</div>
            <div class="stat-label-card">
                <i class="fas fa-arrow-up" style="color: var(--success-color);"></i>
                Total Ingresos
                <br><small>+12% vs mes anterior</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$127,300.00</div>
            <div class="stat-label-card">
                <i class="fas fa-arrow-down" style="color: var(--danger-color);"></i>
                Total Gastos
                <br><small>+5% vs mes anterior</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$729,450.00</div>
            <div class="stat-label-card">
                <i class="fas fa-balance-scale" style="color: var(--primary-color);"></i>
                Balance Neto
                <br><small>+14% vs mes anterior</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">85.1%</div>
            <div class="stat-label-card">
                <i class="fas fa-percentage" style="color: var(--success-color);"></i>
                Margen Utilidad
                <br><small>+2% vs mes anterior</small>
            </div>
        </div>
    </div>
</div>

<!-- ===================== COMPARATIVO POR PLANTELES ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-building"></i>
        Comparativo por Planteles
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Plantel</th>
                    <th>Alumnos</th>
                    <th>Ingresos</th>
                    <th>Gastos</th>
                    <th>Balance</th>
                    <th>Eficiencia</th>
                    <th>Tendencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>El Zapote</strong><br>
                        <small>María González</small>
                    </td>
                    <td>180</td>
                    <td style="color: var(--success-color);">$295,200.00</td>
                    <td style="color: var(--danger-color);">$42,100.00</td>
                    <td style="color: var(--primary-color);">$253,100.00</td>
                    <td>
                        <span class="badge badge-approved">85.7%</span>
                    </td>
                    <td>
                        <i class="fas fa-arrow-up" style="color: var(--success-color);"></i>
                        +15%
                    </td>
                    <td>
                        <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Detalles
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Río Nilo</strong><br>
                        <small>Carmen López</small>
                    </td>
                    <td>165</td>
                    <td style="color: var(--success-color);">$275,800.00</td>
                    <td style="color: var(--danger-color);">$45,600.00</td>
                    <td style="color: var(--primary-color);">$230,200.00</td>
                    <td>
                        <span class="badge badge-warning">83.5%</span>
                    </td>
                    <td>
                        <i class="fas fa-arrow-up" style="color: var(--success-color);"></i>
                        +8%
                    </td>
                    <td>
                        <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Detalles
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Colinas</strong><br>
                        <small>Ana Rodríguez</small>
                    </td>
                    <td>142</td>
                    <td style="color: var(--success-color);">$285,750.00</td>
                    <td style="color: var(--danger-color);">$39,600.00</td>
                    <td style="color: var(--primary-color);">$246,150.00</td>
                    <td>
                        <span class="badge badge-approved">86.1%</span>
                    </td>
                    <td>
                        <i class="fas fa-arrow-up" style="color: var(--success-color);"></i>
                        +12%
                    </td>
                    <td>
                        <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            Detalles
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ===================== ANÁLISIS DE INGRESOS ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-coins"></i>
        Análisis Detallado de Ingresos
    </h3>
    
    <div class="form-grid">
        <div class="stat-card">
            <div class="stat-number">$645,200.00</div>
            <div class="stat-label-card">
                Mensualidades<br>
                <small>75.3% del total</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$98,750.00</div>
            <div class="stat-label-card">
                Inscripciones<br>
                <small>11.5% del total</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$67,200.00</div>
            <div class="stat-label-card">
                Material Didáctico<br>
                <small>7.8% del total</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$45,600.00</div>
            <div class="stat-label-card">
                Otros Conceptos<br>
                <small>5.4% del total</small>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ANÁLISIS DE GASTOS ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-receipt"></i>
        Análisis Detallado de Gastos
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>El Zapote</th>
                    <th>Río Nilo</th>
                    <th>Colinas</th>
                    <th>Total</th>
                    <th>% del Total</th>
                    <th>Tendencia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Mantenimiento</strong></td>
                    <td>$18,500</td>
                    <td>$21,200</td>
                    <td>$16,800</td>
                    <td style="color: var(--primary-color);">$56,500</td>
                    <td>44.4%</td>
                    <td>
                        <i class="fas fa-arrow-up" style="color: var(--warning-color);"></i>
                        +8%
                    </td>
                </tr>
                <tr>
                    <td><strong>Servicios</strong></td>
                    <td>$12,300</td>
                    <td>$13,800</td>
                    <td>$11,900</td>
                    <td style="color: var(--primary-color);">$38,000</td>
                    <td>29.8%</td>
                    <td>
                        <i class="fas fa-minus" style="color: var(--gray-500);"></i>
                        0%
                    </td>
                </tr>
                <tr>
                    <td><strong>Limpieza</strong></td>
                    <td>$6,800</td>
                    <td>$7,200</td>
                    <td>$6,400</td>
                    <td style="color: var(--primary-color);">$20,400</td>
                    <td>16.0%</td>
                    <td>
                        <i class="fas fa-arrow-down" style="color: var(--success-color);"></i>
                        -5%
                    </td>
                </tr>
                <tr>
                    <td><strong>Papelería</strong></td>
                    <td>$4,500</td>
                    <td>$3,400</td>
                    <td>$4,500</td>
                    <td style="color: var(--primary-color);">$12,400</td>
                    <td>9.8%</td>
                    <td>
                        <i class="fas fa-arrow-up" style="color: var(--warning-color);"></i>
                        +3%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ===================== PROYECCIONES Y METAS ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-chart-line"></i>
        Proyecciones y Cumplimiento de Metas
    </h3>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">112%</div>
            <div class="stat-label-card">
                <i class="fas fa-bullseye" style="color: var(--success-color);"></i>
                Meta de Ingresos
                <br><small>$856K de $765K objetivo</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">95%</div>
            <div class="stat-label-card">
                <i class="fas fa-chart-area" style="color: var(--warning-color);"></i>
                Control de Gastos
                <br><small>$127K de $134K límite</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$2.1M</div>
            <div class="stat-label-card">
                <i class="fas fa-forecast" style="color: var(--info-color);"></i>
                Proyección Anual
                <br><small>Basada en tendencia actual</small>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">Q4 2025</div>
            <div class="stat-label-card">
                <i class="fas fa-flag-checkered" style="color: var(--primary-color);"></i>
                Meta $2M
                <br><small>Estimado de cumplimiento</small>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ACCIONES DE EXPORTACIÓN ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-download"></i>
        Exportar Reportes
    </h3>
    
    <div class="form-grid">
        <button class="btn btn-primary" onclick="exportarPDF()">
            <i class="fas fa-file-pdf"></i>
            Exportar a PDF
        </button>
        
        <button class="btn btn-success" onclick="exportarExcel()">
            <i class="fas fa-file-excel"></i>
            Exportar a Excel
        </button>
        
        <button class="btn btn-warning" onclick="enviarReporte()">
            <i class="fas fa-envelope"></i>
            Enviar por Email
        </button>
        
        <button class="btn btn-secondary" onclick="programarReporte()">
            <i class="fas fa-clock"></i>
            Programar Envío
        </button>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Controlar filtros de período
    document.getElementById('periodo-reporte').addEventListener('change', function() {
        const fechasDiv = document.getElementById('fechas-personalizadas');
        if(this.value === 'personalizado') {
            fechasDiv.style.display = 'block';
        } else {
            fechasDiv.style.display = 'none';
        }
    });

    // Función para generar reporte
    function generarReporte() {
        const periodo = document.getElementById('periodo-reporte').value;
        const plantel = document.getElementById('plantel-reporte').value;
        const tipo = document.getElementById('tipo-reporte').value;
        
        // Simular carga de datos
        alert(`Generando reporte:\n\n` +
              `Período: ${periodo}\n` +
              `Plantel: ${plantel}\n` +
              `Tipo: ${tipo}\n\n` +
              `Los datos se actualizarán automáticamente.`);
        
        // Aquí iría la lógica para actualizar los datos del reporte
        console.log('Actualizando datos del reporte...');
    }

    // Función para exportar PDF
    function exportarPDF() {
        if(confirm('¿Generar reporte en formato PDF?')) {
            alert('Generando PDF...\nEl archivo se descargará automáticamente.');
            // Aquí iría la lógica para generar PDF
        }
    }

    // Función para exportar Excel
    function exportarExcel() {
        if(confirm('¿Exportar datos a Excel?')) {
            alert('Generando archivo Excel...\nEl archivo se descargará automáticamente.');
            // Aquí iría la lógica para generar Excel
        }
    }

    // Función para enviar reporte por email
    function enviarReporte() {
        const email = prompt('Ingrese el email de destino:');
        if(email) {
            alert(`Enviando reporte a: ${email}\n\nEl reporte será enviado en los próximos minutos.`);
            // Aquí iría la lógica para enviar email
        }
    }

    // Función para programar envío
    function programarReporte() {
        alert('Programación de Reportes:\n\n' +
              '• Diario: 8:00 AM\n' +
              '• Semanal: Lunes 8:00 AM\n' +
              '• Mensual: Primer día del mes 9:00 AM\n\n' +
              'Para modificar la programación, contacte al administrador.');
    }

    // Actualizar datos automáticamente
    setInterval(function() {
        console.log('Actualizando datos de reportes...');
        // Aquí se actualizarían los datos desde el servidor
    }, 60000); // Cada minuto
</script>
