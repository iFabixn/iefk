<!-- ===================== VISTA POR PLANTELES ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-building"></i>
        Gestión de Alumnado por Planteles
    </h1>
    <p class="content-description">
        Visualización organizada del alumnado por plantel educativo. Acceda a la información detallada de cada aula y estudiante.
    </p>
</div>

<!-- ===================== ESTADÍSTICAS GENERALES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-chart-pie"></i>
        Resumen General del Alumnado
    </h3>
    
    <div class="info-grid">
        <div class="info-section">
            <h4><i class="fas fa-users"></i> Total de Estudiantes</h4>
            <div class="stat-value" style="font-size: 2.5rem; text-align: center; margin: 1rem 0;">487</div>
            <div class="info-item">
                <span class="info-label">Activos</span>
                <span class="info-value badge badge-active">465</span>
            </div>
            <div class="info-item">
                <span class="info-label">Inactivos</span>
                <span class="info-value badge badge-inactive">22</span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-school"></i> Distribución por Nivel</h4>
            <div class="info-item">
                <span class="info-label">Guardería</span>
                <span class="info-value">128 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Preescolar</span>
                <span class="info-value">195 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Primaria</span>
                <span class="info-value">142 alumnos</span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-calendar"></i> Inscripciones Este Año</h4>
            <div class="info-item">
                <span class="info-label">Nuevos Ingresos</span>
                <span class="info-value badge badge-info">89</span>
            </div>
            <div class="info-item">
                <span class="info-label">Reinscripciones</span>
                <span class="info-value">376</span>
            </div>
            <div class="info-item">
                <span class="info-label">Bajas</span>
                <span class="info-value">22</span>
            </div>
        </div>
    </div>
</div>

<!-- ===================== PLANTELES ===================== -->
<div class="planteles-grid">
    <!-- Plantel El Zapote -->
    <div class="plantel-card" onclick="navigateTo('aulas', {plantel: 'zapote'})">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel El Zapote</h3>
                <p><i class="fas fa-map-marker-alt"></i> Av. Central 123, El Zapote</p>
                <p><i class="fas fa-user-tie"></i> Directora: María González</p>
                <p><i class="fas fa-phone"></i> (55) 1234-5678</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">180</div>
                <div class="stat-label">Total Alumnos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">12</div>
                <div class="stat-label">Aulas Activas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">175</div>
                <div class="stat-label">Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div>
                <div class="stat-label">Inactivos</div>
            </div>
        </div>
        
        <div style="margin-top: 1rem;">
            <div class="info-item">
                <span class="info-label">Guardería</span>
                <span class="info-value">45 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Preescolar</span>
                <span class="info-value">72 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Primaria</span>
                <span class="info-value">63 alumnos</span>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <span class="badge badge-active">Operativo</span>
            <span class="badge badge-info">Capacidad: 88%</span>
        </div>
    </div>

    <!-- Plantel Río Nilo -->
    <div class="plantel-card" onclick="navigateTo('aulas', {plantel: 'rio_nilo'})">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel Río Nilo</h3>
                <p><i class="fas fa-map-marker-alt"></i> Calle Río Nilo 456</p>
                <p><i class="fas fa-user-tie"></i> Directora: Carmen López</p>
                <p><i class="fas fa-phone"></i> (55) 2345-6789</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">165</div>
                <div class="stat-label">Total Alumnos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">11</div>
                <div class="stat-label">Aulas Activas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">157</div>
                <div class="stat-label">Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">8</div>
                <div class="stat-label">Inactivos</div>
            </div>
        </div>
        
        <div style="margin-top: 1rem;">
            <div class="info-item">
                <span class="info-label">Guardería</span>
                <span class="info-value">38 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Preescolar</span>
                <span class="info-value">67 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Primaria</span>
                <span class="info-value">60 alumnos</span>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <span class="badge badge-active">Operativo</span>
            <span class="badge badge-info">Capacidad: 82%</span>
        </div>
    </div>

    <!-- Plantel Colinas -->
    <div class="plantel-card" onclick="navigateTo('aulas', {plantel: 'colinas'})">
        <div class="plantel-header">
            <div class="plantel-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="plantel-info">
                <h3>Plantel Colinas</h3>
                <p><i class="fas fa-map-marker-alt"></i> Fracc. Colinas 789</p>
                <p><i class="fas fa-user-tie"></i> Directora: Ana Rodríguez</p>
                <p><i class="fas fa-phone"></i> (55) 3456-7890</p>
            </div>
        </div>
        
        <div class="plantel-stats">
            <div class="stat-item">
                <div class="stat-value">142</div>
                <div class="stat-label">Total Alumnos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">10</div>
                <div class="stat-label">Aulas Activas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">133</div>
                <div class="stat-label">Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">9</div>
                <div class="stat-label">Inactivos</div>
            </div>
        </div>
        
        <div style="margin-top: 1rem;">
            <div class="info-item">
                <span class="info-label">Guardería</span>
                <span class="info-value">45 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Preescolar</span>
                <span class="info-value">56 alumnos</span>
            </div>
            <div class="info-item">
                <span class="info-label">Primaria</span>
                <span class="info-value">41 alumnos</span>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <span class="badge badge-active">Operativo</span>
            <span class="badge badge-info">Capacidad: 79%</span>
        </div>
    </div>
</div>

<!-- ===================== ACCIONES RÁPIDAS ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-bolt"></i>
        Acciones Rápidas
    </h3>
    
    <div class="info-grid">
        <button class="btn btn-primary" onclick="navigateTo('busqueda')" style="width: 100%; justify-content: center;">
            <i class="fas fa-search"></i>
            Búsqueda Global de Estudiantes
        </button>
        
        <button class="btn btn-success" onclick="exportData('excel')" style="width: 100%; justify-content: center;">
            <i class="fas fa-file-excel"></i>
            Exportar Lista Completa
        </button>
        
        <button class="btn btn-warning" onclick="showPendingDocuments()" style="width: 100%; justify-content: center;">
            <i class="fas fa-exclamation-triangle"></i>
            Documentos Pendientes
        </button>
        
        <button class="btn btn-secondary" onclick="navigateTo('estadisticas')" style="width: 100%; justify-content: center;">
            <i class="fas fa-chart-bar"></i>
            Ver Estadísticas Detalladas
        </button>
    </div>
</div>

<!-- ===================== ALERTAS Y NOTIFICACIONES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-bell"></i>
        Alertas y Notificaciones Recientes
    </h3>
    
    <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <i class="fas fa-exclamation-circle" style="color: var(--warning-color); font-size: 1.2rem;"></i>
            <strong>Documentos Pendientes</strong>
        </div>
        <p style="color: var(--gray-600); margin-bottom: 1rem;">
            15 estudiantes tienen documentación incompleta que requiere atención.
        </p>
        <button class="btn btn-warning btn-sm" onclick="showPendingDocuments()">
            Ver Detalles
        </button>
    </div>
    
    <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <i class="fas fa-user-plus" style="color: var(--success-color); font-size: 1.2rem;"></i>
            <strong>Nuevos Ingresos</strong>
        </div>
        <p style="color: var(--gray-600); margin-bottom: 1rem;">
            8 estudiantes nuevos han sido registrados esta semana.
        </p>
        <button class="btn btn-success btn-sm" onclick="showNewStudents()">
            Ver Nuevos Ingresos
        </button>
    </div>
    
    <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <i class="fas fa-birthday-cake" style="color: var(--primary-color); font-size: 1.2rem;"></i>
            <strong>Cumpleaños del Mes</strong>
        </div>
        <p style="color: var(--gray-600); margin-bottom: 1rem;">
            23 estudiantes cumplen años en agosto. ¡No olvides felicitarlos!
        </p>
        <button class="btn btn-primary btn-sm" onclick="showBirthdays()">
            Ver Lista de Cumpleaños
        </button>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para mostrar documentos pendientes
    function showPendingDocuments() {
        alert('Documentos Pendientes:\n\n' +
              '• Plantel El Zapote: 6 estudiantes\n' +
              '• Plantel Río Nilo: 5 estudiantes\n' +
              '• Plantel Colinas: 4 estudiantes\n\n' +
              'Documentos más comunes faltantes:\n' +
              '- Certificado médico actualizado\n' +
              '- Comprobante de domicilio\n' +
              '- Fotografías recientes');
    }

    // Función para mostrar nuevos estudiantes
    function showNewStudents() {
        alert('Nuevos Ingresos Esta Semana:\n\n' +
              '• Plantel El Zapote: 3 estudiantes\n' +
              '• Plantel Río Nilo: 3 estudiantes\n' +
              '• Plantel Colinas: 2 estudiantes\n\n' +
              'Todos los estudiantes nuevos están en proceso\n' +
              'de completar su documentación.');
    }

    // Función para mostrar cumpleaños
    function showBirthdays() {
        alert('Cumpleaños en Agosto 2025:\n\n' +
              'Próximos cumpleaños:\n' +
              '• 15 Aug: Sofia García (5 años)\n' +
              '• 18 Aug: Carlos Martín (4 años)\n' +
              '• 22 Aug: Ana López (6 años)\n' +
              '• 25 Aug: Pedro Ruiz (3 años)\n\n' +
              'Ver lista completa en la sección de reportes.');
    }

    // Añadir efectos de hover a las tarjetas
    document.addEventListener('DOMContentLoaded', function() {
        const plantelCards = document.querySelectorAll('.plantel-card');
        plantelCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = 'var(--shadow-lg)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--shadow)';
            });
        });
    });
</script>
