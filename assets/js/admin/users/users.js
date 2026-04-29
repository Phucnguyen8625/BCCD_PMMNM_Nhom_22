document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('createUserModal');
    const openBtn = document.getElementById('openCreateModal');
    const closeBtn = document.getElementById('closeCreateModal');
    const closeOverlay = document.getElementById('closeCreateModalOverlay');
    const cancelBtn = document.getElementById('cancelCreateModal');

    function openModal() {
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    if (openBtn) {
        openBtn.addEventListener('click', openModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (closeOverlay) {
        closeOverlay.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
});