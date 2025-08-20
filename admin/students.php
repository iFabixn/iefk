<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Obtener la sección actual y parámetros
$section = $_GET['section'] ?? 'planteles';
$plantel = $_GET['plantel'] ?? '';
$aula = $_GET['aula'] ?? '';
$alumno_id = $_GET['alumno_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnado - Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #17a2b8;
            --primary-light: #d1ecf1;
            --primary-dark: #117a8b;
            --secondary-color: #28a745;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --shadow: 0 4px 15px rgba(23, 162, 184, 0.1);
            --shadow-lg: 0 8px 25px rgba(23, 162, 184, 0.15);
            --border-radius: 12px;
            --transition: all 0.3s ease;
            --sidebar-width: 300px;
        }

        /* ===================== RESET Y BASE ===================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-100);
            color: var(--dark-color);
            overflow-x: hidden;
        }

        /* ===================== HEADER ===================== */
        .header {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 70px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: none;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .logo-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .back-btn:hover {
            background: var(--primary-dark);
            color: var(--white);
            text-decoration: none;
        }

        /* ===================== LAYOUT PRINCIPAL ===================== */
        .main-layout {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: block;
            padding: 1rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            text-decoration: none;
            border-left-color: var(--primary-color);
        }

        .menu-item.active {
            background: var(--primary-light);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .menu-submenu {
            background: var(--gray-100);
            padding-left: 2rem;
        }

        .menu-submenu .menu-item {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }

        /* ===================== CONTENIDO PRINCIPAL ===================== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .content-header {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .content-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .content-description {
            color: var(--gray-600);
            line-height: 1.5;
        }

        .content-body {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        /* ===================== TARJETAS DE PLANTELES ===================== */
        .planteles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .plantel-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
            cursor: pointer;
        }

        .plantel-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .plantel-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .plantel-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
        }

        .plantel-info h3 {
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .plantel-info p {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .plantel-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--gray-100);
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-top: 0.25rem;
        }

        /* ===================== TARJETAS DE AULAS ===================== */
        .aulas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .aula-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-top: 4px solid var(--primary-color);
            cursor: pointer;
        }

        .aula-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .aula-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .aula-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .aula-capacity {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ===================== LISTA DE ALUMNOS ===================== */
        .alumnos-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .alumno-card {
            background: var(--white);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 3px solid var(--primary-color);
            cursor: pointer;
        }

        .alumno-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .alumno-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }

        .alumno-name {
            font-weight: bold;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .alumno-details {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .alumno-status {
            display: flex;
            gap: 0.5rem;
        }

        /* ===================== FICHA DEL ALUMNO ===================== */
        .ficha-alumno {
            max-width: 1200px;
            margin: 0 auto;
        }

        .ficha-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .alumno-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 2.5rem;
        }

        .alumno-main-info h2 {
            margin-bottom: 0.5rem;
        }

        .alumno-main-info p {
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .ficha-tabs {
            display: flex;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
        }

        .tab-button {
            padding: 1rem 1.5rem;
            border: none;
            background: none;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
        }

        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .tab-content {
            background: var(--white);
            padding: 2rem;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: var(--gray-100);
            padding: 1.5rem;
            border-radius: 10px;
        }

        .info-section h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--gray-300);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-700);
        }

        .info-value {
            color: var(--dark-color);
        }

        /* ===================== BOTONES Y ACCIONES ===================== */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--gray-500);
            color: var(--white);
        }

        .btn-success {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* ===================== BADGES ===================== */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-active {
            background: var(--success-color);
            color: var(--white);
        }

        .badge-inactive {
            background: var(--gray-500);
            color: var(--white);
        }

        .badge-pending {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        .badge-info {
            background: var(--primary-color);
            color: var(--white);
        }

        /* ===================== BÚSQUEDA Y FILTROS ===================== */
        .search-filters {
            background: var(--white);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
        }

        /* ===================== ESTILOS ESPECÍFICOS PARA STUDENTS ===================== */
        .content-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        /* ===================== ESTILOS PARA FICHA DE ALUMNO ===================== */
        .ficha-alumno {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .ficha-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .alumno-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--white);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: bold;
            border: 4px solid rgba(255,255,255,0.3);
        }

        .alumno-main-info h2 {
            margin: 0 0 0.5rem 0;
            font-size: 1.8rem;
        }

        .alumno-main-info p {
            margin: 0.25rem 0;
            opacity: 0.9;
        }

        .ficha-tabs {
            display: flex;
            background: var(--gray-100);
            border-bottom: 1px solid var(--gray-300);
            overflow-x: auto;
        }

        .tab-button {
            padding: 1rem 1.5rem;
            border: none;
            background: transparent;
            color: var(--gray-600);
            cursor: pointer;
            font-weight: 600;
            white-space: nowrap;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-button:hover {
            background: var(--white);
            color: var(--primary-color);
        }

        .tab-button.active {
            background: var(--white);
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .tab-content {
            padding: 2rem;
        }

        .tab-pane {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .info-section h4 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-700);
        }

        .info-value {
            color: var(--gray-900);
            font-weight: 500;
        }

        /* ===================== ESTILOS PARA BÚSQUEDA GLOBAL ===================== */
        .search-container {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .search-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .search-field {
            display: flex;
            flex-direction: column;
        }

        .search-field label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .search-field input,
        .search-field select {
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .search-field input:focus,
        .search-field select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .search-results-summary {
            background: var(--primary-light);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .student-result-card {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .student-result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .student-result-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .student-basic-info h4 {
            margin: 0;
            color: var(--primary-dark);
        }

        .student-basic-info p {
            margin: 0.25rem 0;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .student-result-details {
            margin: 1rem 0;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .medical-alerts {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .alert-badge {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .alert-badge.allergy {
            background: var(--danger-light);
            color: var(--danger-color);
        }

        .alert-badge.medication {
            background: var(--warning-light);
            color: var(--warning-color);
        }

        .student-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
        }

        .no-results-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .quick-searches {
            margin-top: 2rem;
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .quick-search-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        /* ===================== ESTILOS PARA ESTADÍSTICAS ===================== */
        .stats-overview {
            margin-bottom: 3rem;
        }

        .stats-overview h3 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .stat-card.primary::before { background: var(--primary-color); }
        .stat-card.success::before { background: var(--success-color); }
        .stat-card.info::before { background: var(--info-color); }
        .stat-card.warning::before { background: var(--warning-color); }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
        }

        .stat-card.primary .stat-icon { background: var(--primary-color); }
        .stat-card.success .stat-icon { background: var(--success-color); }
        .stat-card.info .stat-icon { background: var(--info-color); }
        .stat-card.warning .stat-icon { background: var(--warning-color); }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-weight: 600;
        }

        .stats-section {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .stats-section h3 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .level-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .level-stat {
            text-align: center;
        }

        .level-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--white);
        }

        .level-circle.guarderia { background: var(--info-color); }
        .level-circle.preescolar { background: var(--success-color); }
        .level-circle.primaria { background: var(--warning-color); }

        .bar-chart {
            display: flex;
            align-items: end;
            gap: 2rem;
            height: 200px;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 10px;
        }

        .bar-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .bar {
            width: 100%;
            background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
            border-radius: 5px 5px 0 0;
            transition: height 1s ease;
        }

        .plantel-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .plantel-stat-card {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .plantel-stat-card h4 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .plantel-numbers {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .plantel-total .number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .occupation-bar {
            width: 100px;
            height: 8px;
            background: var(--gray-300);
            border-radius: 4px;
            overflow: hidden;
        }

        .occupation-fill {
            height: 100%;
            background: var(--success-color);
            transition: width 1s ease;
        }

        .plantel-breakdown {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        /* ===================== ESTILOS PARA REPORTES ===================== */
        .quick-reports {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .quick-reports h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .quick-reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .quick-report-card {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .report-content {
            flex: 1;
        }

        .report-content h4 {
            margin: 0 0 0.5rem 0;
            color: var(--primary-dark);
        }

        .report-content p {
            margin: 0;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .report-format {
            margin-top: 0.5rem;
        }

        .custom-reports {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .report-configurator {
            background: var(--gray-50);
            padding: 2rem;
            border-radius: 12px;
        }

        .config-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-300);
        }

        .config-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .config-section h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .report-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .report-type-option input[type="radio"] {
            display: none;
        }

        .report-type-label {
            display: block;
            background: var(--white);
            padding: 1.5rem;
            border-radius: 12px;
            border: 2px solid var(--gray-300);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .report-type-option input[type="radio"]:checked + .report-type-label {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .type-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .type-content h5 {
            margin: 0 0 0.5rem 0;
            color: var(--primary-dark);
        }

        .type-options {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .type-options span {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .filter-group input,
        .filter-group select {
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .fields-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .field-category {
            background: var(--white);
            padding: 1rem;
            border-radius: 8px;
        }

        .field-category h5 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .field-checkboxes {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .field-checkboxes label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .format-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 1rem;
        }

        .format-option input[type="radio"] {
            display: none;
        }

        .format-card {
            background: var(--white);
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid var(--gray-300);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .format-option input[type="radio"]:checked + .format-card {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .format-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .additional-options {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .config-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .saved-templates,
        .reports-history {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .template-card {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .template-info h4 {
            margin: 0 0 0.5rem 0;
            color: var(--primary-dark);
        }

        .template-info p {
            margin: 0 0 1rem 0;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .template-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .template-date {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .template-actions {
            display: flex;
            gap: 0.5rem;
        }

        .history-table {
            overflow-x: auto;
        }

        .history-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .history-table th,
        .history-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-300);
        }

        .history-table th {
            background: var(--gray-100);
            font-weight: 600;
            color: var(--primary-dark);
        }

        .history-table td {
            color: var(--gray-700);
        }

        /* ===================== CLASES PARA BADGES/ALERTAS ===================== */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-active {
            background: var(--success-light);
            color: var(--success-color);
        }

        .badge-inactive, .badge-dado-de-baja {
            background: var(--danger-light);
            color: var(--danger-color);
        }

        .badge-pending, .badge-pendiente-documentos {
            background: var(--warning-light);
            color: var(--warning-color);
        }

        .badge-info {
            background: var(--info-light);
            color: var(--info-color);
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .badge-success {
            background: var(--success-light);
            color: var(--success-color);
        }

        .badge-warning {
            background: var(--warning-light);
            color: var(--warning-color);
        }

        .badge-danger {
            background: var(--danger-light);
            color: var(--danger-color);
        }

        .badge-secondary {
            background: var(--gray-300);
            color: var(--gray-700);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 1rem;
            }

            .search-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .search-actions {
                justify-self: stretch;
            }

            .results-grid {
                grid-template-columns: 1fr;
            }

            .stats-cards {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .quick-reports-grid,
            .templates-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .ficha-tabs {
                flex-wrap: wrap;
            }

            .tab-button {
                flex: 1;
                min-width: 120px;
            }
        }

        /* ===================== ANIMACIONES ===================== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-body, .plantel-card, .aula-card, .alumno-card {
            animation: fadeIn 0.5s ease;
        }
    </style>
</head>
<body>
    <!-- ===================== HEADER ===================== -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo-img">
                <div class="logo-text">IEFK Admin</div>
            </div>
            
            <div class="breadcrumb">
                <a href="dashboard.php"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <span>Alumnado</span>
                <?php if($plantel): ?>
                    <i class="fas fa-chevron-right"></i>
                    <a href="?section=aulas&plantel=<?= $plantel ?>"><?= ucfirst(str_replace('_', ' ', $plantel)) ?></a>
                <?php endif; ?>
                <?php if($aula): ?>
                    <i class="fas fa-chevron-right"></i>
                    <a href="?section=alumnos&plantel=<?= $plantel ?>&aula=<?= $aula ?>"><?= $aula ?></a>
                <?php endif; ?>
                <?php if($alumno_id): ?>
                    <i class="fas fa-chevron-right"></i>
                    <span>Ficha Alumno</span>
                <?php endif; ?>
            </div>

            <div class="user-info">
                <a href="dashboard.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- ===================== LAYOUT PRINCIPAL ===================== -->
    <div class="main-layout">
        <!-- ===================== SIDEBAR ===================== -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-graduation-cap"></i>
                    Gestión de Alumnado
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="?section=planteles" class="menu-item <?= $section === 'planteles' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    Vista por Planteles
                </a>
                
                <a href="?section=busqueda" class="menu-item <?= $section === 'busqueda' ? 'active' : '' ?>">
                    <i class="fas fa-search"></i>
                    Búsqueda Global
                </a>
                
                <a href="?section=estadisticas" class="menu-item <?= $section === 'estadisticas' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i>
                    Estadísticas
                </a>
                
                <a href="?section=reportes" class="menu-item <?= $section === 'reportes' ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i>
                    Reportes
                </a>
                
                <div class="menu-submenu">
                    <a href="?section=aulas&plantel=zapote" class="menu-item">
                        <i class="fas fa-school"></i>
                        El Zapote
                    </a>
                    <a href="?section=aulas&plantel=rio_nilo" class="menu-item">
                        <i class="fas fa-school"></i>
                        Río Nilo
                    </a>
                    <a href="?section=aulas&plantel=colinas" class="menu-item">
                        <i class="fas fa-school"></i>
                        Colinas
                    </a>
                </div>
            </div>
        </nav>

        <!-- ===================== CONTENIDO PRINCIPAL ===================== -->
        <main class="main-content">
            <?php
            switch($section) {
                case 'planteles':
                    include 'student_sections/vista_planteles.php';
                    break;
                case 'aulas':
                    include 'student_sections/vista_aulas.php';
                    break;
                case 'alumnos':
                    include 'student_sections/lista_alumnos.php';
                    break;
                case 'ficha':
                    include 'student_sections/ficha_alumno.php';
                    break;
                case 'busqueda':
                    include 'student_sections/busqueda_global.php';
                    break;
                case 'estadisticas':
                    include 'student_sections/estadisticas.php';
                    break;
                case 'reportes':
                    include 'student_sections/reportes.php';
                    break;
                default:
                    include 'student_sections/vista_planteles.php';
            }
            ?>
        </main>
    </div>

    <!-- ===================== SCRIPTS ===================== -->
    <script>
        // Función para navegar entre secciones
        function navigateTo(section, params = {}) {
            let url = `?section=${section}`;
            Object.keys(params).forEach(key => {
                url += `&${key}=${encodeURIComponent(params[key])}`;
            });
            window.location.href = url;
        }

        // Función para mostrar ficha de alumno
        function showStudentCard(alumnoId) {
            navigateTo('ficha', { alumno_id: alumnoId });
        }

        // Función para editar alumno
        function editStudent(alumnoId) {
            if(confirm('¿Abrir editor de información del alumno?')) {
                // Aquí se abriría un modal o página de edición
                alert(`Abriendo editor para alumno ID: ${alumnoId}`);
            }
        }

        // Función para eliminar alumno
        function deleteStudent(alumnoId, nombreAlumno) {
            if(confirm(`¿Está seguro de que desea eliminar al alumno "${nombreAlumno}"?\n\nEsta acción no se puede deshacer.`)) {
                // Aquí se procesaría la eliminación
                alert(`Alumno "${nombreAlumno}" eliminado del sistema.`);
                // Recargar la página o actualizar la lista
                location.reload();
            }
        }

        // Función para búsqueda en tiempo real
        function searchStudents(query) {
            // Aquí se implementaría la búsqueda AJAX
            console.log('Buscando:', query);
        }

        // Función para filtrar por criterios
        function applyFilters() {
            const filters = {
                plantel: document.getElementById('filter-plantel')?.value,
                aula: document.getElementById('filter-aula')?.value,
                status: document.getElementById('filter-status')?.value,
                edad: document.getElementById('filter-edad')?.value
            };
            
            console.log('Aplicando filtros:', filters);
            // Aquí se procesarían los filtros
        }

        // Función para exportar datos
        function exportData(format) {
            if(confirm(`¿Exportar datos de alumnos en formato ${format.toUpperCase()}?`)) {
                alert(`Generando archivo ${format.toUpperCase()}...\nEl archivo se descargará automáticamente.`);
            }
        }

        // Efectos visuales al cargar
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para elementos
            const elements = document.querySelectorAll('.content-body, .plantel-card, .aula-card, .alumno-card');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
