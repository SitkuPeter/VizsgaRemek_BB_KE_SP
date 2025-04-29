document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('openNewPostModal');
    const modal = document.getElementById('newPostModal');
    const closeBtn = document.getElementById('closeNewPostModal');
    const cancelBtn = document.getElementById('cancelNewPostModal');

    function openModal() {
        modal.classList.remove('invisible', 'opacity-0', 'pointer-events-none');
        modal.classList.add('visible', 'opacity-100');
    }
    function closeModal() {
        modal.classList.add('invisible', 'opacity-0', 'pointer-events-none');
        modal.classList.remove('visible', 'opacity-100');
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside the modal dialog
    if (modal) {
        modal.addEventListener('mousedown', function(e) {
            if (e.target === modal) closeModal();
        });
    }

    // Optional: ESC key closes modal
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeModal();
    });
});
