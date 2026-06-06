/**
 * Admin Panel - JavaScript
 * Statistical Solutions Club
 */

// Toggle password visibility on login
function togglePasswordVisibility() {
    const passInput = document.getElementById('login-pass');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passInput.type === 'password') {
        passInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Auto-hide success alerts after 4 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlerts = document.querySelectorAll('.admin-alert-success');
    successAlerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 4000);
    });

    // File input preview (optional enhancement)
    const fileInputs = document.querySelectorAll('.admin-file-input');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const count = this.files.length;
                const label = count === 1 ? this.files[0].name : count + ' archivos seleccionados';
                // Create or update a small text indicator below the input
                let indicator = this.nextElementSibling;
                if (!indicator || !indicator.classList.contains('file-indicator')) {
                    indicator = document.createElement('small');
                    indicator.classList.add('file-indicator');
                    indicator.style.color = '#6ee7b7';
                    indicator.style.fontSize = '0.78rem';
                    indicator.style.marginTop = '4px';
                    indicator.style.display = 'block';
                    this.parentNode.insertBefore(indicator, this.nextSibling);
                }
                indicator.innerHTML = '<i class="fas fa-check-circle"></i> ' + label;
            }
        });
    });
});
