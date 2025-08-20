<?php include('../fragment_protection.php'); ?>
<!-- ===================== REGISTRAR NUEVA ADMISIÓN ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-plus-circle"></i>
        Registrar Nueva Admisión
    </h1>
    <p class="content-description">
        Registra un nuevo tutor y menor(es) para iniciar el proceso de admisión. Se enviará una invitación por correo electrónico para completar la documentación.
    </p>
</div>

<div class="content-body">
    <form id="admissionForm" method="POST" action="process_admission.php">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-user-friends"></i>
            Información del Tutor
        </h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="tutor_nombre">
                    <i class="fas fa-user"></i> Nombre Completo del Tutor *
                </label>
                <input type="text" id="tutor_nombre" name="tutor_nombre" class="form-input" required 
                       placeholder="Ej: María Elena González Pérez"
                       pattern="[A-Za-zÀ-ÿ\u00f1\u00d1\s]+"
                       title="Solo se permiten letras y espacios"
                       oninput="validarSoloLetras(this)">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tutor_email">
                    <i class="fas fa-envelope"></i> Correo Electrónico *
                </label>
                <input type="email" id="tutor_email" name="tutor_email" class="form-input" required 
                       placeholder="ejemplo@correo.com"
                       onblur="validarCorreo(this)">
                <div id="email-validation" style="margin-top: 0.5rem; font-size: 0.875rem;"></div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tutor_telefono">
                    <i class="fas fa-phone"></i> Teléfono de Contacto * (10 dígitos)
                </label>
                <input type="tel" id="tutor_telefono" name="tutor_telefono" class="form-input" required 
                       placeholder="3312345678"
                       pattern="[0-9]{10}"
                       maxlength="10"
                       title="Debe contener exactamente 10 dígitos"
                       oninput="validarSoloNumeros(this)">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tutor_parentesco">
                    <i class="fas fa-heart"></i> Parentesco *
                </label>
                <select id="tutor_parentesco" name="tutor_parentesco" class="form-input" required>
                    <option value="">Seleccionar parentesco</option>
                    <option value="madre">Madre</option>
                    <option value="padre">Padre</option>
                    <option value="abuelo">Abuelo(a)</option>
                    <option value="tio">Tío(a)</option>
                    <option value="tutor_legal">Tutor Legal</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 2px solid var(--primary-light);">

        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-child"></i>
            Información del Menor
        </h3>

        <div id="menores-container">
            <div class="menor-form" data-menor="1">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="menor_nombre_1">
                            <i class="fas fa-baby"></i> Nombre Completo del Menor *
                        </label>
                        <input type="text" id="menor_nombre_1" name="menor_nombre[]" class="form-input" required 
                               placeholder="Ej: Sofía González Martínez"
                               pattern="[A-Za-zÀ-ÿ\u00f1\u00d1\s]+"
                               title="Solo se permiten letras y espacios"
                               oninput="validarSoloLetras(this)">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="menor_edad_1">
                            <i class="fas fa-birthday-cake"></i> Fecha de Nacimiento *
                        </label>
                        <input type="date" id="menor_edad_1" name="menor_edad[]" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="menor_servicio_1">
                            <i class="fas fa-school"></i> Servicio Solicitado *
                        </label>
                        <select id="menor_servicio_1" name="menor_servicio[]" class="form-input" required 
                                onchange="actualizarPlanteles(1)">
                            <option value="">Seleccionar servicio</option>
                            <option value="guarderia">Guardería</option>
                            <option value="preescolar">Preescolar</option>
                            <option value="primaria">Primaria</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="menor_plantel_1">
                            <i class="fas fa-map-marker-alt"></i> Plantel Preferido *
                        </label>
                        <select id="menor_plantel_1" name="menor_plantel[]" class="form-input" required disabled>
                            <option value="">Primero selecciona un servicio</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin: 1.5rem 0; padding: 1rem; background: var(--primary-light); border-radius: 8px; border-left: 4px solid var(--primary-color);">
            <p style="margin: 0; color: var(--primary-dark); display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-plus"></i>
                <strong>¿Tiene más hijos que desea inscribir?</strong>
            </p>
            <button type="button" onclick="agregarMenor()" class="btn btn-secondary" style="margin-top: 0.5rem;">
                <i class="fas fa-plus"></i>
                Agregar otro menor
            </button>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 2px solid var(--primary-light);">

        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-cog"></i>
            Configuración de la Invitación
        </h3>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="fecha_limite">
                    <i class="fas fa-calendar-alt"></i> Fecha Límite para Documentación *
                </label>
                <input type="date" id="fecha_limite" name="fecha_limite" class="form-input" required
                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                       value="<?= date('Y-m-d', strtotime('+15 days')) ?>">
            </div>
        </div>

        <div class="form-group" style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                <i class="fas fa-eraser"></i>
                Limpiar Formulario
            </button>
            <button type="submit" class="btn btn-primary" id="btn-enviar">
                <i class="fas fa-paper-plane"></i>
                Enviar Invitación
            </button>
        </div>
        
        <!-- 📊 Área de resultados -->
        <div id="resultado-envio" style="margin-top: 1.5rem; display: none;"></div>
    </form>
    <!-- Estadísticas rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">42</div>
            <div class="stat-label">Admisiones este mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">15</div>
            <div class="stat-label">Pendientes de documentación</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">8</div>
            <div class="stat-label">Invitaciones enviadas hoy</div>
        </div>
    </div>
</div>

<script>
let contadorMenores = 1;

// 🔤 Validación para solo letras
function validarSoloLetras(input) {
    // Remover números y símbolos, mantener solo letras, espacios, acentos y ñ
    input.value = input.value.replace(/[^A-Za-zÀ-ÿ\u00f1\u00d1\s]/g, '');
}

// 🔢 Validación para solo números
function validarSoloNumeros(input) {
    // Remover todo excepto números
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // Validar longitud
    if (input.value.length === 10) {
        input.style.borderColor = 'var(--success-color)';
    } else {
        input.style.borderColor = 'var(--danger-color)';
    }
}

// 📧 Validación básica de correo
function validarCorreo(input) {
    const email = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const validationDiv = document.getElementById('email-validation');
    
    if (email === '') {
        validationDiv.innerHTML = '';
        input.style.borderColor = 'var(--gray-300)';
        return;
    }
    
    if (emailRegex.test(email)) {
        // Validación adicional de dominios comunes
        const commonDomains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'live.com', 'icloud.com'];
        const domain = email.split('@')[1].toLowerCase();
        
        if (commonDomains.includes(domain) || domain.includes('.')) {
            validationDiv.innerHTML = '<span style="color: var(--success-color);"><i class="fas fa-check"></i> Formato válido</span>';
            input.style.borderColor = 'var(--success-color)';
        } else {
            validationDiv.innerHTML = '<span style="color: var(--warning-color);"><i class="fas fa-exclamation-triangle"></i> Dominio poco común, verifica que sea correcto</span>';
            input.style.borderColor = 'var(--warning-color)';
        }
    } else {
        validationDiv.innerHTML = '<span style="color: var(--danger-color);"><i class="fas fa-times"></i> Formato de correo inválido</span>';
        input.style.borderColor = 'var(--danger-color)';
    }
}

// 🏫 Actualizar planteles según servicio seleccionado
function actualizarPlanteles(numeroMenor) {
    const servicioSelect = document.getElementById(`menor_servicio_${numeroMenor}`);
    const plantelSelect = document.getElementById(`menor_plantel_${numeroMenor}`);
    const servicioSeleccionado = servicioSelect.value;
    
    // Limpiar opciones existentes
    plantelSelect.innerHTML = '';
    
    if (servicioSeleccionado === '') {
        plantelSelect.innerHTML = '<option value="">Primero selecciona un servicio</option>';
        plantelSelect.disabled = true;
        plantelSelect.style.backgroundColor = 'var(--gray-200)';
        return;
    }
    
    // Habilitar el select
    plantelSelect.disabled = false;
    plantelSelect.style.backgroundColor = 'var(--white)';
    
    // Agregar opción por defecto
    plantelSelect.innerHTML = '<option value="">Seleccionar plantel</option>';
    
    if (servicioSeleccionado === 'guarderia') {
        // Guardería está disponible en los 3 planteles
        plantelSelect.innerHTML += `
            <option value="zapote">Plantel El Zapote (Matriz)</option>
            <option value="rio_nilo">Plantel Río Nilo</option>
            <option value="colinas">Plantel Colinas de Tonalá</option>
        `;
    } else if (servicioSeleccionado === 'preescolar' || servicioSeleccionado === 'primaria') {
        // Preescolar y Primaria solo en Zapote
        plantelSelect.innerHTML += `
            <option value="zapote">Plantel El Zapote (Matriz)</option>
        `;
    }
}

function agregarMenor() {
    contadorMenores++;
    const container = document.getElementById('menores-container');
    
    const nuevoMenor = document.createElement('div');
    nuevoMenor.className = 'menor-form';
    nuevoMenor.setAttribute('data-menor', contadorMenores);
    nuevoMenor.style.marginTop = '2rem';
    nuevoMenor.style.padding = '1.5rem';
    nuevoMenor.style.border = '2px dashed var(--primary-color)';
    nuevoMenor.style.borderRadius = '8px';
    nuevoMenor.style.position = 'relative';
    
    nuevoMenor.innerHTML = `
        <button type="button" onclick="eliminarMenor(${contadorMenores})" 
                style="position: absolute; top: 10px; right: 10px; background: var(--danger-color); color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
        
        <h4 style="color: var(--primary-color); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-child"></i>
            Menor #${contadorMenores}
        </h4>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="menor_nombre_${contadorMenores}">
                    <i class="fas fa-baby"></i> Nombre Completo del Menor *
                </label>
                <input type="text" id="menor_nombre_${contadorMenores}" name="menor_nombre[]" class="form-input" required 
                       placeholder="Ej: Sofía González Martínez"
                       pattern="[A-Za-zÀ-ÿ\\u00f1\\u00d1\\s]+"
                       title="Solo se permiten letras y espacios"
                       oninput="validarSoloLetras(this)">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="menor_edad_${contadorMenores}">
                    <i class="fas fa-birthday-cake"></i> Fecha de Nacimiento *
                </label>
                <input type="date" id="menor_edad_${contadorMenores}" name="menor_edad[]" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="menor_servicio_${contadorMenores}">
                    <i class="fas fa-school"></i> Servicio Solicitado *
                </label>
                <select id="menor_servicio_${contadorMenores}" name="menor_servicio[]" class="form-input" required 
                        onchange="actualizarPlanteles(${contadorMenores})">
                    <option value="">Seleccionar servicio</option>
                    <option value="guarderia">Guardería</option>
                    <option value="preescolar">Preescolar</option>
                    <option value="primaria">Primaria</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="menor_plantel_${contadorMenores}">
                    <i class="fas fa-map-marker-alt"></i> Plantel Preferido *
                </label>
                <select id="menor_plantel_${contadorMenores}" name="menor_plantel[]" class="form-input" required disabled>
                    <option value="">Primero selecciona un servicio</option>
                </select>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoMenor);
    
    // Animación de entrada
    nuevoMenor.style.opacity = '0';
    nuevoMenor.style.transform = 'translateY(20px)';
    setTimeout(() => {
        nuevoMenor.style.transition = 'all 0.3s ease';
        nuevoMenor.style.opacity = '1';
        nuevoMenor.style.transform = 'translateY(0)';
    }, 100);
}

function eliminarMenor(numero) {
    if (confirm('¿Estás seguro de que deseas eliminar este menor?')) {
        const menor = document.querySelector(`[data-menor="${numero}"]`);
        menor.style.transition = 'all 0.3s ease';
        menor.style.opacity = '0';
        menor.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            menor.remove();
        }, 300);
    }
}

function limpiarFormulario() {
    if (confirm('¿Estás seguro de que deseas limpiar todos los datos del formulario?')) {
        document.getElementById('admissionForm').reset();
        
        // Remover menores adicionales
        const menoresAdicionales = document.querySelectorAll('.menor-form[data-menor]:not([data-menor="1"])');
        menoresAdicionales.forEach(menor => menor.remove());
        contadorMenores = 1;
        
        // Resetear el estado del primer menor
        const plantel1 = document.getElementById('menor_plantel_1');
        plantel1.innerHTML = '<option value="">Primero selecciona un servicio</option>';
        plantel1.disabled = true;
        plantel1.style.backgroundColor = 'var(--gray-200)';
        
        // Limpiar validación de email
        document.getElementById('email-validation').innerHTML = '';
        
        // Ocultar resultado de envío
        document.getElementById('resultado-envio').style.display = 'none';
        
        // Resetear colores de bordes
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.style.borderColor = 'var(--gray-300)';
        });
    }
}

// 🚀 Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Configurar fecha mínima para la fecha límite
    const fechaLimite = document.getElementById('fecha_limite');
    const hoy = new Date();
    const manana = new Date(hoy);
    manana.setDate(hoy.getDate() + 1);
    fechaLimite.min = manana.toISOString().split('T')[0];
    
    // 📝 Configurar envío del formulario
    const form = document.getElementById('admissionForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        enviarFormulario();
    });
});

// 📨 Función para enviar formulario con AJAX
async function enviarFormulario() {
    const btnEnviar = document.getElementById('btn-enviar');
    const resultadoDiv = document.getElementById('resultado-envio');
    const form = document.getElementById('admissionForm');
    
    // 🔄 Mostrar estado de carga
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    resultadoDiv.style.display = 'none';
    
    try {
        // ✅ Validar formulario antes de enviar
        if (!validarFormularioCompleto()) {
            throw new Error('Por favor, complete todos los campos requeridos correctamente');
        }
        
        // 📤 Crear FormData y enviar
        const formData = new FormData(form);
        
        const response = await fetch('process_admission_final.php', {
            method: 'POST',
            body: formData
        });
        
        const resultado = await response.json();
        
        if (resultado.success) {
            // ✅ Éxito
            resultadoDiv.innerHTML = `
                <div style="background: #d1edff; border: 1px solid #28a745; border-radius: 8px; padding: 20px; color: #155724;">
                    <h4 style="margin: 0 0 10px 0; color: #155724; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-check-circle"></i>
                        ¡Invitación Enviada Exitosamente!
                    </h4>
                    <p style="margin: 0 0 15px 0;">${resultado.message}</p>
                    <div style="background: rgba(255,255,255,0.7); border-radius: 6px; padding: 15px; margin-top: 15px;">
                        <strong>📋 Resumen:</strong><br>
                        👤 <strong>Tutor:</strong> ${resultado.details.tutor}<br>
                        📧 <strong>Email:</strong> ${resultado.details.email}<br>
                        👶 <strong>Menores:</strong> ${resultado.details.menores}<br>
                        📅 <strong>Fecha límite:</strong> ${resultado.details.fecha_limite}
                    </div>
                </div>
            `;
            
            // 🧹 Limpiar formulario después del éxito
            setTimeout(() => {
                if (confirm('¿Deseas limpiar el formulario para registrar una nueva admisión?')) {
                    limpiarFormulario();
                    resultadoDiv.style.display = 'none';
                }
            }, 3000);
            
        } else {
            // ❌ Error
            resultadoDiv.innerHTML = `
                <div style="background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px; padding: 20px; color: #721c24;">
                    <h4 style="margin: 0 0 10px 0; color: #721c24; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Error al Enviar
                    </h4>
                    <p style="margin: 0;">${resultado.message}</p>
                </div>
            `;
        }
        
    } catch (error) {
        // 🚨 Error de conexión o validación
        resultadoDiv.innerHTML = `
            <div style="background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px; padding: 20px; color: #721c24;">
                <h4 style="margin: 0 0 10px 0; color: #721c24; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    Error de Conexión
                </h4>
                <p style="margin: 0;">${error.message}</p>
            </div>
        `;
    } finally {
        // 🔄 Restaurar botón
        btnEnviar.disabled = false;
        btnEnviar.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Invitación';
        resultadoDiv.style.display = 'block';
        
        // 📜 Scroll suave hacia el resultado
        resultadoDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// ✅ Validación completa del formulario
function validarFormularioCompleto() {
    const form = document.getElementById('admissionForm');
    let esValido = true;
    let primerError = null;
    
    // Validar campos requeridos
    const camposRequeridos = form.querySelectorAll('input[required], select[required]');
    camposRequeridos.forEach(campo => {
        if (!campo.value.trim()) {
            campo.style.borderColor = 'var(--danger-color)';
            esValido = false;
            if (!primerError) primerError = campo;
        } else {
            campo.style.borderColor = 'var(--gray-300)';
        }
    });
    
    // Validar email específicamente
    const emailInput = document.getElementById('tutor_email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        emailInput.style.borderColor = 'var(--danger-color)';
        esValido = false;
        if (!primerError) primerError = emailInput;
    }
    
    // Validar teléfono específicamente
    const telefonoInput = document.getElementById('tutor_telefono');
    if (!/^[0-9]{10}$/.test(telefonoInput.value)) {
        telefonoInput.style.borderColor = 'var(--danger-color)';
        esValido = false;
        if (!primerError) primerError = telefonoInput;
    }
    
    // Si hay error, enfocar el primer campo con problema
    if (!esValido && primerError) {
        primerError.focus();
        primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    return esValido;
}
</script>
