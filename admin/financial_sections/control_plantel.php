<?php
$plantelNames = [
    'zapote' => 'El Zapote',
    'rio_nilo' => 'Río Nilo',
    'colinas' => 'Colinas'
];

$currentPlantel = $plantel ?? 'zapote';
$plantelName = $plantelNames[$currentPlantel] ?? 'El Zapote';
?>

<!-- ===================== HEADER DEL PLANTEL ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-building"></i>
        Control Financiero - Plantel <?= $plantelName ?>
    </h1>
    <p class="content-description">
        Gestión completa de pagos y gastos del plantel seleccionado
    </p>
</div>

<!-- ===================== NAVEGACIÓN DE SECCIONES ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <div class="form-grid">
        <button class="btn btn-primary" onclick="showSection('pagos')" id="btn-pagos">
            <i class="fas fa-coins"></i>
            Control de Pagos
        </button>
        <button class="btn btn-secondary" onclick="showSection('gastos')" id="btn-gastos">
            <i class="fas fa-receipt"></i>
            Control de Gastos
        </button>
        <button class="btn btn-success" onclick="showSection('resumen')" id="btn-resumen">
            <i class="fas fa-chart-pie"></i>
            Resumen General
        </button>
        <button class="btn btn-warning" onclick="showSection('interface-encargada')" id="btn-interface">
            <i class="fas fa-user-cog"></i>
            Interfaz Encargada
        </button>
    </div>
</div>

<!-- ===================== SECCIÓN DE PAGOS ===================== -->
<div id="seccion-pagos" class="content-section">
    <!-- Estadísticas de Pagos -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">$42,500.00</div>
            <div class="stat-label-card">
                <i class="fas fa-calendar-day"></i>
                Dinero del Día
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$285,750.00</div>
            <div class="stat-label-card">
                <i class="fas fa-piggy-bank"></i>
                Dinero Acumulado
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$15,200.00</div>
            <div class="stat-label-card">
                <i class="fas fa-hand-holding-usd"></i>
                Por Entregar
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$127,550.00</div>
            <div class="stat-label-card">
                <i class="fas fa-check-circle"></i>
                Recolectado
            </div>
        </div>
    </div>

    <!-- Formulario de Registro de Pago -->
    <div class="content-body" style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-plus-circle"></i>
            Registrar Nuevo Pago
        </h3>
        
        <form id="form-pago" class="form-grid">
            <div class="form-group">
                <label class="form-label">Nombre del Alumno</label>
                <input type="text" class="form-input" name="alumno_nombre" required 
                       placeholder="Nombre completo del alumno">
            </div>
            
            <div class="form-group">
                <label class="form-label">Concepto de Pago</label>
                <select class="form-input" name="concepto_pago" required>
                    <option value="">Seleccionar concepto</option>
                    <option value="mensualidad">Mensualidad</option>
                    <option value="inscripcion">Inscripción</option>
                    <option value="material">Material Didáctico</option>
                    <option value="uniforme">Uniforme</option>
                    <option value="excursion">Excursión</option>
                    <option value="evento">Evento Especial</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Cantidad de Pago</label>
                <input type="number" class="form-input" name="cantidad_pago" required 
                       step="0.01" min="0" placeholder="0.00">
            </div>
            
            <div class="form-group">
                <label class="form-label">Quien Realizó el Pago</label>
                <input type="text" class="form-input" name="quien_pago" required 
                       placeholder="Nombre de quien realizó el pago">
            </div>
            
            <div class="form-group">
                <label class="form-label">Quien Recibió el Pago</label>
                <input type="text" class="form-input" name="quien_recibio" required 
                       placeholder="Nombre del encargado que recibió">
            </div>
            
            <div class="form-group">
                <label class="form-label">Fecha del Pago</label>
                <input type="date" class="form-input" name="fecha_pago" required 
                       value="<?= date('Y-m-d') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Método de Pago</label>
                <select class="form-input" name="metodo_pago" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Observaciones</label>
                <input type="text" class="form-input" name="observaciones" 
                       placeholder="Observaciones adicionales (opcional)">
            </div>
        </form>
        
        <div style="margin-top: 1.5rem;">
            <button class="btn btn-primary" onclick="registrarPago()">
                <i class="fas fa-save"></i>
                Registrar Pago
            </button>
            <button class="btn btn-secondary" onclick="limpiarFormulario('form-pago')">
                <i class="fas fa-broom"></i>
                Limpiar
            </button>
        </div>
    </div>

    <!-- Tabla de Pagos Recientes -->
    <div class="content-body">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-list"></i>
            Pagos Registrados Hoy
        </h3>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Alumno</th>
                        <th>Concepto</th>
                        <th>Cantidad</th>
                        <th>Pagó</th>
                        <th>Recibió</th>
                        <th>Método</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-pagos">
                    <tr>
                        <td>14:30</td>
                        <td>María Fernández López</td>
                        <td>Mensualidad</td>
                        <td>$1,500.00</td>
                        <td>Ana Fernández</td>
                        <td>Carmen López</td>
                        <td><span class="badge badge-paid">Efectivo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Ver
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>13:45</td>
                        <td>Carlos Martín Ruiz</td>
                        <td>Material</td>
                        <td>$350.00</td>
                        <td>Pedro Martín</td>
                        <td>Carmen López</td>
                        <td><span class="badge badge-approved">Transfer</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Ver
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>12:15</td>
                        <td>Sofia García Méndez</td>
                        <td>Excursión</td>
                        <td>$800.00</td>
                        <td>Laura García</td>
                        <td>Carmen López</td>
                        <td><span class="badge badge-paid">Efectivo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Ver
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===================== SECCIÓN DE GASTOS ===================== -->
<div id="seccion-gastos" class="content-section" style="display: none;">
    <!-- Estadísticas de Gastos -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">$2,350.00</div>
            <div class="stat-label-card">
                <i class="fas fa-calendar-day"></i>
                Gastos del Día
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$14,750.00</div>
            <div class="stat-label-card">
                <i class="fas fa-calendar-week"></i>
                Gastos de la Semana
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">$58,200.00</div>
            <div class="stat-label-card">
                <i class="fas fa-calendar-alt"></i>
                Gastos del Mes
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number badge badge-pending">5</div>
            <div class="stat-label-card">
                <i class="fas fa-clock"></i>
                Gastos Pendientes
            </div>
        </div>
    </div>

    <!-- Formulario de Registro de Gasto -->
    <div class="content-body" style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-plus-circle"></i>
            Registrar Nuevo Gasto
        </h3>
        
        <form id="form-gasto" class="form-grid">
            <div class="form-group">
                <label class="form-label">Concepto del Gasto</label>
                <select class="form-input" name="concepto_gasto" required>
                    <option value="">Seleccionar concepto</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="limpieza">Materiales de Limpieza</option>
                    <option value="papeleria">Papelería</option>
                    <option value="servicios">Servicios (Luz, Agua, Gas)</option>
                    <option value="seguridad">Seguridad</option>
                    <option value="transporte">Transporte</option>
                    <option value="alimentacion">Alimentación</option>
                    <option value="emergencia">Gasto de Emergencia</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Descripción Detallada</label>
                <input type="text" class="form-input" name="descripcion_gasto" required 
                       placeholder="Descripción específica del gasto">
            </div>
            
            <div class="form-group">
                <label class="form-label">Cantidad del Gasto</label>
                <input type="number" class="form-input" name="cantidad_gasto" required 
                       step="0.01" min="0" placeholder="0.00">
            </div>
            
            <div class="form-group">
                <label class="form-label">Quien Generó el Gasto</label>
                <input type="text" class="form-input" name="quien_genero" required 
                       placeholder="Nombre de quien realizó/solicitó el gasto">
            </div>
            
            <div class="form-group">
                <label class="form-label">Proveedor/Establecimiento</label>
                <input type="text" class="form-input" name="proveedor" required 
                       placeholder="Nombre del proveedor o establecimiento">
            </div>
            
            <div class="form-group">
                <label class="form-label">Fecha del Gasto</label>
                <input type="date" class="form-input" name="fecha_gasto" required 
                       value="<?= date('Y-m-d') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Método de Pago</label>
                <select class="form-input" name="metodo_pago_gasto" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="cheque">Cheque</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Factura/Comprobante</label>
                <select class="form-input" name="tiene_factura" required>
                    <option value="si">Sí, con factura</option>
                    <option value="ticket">Solo ticket/recibo</option>
                    <option value="no">Sin comprobante</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Prioridad</label>
                <select class="form-input" name="prioridad" required>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                    <option value="urgente">Urgente</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Observaciones</label>
                <input type="text" class="form-input" name="observaciones_gasto" 
                       placeholder="Observaciones adicionales (opcional)">
            </div>
        </form>
        
        <div style="margin-top: 1.5rem;">
            <button class="btn btn-primary" onclick="registrarGasto()">
                <i class="fas fa-save"></i>
                Registrar Gasto
            </button>
            <button class="btn btn-secondary" onclick="limpiarFormulario('form-gasto')">
                <i class="fas fa-broom"></i>
                Limpiar
            </button>
        </div>
    </div>

    <!-- Tabla de Gastos Recientes -->
    <div class="content-body">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-list"></i>
            Gastos Registrados Hoy
        </h3>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Concepto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Generado por</th>
                        <th>Proveedor</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15:20</td>
                        <td>Limpieza</td>
                        <td>Detergente y cloro</td>
                        <td>$450.00</td>
                        <td>Carmen López</td>
                        <td>Walmart</td>
                        <td><span class="badge badge-approved">Aprobado</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Ver
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>11:30</td>
                        <td>Mantenimiento</td>
                        <td>Reparación de puerta</td>
                        <td>$1,200.00</td>
                        <td>Carmen López</td>
                        <td>Ferretería El Clavo</td>
                        <td><span class="badge badge-pending">Pendiente</span></td>
                        <td>
                            <button class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Revisar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>09:45</td>
                        <td>Papelería</td>
                        <td>Hojas y material didáctico</td>
                        <td>$700.00</td>
                        <td>Carmen López</td>
                        <td>Papelería San José</td>
                        <td><span class="badge badge-approved">Aprobado</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Ver
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===================== SECCIÓN RESUMEN ===================== -->
<div id="seccion-resumen" class="content-section" style="display: none;">
    <div class="content-body">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-chart-pie"></i>
            Resumen Financiero del Plantel
        </h3>
        
        <div class="form-grid">
            <div class="stat-card">
                <div class="stat-number">$42,500.00</div>
                <div class="stat-label-card">Ingresos Hoy</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$2,350.00</div>
                <div class="stat-label-card">Gastos Hoy</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$40,150.00</div>
                <div class="stat-label-card">Balance Neto</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">94.5%</div>
                <div class="stat-label-card">Eficiencia</div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== INTERFAZ PARA ENCARGADA ===================== -->
<div id="seccion-interface-encargada" class="content-section" style="display: none;">
    <div class="content-body">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-user-cog"></i>
            Interfaz Simplificada para Encargada de Plantel
        </h3>
        
        <p style="color: var(--gray-600); margin-bottom: 2rem;">
            Esta es una vista simplificada que pueden usar las encargadas de plantel para registro rápido de pagos y gastos.
        </p>
        
        <!-- Interfaz Simplificada -->
        <div style="background: var(--primary-light); padding: 2rem; border-radius: var(--border-radius);">
            <div class="form-grid">
                <div class="stat-card">
                    <h4 style="color: var(--primary-color);">Registro Rápido de Pago</h4>
                    <input type="text" class="form-input" placeholder="Nombre del alumno" style="margin: 0.5rem 0;">
                    <input type="number" class="form-input" placeholder="Cantidad" style="margin: 0.5rem 0;">
                    <select class="form-input" style="margin: 0.5rem 0;">
                        <option>Mensualidad</option>
                        <option>Material</option>
                        <option>Otro</option>
                    </select>
                    <button class="btn btn-primary" style="width: 100%;">Registrar Pago</button>
                </div>
                
                <div class="stat-card">
                    <h4 style="color: var(--primary-color);">Registro Rápido de Gasto</h4>
                    <input type="text" class="form-input" placeholder="Descripción del gasto" style="margin: 0.5rem 0;">
                    <input type="number" class="form-input" placeholder="Cantidad" style="margin: 0.5rem 0;">
                    <select class="form-input" style="margin: 0.5rem 0;">
                        <option>Limpieza</option>
                        <option>Mantenimiento</option>
                        <option>Papelería</option>
                        <option>Otro</option>
                    </select>
                    <button class="btn btn-primary" style="width: 100%;">Registrar Gasto</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ===================== -->
<script>
    // Función para mostrar secciones
    function showSection(section) {
        // Ocultar todas las secciones
        document.querySelectorAll('.content-section').forEach(el => {
            el.style.display = 'none';
        });
        
        // Resetear botones
        document.querySelectorAll('[id^="btn-"]').forEach(btn => {
            btn.className = btn.className.replace('btn-primary', 'btn-secondary');
        });
        
        // Mostrar sección seleccionada
        document.getElementById('seccion-' + section).style.display = 'block';
        document.getElementById('btn-' + section).className = 
            document.getElementById('btn-' + section).className.replace('btn-secondary', 'btn-primary');
    }

    // Función para registrar pago
    function registrarPago() {
        if(validateForm('form-pago')) {
            const formData = new FormData(document.getElementById('form-pago'));
            
            // Aquí iría la lógica para enviar al servidor
            alert('Pago registrado correctamente');
            
            // Agregar a la tabla (simulado)
            const tabla = document.getElementById('tabla-pagos');
            const nuevaFila = document.createElement('tr');
            nuevaFila.innerHTML = `
                <td>${new Date().toLocaleTimeString()}</td>
                <td>${formData.get('alumno_nombre')}</td>
                <td>${formData.get('concepto_pago')}</td>
                <td>$${parseFloat(formData.get('cantidad_pago')).toFixed(2)}</td>
                <td>${formData.get('quien_pago')}</td>
                <td>${formData.get('quien_recibio')}</td>
                <td><span class="badge badge-paid">${formData.get('metodo_pago')}</span></td>
                <td><button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Ver</button></td>
            `;
            tabla.insertBefore(nuevaFila, tabla.firstChild);
            
            limpiarFormulario('form-pago');
        }
    }

    // Función para registrar gasto
    function registrarGasto() {
        if(validateForm('form-gasto')) {
            alert('Gasto registrado correctamente');
            limpiarFormulario('form-gasto');
        }
    }

    // Función para limpiar formulario
    function limpiarFormulario(formId) {
        document.getElementById(formId).reset();
        if(formId === 'form-pago') {
            document.querySelector('[name="fecha_pago"]').value = new Date().toISOString().split('T')[0];
        } else if(formId === 'form-gasto') {
            document.querySelector('[name="fecha_gasto"]').value = new Date().toISOString().split('T')[0];
        }
    }

    // Mostrar sección de pagos por defecto
    document.addEventListener('DOMContentLoaded', function() {
        showSection('pagos');
    });
</script>
