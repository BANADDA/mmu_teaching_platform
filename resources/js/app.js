import Focus from '@alpinejs/focus';
import Alpine from 'alpinejs';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import './bootstrap';

// Initialize Alpine plugins
Alpine.plugin(Focus);

// Make Alpine available globally
window.Alpine = Alpine;

// Initialize Alpine
Alpine.start();

// Initialize Livewire
Livewire.start();

// Custom JavaScript for the application
document.addEventListener('DOMContentLoaded', () => {
    // Flash messages auto-hide
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 3000);
    });

    // Confirm dialogs
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirm(button.dataset.confirm || 'Are you sure?')) {
                e.preventDefault();
            }
        });
    });
});

// Custom Alpine components
Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('modal', () => ({
    show: false,
    toggle() {
        this.show = !this.show;
    },
    close() {
        this.show = false;
    }
}));

// File upload preview
Alpine.data('fileUpload', () => ({
    previewUrl: null,
    updatePreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}));

// Notification system
window.showNotification = (message, type = 'success') => {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white transform transition-all duration-500 ease-in-out z-50 ${
        type === 'success' ? 'bg-emerald-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
};
