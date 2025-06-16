// js/admin.js

document.addEventListener('DOMContentLoaded', function() {
    const venueFormModal = document.getElementById('venue-form-modal');
    const addVenueButton = document.getElementById('add-venue-button');
    const closeModalButton = venueFormModal ? venueFormModal.querySelector('.close-button') : null;
    const venueCrudForm = document.getElementById('venue-crud-form');
    const venuesTableBody = document.getElementById('venues-table-body');
    const formTitle = document.getElementById('form-title');
    const formSubmitButton = document.getElementById('form-submit-button');
    const formMessage = document.getElementById('form-message');
    const tableMessage = document.getElementById('table-message');

    // --- Modal Logic for Venues (Add/Edit) ---
    if (addVenueButton) {
        addVenueButton.addEventListener('click', function() {
            // Reset form for adding new venue
            if (venueCrudForm) venueCrudForm.reset();
            if (document.getElementById('venue-id')) document.getElementById('venue-id').value = '';
            if (formTitle) formTitle.textContent = 'Tambah Lapangan';
            if (formSubmitButton) formSubmitButton.textContent = 'Simpan Lapangan';
            if (formMessage) formMessage.textContent = '';
            if (venueFormModal) venueFormModal.style.display = 'block';
        });
    }

    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            if (venueFormModal) venueFormModal.style.display = 'none';
        });
    }

    // Close modal if clicking outside of it
    if (venueFormModal) {
        window.addEventListener('click', function(event) {
            if (event.target == venueFormModal) {
                venueFormModal.style.display = 'none';
            }
        });
    }

    // --- Form Submission for Venues (Add/Edit) ---
    if (venueCrudForm) {
        venueCrudForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(venueCrudForm);
            const venueId = document.getElementById('venue-id').value;
            formData.append('action', venueId ? 'edit' : 'add'); // Determine action based on ID

            fetch('../actions/process_venue.php', { // Path ke script PHP
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (formMessage) {
                    formMessage.textContent = data.message;
                    formMessage.className = 'message ' + (data.status === 'success' ? 'success-message' : 'error-message');
                }
                if (data.status === 'success') {
                    // Optionally, refresh table or update row
                    setTimeout(() => {
                        if (venueFormModal) venueFormModal.style.display = 'none';
                        location.reload(); // Simple reload for now to update table
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (formMessage) {
                    formMessage.textContent = 'Terjadi kesalahan saat memproses permintaan.';
                    formMessage.className = 'message error-message';
                }
            });
        });
    }

    // --- Edit Button Click Handler for Venues ---
    if (venuesTableBody) {
        venuesTableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-btn')) {
                const button = e.target;
                if (document.getElementById('venue-id')) document.getElementById('venue-id').value = button.dataset.id;
                if (document.getElementById('venue-name')) document.getElementById('venue-name').value = button.dataset.name;
                if (document.getElementById('venue-sport')) document.getElementById('venue-sport').value = button.dataset.sport;
                if (document.getElementById('venue-address')) document.getElementById('venue-address').value = button.dataset.address;
                if (document.getElementById('venue-city')) document.getElementById('venue-city').value = button.dataset.city;
                if (document.getElementById('venue-price')) document.getElementById('venue-price').value = button.dataset.price;
                if (document.getElementById('venue-description')) document.getElementById('venue-description').value = button.dataset.description;
                if (document.getElementById('venue-image')) document.getElementById('venue-image').value = button.dataset.image;

                if (formTitle) formTitle.textContent = 'Edit Lapangan';
                if (formSubmitButton) formSubmitButton.textContent = 'Perbarui Lapangan';
                if (formMessage) formMessage.textContent = '';
                if (venueFormModal) venueFormModal.style.display = 'block';
            }

            // --- Delete Button Click Handler for Venues ---
            if (e.target.classList.contains('delete-btn')) {
                const venueId = e.target.dataset.id;
                if (confirm('Apakah Anda yakin ingin menghapus lapangan ini?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', venueId);

                    fetch('../actions/process_venue.php', { // Path ke script PHP
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (tableMessage) {
                            tableMessage.textContent = data.message;
                            tableMessage.className = 'message ' + (data.status === 'success' ? 'success-message' : 'error-message');
                        }
                        if (data.status === 'success') {
                            // Remove the row from the table
                            e.target.closest('tr').remove();
                            // If no rows left, update table message
                            if (venuesTableBody.rows.length === 0) {
                                venuesTableBody.innerHTML = '<tr><td colspan="6">Belum ada lapangan yang ditambahkan.</td></tr>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (tableMessage) {
                            tableMessage.textContent = 'Terjadi kesalahan saat menghapus lapangan.';
                            tableMessage.className = 'message error-message';
                        }
                    });
                }
            }

            // --- Booking Action Buttons (Confirm, Cancel, Complete) ---
            if (e.target.classList.contains('action-btn') && !e.target.classList.contains('view-btn')) {
                const button = e.target;
                const bookingId = button.dataset.id;
                let action = '';
                let confirmationMessage = '';

                if (button.classList.contains('confirm-btn')) {
                    action = 'confirm';
                    confirmationMessage = 'Apakah Anda yakin ingin mengkonfirmasi booking ini?';
                } else if (button.classList.contains('cancel-btn')) {
                    action = 'cancel';
                    confirmationMessage = 'Apakah Anda yakin ingin membatalkan booking ini?';
                } else if (button.classList.contains('complete-btn')) {
                    action = 'complete';
                    confirmationMessage = 'Apakah Anda yakin ingin menyelesaikan booking ini?';
                }

                if (action && confirm(confirmationMessage)) {
                    const formData = new FormData();
                    formData.append('action', action);
                    formData.append('id', bookingId);

                    fetch('../actions/process_booking.php', { // Path ke script PHP
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Find the message element for bookings table, or reuse tableMessage
                        const currentTableMessage = document.getElementById('table-message') || document.querySelector('.admin-main-content .message');
                        if (currentTableMessage) {
                            currentTableMessage.textContent = data.message;
                            currentTableMessage.className = 'message ' + (data.status === 'success' ? 'success-message' : 'error-message');
                        }

                        if (data.status === 'success') {
                            // Simple reload for now to update table status,
                            // or implement more complex DOM manipulation
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (tableMessage) {
                            tableMessage.textContent = 'Terjadi kesalahan saat memproses booking.';
                            tableMessage.className = 'message error-message';
                        }
                    });
                }
            }
        });
    }
});
