<style>
    :root {
        --royal-blue: #1E40AF;
        --gold: #D4AF37;
        --gold-light: #F3E5AB;
    }

    .fi-simple-layout {
        background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #0F172A 100%) !important;
    }

    .fi-simple-card {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        border-top: 4px solid #D4AF37 !important;
    }

    .fi-simple-card .fi-btn-primary {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%) !important;
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-weight: 600 !important;
    }

    .fi-simple-card .fi-btn-primary:hover {
        background: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 100%) !important;
    }

    .fi-simple-card .fi-input:focus {
        border-color: #1E40AF !important;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.15) !important;
    }

    .fi-sidebar {
        background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%) !important;
    }

    .fi-sidebar .fi-sidebar-header {
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }

    .fi-sidebar-item-active a {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%) !important;
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3);
    }

    .fi-sidebar-item-active .fi-sidebar-item-label,
    .fi-sidebar-item-active .fi-sidebar-item-icon {
        color: white !important;
    }

    .fi-sidebar-group-label {
        color: #D4AF37 !important;
        font-weight: 600 !important;
        letter-spacing: 0.05em;
        font-size: 0.7rem !important;
    }

    .fi-sidebar-item .fi-sidebar-item-icon {
        color: #94A3B8 !important;
    }

    .fi-sidebar-item:hover a {
        background: rgba(30, 64, 175, 0.15) !important;
    }

    .fi-topbar {
        background: white !important;
        border-bottom: 2px solid #1E40AF !important;
    }

    .fi-btn-primary {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%) !important;
    }

    .fi-btn-primary:hover {
        background: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 100%) !important;
    }

    a[wire\:key*="notification"] .fi-badge {
        background: #D4AF37 !important;
        color: #0F172A !important;
    }

    .fi-badge {
        font-weight: 600 !important;
    }

    .fi-section-header-heading span {
        color: #1E40AF !important;
    }

    .fi-ta-header-cell {
        color: #1E40AF !important;
        font-weight: 600 !important;
    }

    .fi-pagination-item-active button {
        background: #1E40AF !important;
        color: white !important;
    }

    .fi-dropdown-list-item-active {
        background: rgba(30, 64, 175, 0.1) !important;
    }

    .fi-fo-field-label label span {
        color: #1E40AF !important;
        font-weight: 600 !important;
    }

    .fi-input:focus {
        border-color: #1E40AF !important;
        box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2) !important;
    }

    .fi-select-input:focus {
        border-color: #1E40AF !important;
        box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2) !important;
    }

    .fi-ta-record-url:hover {
        color: #1E40AF !important;
    }

    .fi-icon-btn:hover {
        color: #1E40AF !important;
    }

    .fi-tabs-item-active button {
        color: #1E40AF !important;
        border-color: #1E40AF !important;
    }

    .fi-badge-success {
        background: #D4AF37 !important;
        color: #0F172A !important;
    }

    .fi-badge-warning {
        background: #F59E0B !important;
    }

    .fi-badge-danger {
        background: #DC2626 !important;
    }
</style>