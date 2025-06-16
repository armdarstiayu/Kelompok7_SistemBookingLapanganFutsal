document.addEventListener('DOMContentLoaded', () => {
    // --- Fungsionalitas Umum ---

    // Handle pencarian di halaman beranda
    const searchButton = document.getElementById('search-button');
    if (searchButton) {
        searchButton.addEventListener('click', () => {
            const searchTerm = document.getElementById('search-input').value;
            // Arahkan ke halaman venues.html dengan parameter pencarian
            window.location.href = `venues.html?search=${encodeURIComponent(searchTerm)}`;
        });
    }

    // --- Fungsionalitas untuk Menampilkan Venue ---

    // Fungsi untuk membuat dan menambahkan kartu venue
    const createVenueCard = (venue) => {
        const venueCard = document.createElement('div');
        venueCard.classList.add('venue-card');
        venueCard.innerHTML = `
            <img src="${venue.image_url || 'https://via.placeholder.com/300x200/ADD8E6/000000?text=Venue'}" alt="${venue.name}">
            <h3>${venue.name}</h3>
            <p>${venue.address}</p>
            <p class="price">Rp ${new Intl.NumberFormat('id-ID').format(venue.price_per_hour)} / Jam</p>
            <button class="booking-button" data-venue-id="${venue.id}">Booking Sekarang</button>
        `;
        // Tambahkan event listener untuk tombol booking
        venueCard.querySelector('.booking-button').addEventListener('click', () => {
            // Ini bisa diarahkan ke halaman booking atau menampilkan pop-up
            alert(`Anda ingin booking: ${venue.name}\n(Fungsionalitas booking akan dikembangkan nanti)`);
            // Contoh redirect ke halaman detail:
            // window.location.href = `detail.html?id=${venue.id}`;
        });
        return venueCard;
    };

    // Fungsi untuk mengambil dan menampilkan data venue ke elemen tertentu
    const fetchAndDisplayVenues = (targetElementId, params = {}) => {
        const targetElement = document.getElementById(targetElementId);
        if (!targetElement) return;

        targetElement.innerHTML = '<p class="loading-message">Memuat lapangan...</p>'; // Pesan loading

        const queryString = new URLSearchParams(params).toString();
        const url = `src/get_venues.php?${queryString}`; // Pastikan path ke PHP API benar dari public/

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                targetElement.innerHTML = ''; // Kosongkan daftar sebelumnya
                if (data.length > 0) {
                    data.forEach(venue => {
                        targetElement.appendChild(createVenueCard(venue));
                    });
                } else {
                    targetElement.innerHTML = '<p>Tidak ada lapangan yang ditemukan.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching venues:', error);
                targetElement.innerHTML = '<p>Maaf, terjadi kesalahan saat memuat lapangan. Silakan coba lagi nanti.</p>';
            });
    };

    // --- Inisialisasi Halaman `venues.html` ---
    const allVenuesList = document.getElementById('all-venues-list');
    const applyFiltersButton = document.getElementById('apply-filters');

    if (allVenuesList) {
        // Sembunyikan bagian "Semua Lapangan Tersedia" secara default jika tidak ada filter awal
        const allVenuesContainer = document.getElementById('all-venues-container');
        allVenuesContainer.style.display = 'none'; // Sembunyikan kontainer ini dulu

        const urlParams = new URLSearchParams(window.location.search);
        const initialSearchTerm = urlParams.get('search') || '';
        const initialSportFilter = urlParams.get('sport') || ''; // Ambil filter olahraga dari URL

        // Jika ada search term atau sport filter dari URL, tampilkan dan terapkan filter
        if (initialSearchTerm || initialSportFilter) {
            allVenuesContainer.style.display = 'block'; // Tampilkan kembali
            document.getElementById('sport-filter').value = initialSportFilter;
            document.getElementById('search-input') ? document.getElementById('search-input').value = initialSearchTerm : null;
            fetchAndDisplayVenues('all-venues-list', {
                search: initialSearchTerm,
                sport: initialSportFilter
            });
        }

        // Muat lapangan per kategori
        fetchAndDisplayVenues('futsal-venues-list', { sport: 'Futsal', limit: 3 });
        fetchAndDisplayVenues('badminton-venues-list', { sport: 'Badminton', limit: 3 });
        fetchAndDisplayVenues('basket-venues-list', { sport: 'Basket', limit: 3 });
        fetchAndDisplayVenues('tennis-venues-list', { sport: 'Tenis', limit: 3 });


        // Handle tombol "Terapkan Filter"
        if (applyFiltersButton) {
            applyFiltersButton.addEventListener('click', () => {
                allVenuesContainer.style.display = 'block'; // Pastikan kontainer ini terlihat
                const sport = document.getElementById('sport-filter').value;
                const location = document.getElementById('location-filter').value;
                const currentSearchInput = document.getElementById('search-input'); // Ambil dari input search jika ada (ini mungkin ada di index.html, bukan venues.html)
                const searchTerm = currentSearchInput ? currentSearchInput.value : '';

                fetchAndDisplayVenues('all-venues-list', {
                    search: searchTerm,
                    sport: sport,
                    location: location
                });

                // Sembunyikan grup kategori saat filter diterapkan
                document.querySelectorAll('.category-group').forEach(group => {
                    group.style.display = 'none';
                });
                document.querySelectorAll('hr').forEach(hr => {
                    hr.style.display = 'none';
                });

                // Jika semua filter kosong, tampilkan kembali grup kategori
                if (!sport && !location && !searchTerm) {
                     document.querySelectorAll('.category-group').forEach(group => {
                        group.style.display = 'block';
                    });
                     document.querySelectorAll('hr').forEach(hr => {
                        hr.style.display = 'block';
                    });
                    allVenuesContainer.style.display = 'none'; // Sembunyikan bagian semua lapangan jika tidak ada filter
                }
            });
        }
    }

    // --- Inisialisasi Halaman `index.html` (featured venues) ---
    const featuredVenuesList = document.getElementById('featured-venues-list');
    if (featuredVenuesList) {
        fetchAndDisplayVenues('featured-venues-list', { limit: 4 }); // Ambil 4 venue unggulan
    }

    // --- Fungsionalitas untuk Halaman `detail.html` ---
    const detailVenueName = document.getElementById('detail-venue-name');
    if (detailVenueName) {
        const urlParams = new URLSearchParams(window.location.search);
        const venueId = urlParams.get('id');

        if (venueId) {
            fetch(`src/get_venues.php?id=${venueId}`) // Pastikan path ke PHP API benar dari public/
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.length > 0) {
                        const venue = data[0]; // Ambil data venue pertama
                        document.getElementById('detail-venue-img').src = venue.image_url || 'https://via.placeholder.com/600x400/ADD8E6/000000?text=Detail+Lapangan';
                        detailVenueName.textContent = venue.name;
                        document.getElementById('detail-venue-sport').textContent = venue.sport_type;
                        document.getElementById('detail-venue-address').textContent = venue.address;
                        document.getElementById('detail-venue-price').textContent = new Intl.NumberFormat('id-ID').format(venue.price_per_hour);
                        document.getElementById('detail-venue-description').textContent = venue.description;
                    } else {
                        document.querySelector('.venue-detail-content').innerHTML = '<p>Lapangan tidak ditemukan.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching venue details:', error);
                    document.querySelector('.venue-detail-content').innerHTML = '<p>Maaf, terjadi kesalahan saat memuat detail lapangan.</p>';
                });
        } else {
            document.querySelector('.venue-detail-content').innerHTML = '<p>ID Lapangan tidak ditemukan di URL.</p>';
        }
    }
});