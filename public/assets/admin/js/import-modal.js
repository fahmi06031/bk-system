/**
 * Import Modal Manager
 * Handles import modals with proper validation, error handling, and loading states
 */

const ImportModalManager = {
  // Configuration
  config: {
    maxFileSize: 2 * 1024 * 1024, // 2MB
    allowedFormats: ['xlsx', 'xls', 'csv'],
    allowedMimes: [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
      'application/vnd.ms-excel', // .xls
      'text/csv' // .csv
    ]
  },

  /**
   * Initialize import modals
   */
  init() {
    // Close modal when clicking outside the modal content
    document.addEventListener('click', (e) => {
      if (e.target.classList.contains('modal')) {
        this.closeModal(e.target.id);
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
          if (modal.style.display === 'flex') {
            this.closeModal(modal.id);
          }
        });
      }
    });

    // Attach file change listeners
    this.attachFileValidation();
  },

  /**
   * Open modal
   */
  openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.style.display = 'flex';
      // Reset form when opening
      const form = modal.querySelector('form');
      if (form) {
        form.reset();
        this.clearErrors(modalId);
      }
    }
  },

  /**
   * Close modal
   */
  closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.style.display = 'none';
      // Clear errors and states
      this.clearErrors(modalId);
      const form = modal.querySelector('form');
      if (form) {
        form.reset();
      }
    }
  },

  /**
   * Attach file validation to all import forms
   */
  attachFileValidation() {
    // Hanya input file di form yang action-nya mengandung '/import'
    document.querySelectorAll('.modal form[action*="/import"] input[type="file"], .modal form[action*="import"] input[type="file"]').forEach(input => {
      input.addEventListener('change', (e) => {
        this.validateFile(e);
      });

      // Also allow clearing by clicking input
      input.addEventListener('click', () => {
        this.clearErrors(input.closest('.modal').id);
      });
    });
  },

  /**
   * Validate selected file
   */
  validateFile(event) {
    const file = event.target.files[0];
    const modalId = event.target.closest('.modal').id;

    // Clear previous errors
    this.clearErrors(modalId);

    if (!file) return;

    // Check file size
    if (file.size > this.config.maxFileSize) {
      this.showError(
        modalId,
        `Ukuran file terlalu besar! Maksimal ${this.config.maxFileSize / 1024 / 1024}MB`
      );
      event.target.value = '';
      return;
    }

    // Check file format
    const fileExt = file.name.split('.').pop().toLowerCase();
    const fileMime = file.type;

    if (!this.config.allowedFormats.includes(fileExt)) {
      this.showError(
        modalId,
        `Format file tidak didukung. Gunakan: ${this.config.allowedFormats.join(', ').toUpperCase()}`
      );
      event.target.value = '';
      return;
    }

    // Show file info
    this.showFileInfo(modalId, file);
  },

  /**
   * Show file info in modal
   */
  showFileInfo(modalId, file) {
    const modal = document.getElementById(modalId);
    let fileInfoDiv = modal.querySelector('.file-info');

    if (!fileInfoDiv) {
      fileInfoDiv = document.createElement('div');
      fileInfoDiv.className = 'file-info';
      const fileGroup = modal.querySelector('.form-group.full');
      if (fileGroup) {
        fileGroup.appendChild(fileInfoDiv);
      } else {
        modal.querySelector('form').appendChild(fileInfoDiv);
      }
    }

    const fileSize = (file.size / 1024).toFixed(2);
    fileInfoDiv.innerHTML = `
      <div style="margin-top: 10px; padding: 10px; background: #e8f5e9; border: 1px solid #4caf50; border-radius: 5px; color: #2e7d32;">
        <strong>✓ File dipilih:</strong> ${file.name} (${fileSize}KB)
      </div>
    `;
  },

  /**
   * Show error message
   */
  showError(modalId, message) {
    const modal = document.getElementById(modalId);
    let errorDiv = modal.querySelector('.import-error');

    if (!errorDiv) {
      errorDiv = document.createElement('div');
      errorDiv.className = 'import-error';
      const form = modal.querySelector('form');
      form.insertBefore(errorDiv, form.firstChild);
    }

    errorDiv.innerHTML = `
      <div style="margin-bottom: 15px; padding: 12px; background: #ffebee; border-left: 4px solid #f44336; border-radius: 4px; color: #c62828;">
        <strong>⚠️ Error:</strong> ${message}
      </div>
    `;
  },

  /**
   * Clear all errors in modal
   */
  clearErrors(modalId) {
    const modal = document.getElementById(modalId);
    const errorDiv = modal.querySelector('.import-error');
    const fileInfoDiv = modal.querySelector('.file-info');

    if (errorDiv) {
      errorDiv.remove();
    }
    if (fileInfoDiv) {
      fileInfoDiv.remove();
    }
  },

  /**
   * Show loading state
   */
  showLoading(modalId) {
    const modal = document.getElementById(modalId);
    const form = modal.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const cancelBtn = form.querySelector('.btn-cancel');

    // Hanya disable button, jangan disable input file agar file tetap terkirim
    if (submitBtn) submitBtn.disabled = true;
    if (cancelBtn) cancelBtn.disabled = true;

    // Show loading indicator
    submitBtn.innerHTML = '<i class="bx bx-loader-alt" style="animation: spin 1s linear infinite;"></i> Memproses...';
  },

  /**
   * Hide loading state
   */
  hideLoading(modalId) {
    const modal = document.getElementById(modalId);
    const form = modal.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const cancelBtn = form.querySelector('.btn-cancel');

    // Enable buttons only
    if (submitBtn) submitBtn.disabled = false;
    if (cancelBtn) cancelBtn.disabled = false;

    // Restore button text
    submitBtn.innerHTML = 'Import';
  },

  /**
   * Handle form submission with loading state
   */
  handleSubmit(form) {
    const modalId = form.closest('.modal').id;
    this.showLoading(modalId);
    // Form akan submit normally and page will redirect
    // Sekarang showLoading hanya disable button, bukan input file
  }
};

// Add CSS animation for loading spinner
const style = document.createElement('style');
style.textContent = `
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
`;
document.head.appendChild(style);

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  ImportModalManager.init();
});
