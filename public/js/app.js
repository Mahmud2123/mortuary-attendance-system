document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle for mobile
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('show'));
    }

    // Auto-dismiss toast alerts after 5 seconds
    document.querySelectorAll('.toast-alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

    // Initialize DataTables on tables with class 'datatable'
    if (window.jQuery && $.fn.DataTable) {
        $('.datatable').DataTable({ pageLength: 15 });
    }
});
