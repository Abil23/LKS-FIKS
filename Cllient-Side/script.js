// Variable global untuk menyimpan data
let allEvents = [];

// DOM Elements
const tableBody = document.getElementById('tableBody');
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const contactForm = document.getElementById('contactForm');

// 1. FETCH DATA SAAT HALAMAN DIMUAT
document.addEventListener('DOMContentLoaded', () => {
    fetch('http://127.0.0.1:8000/api/events')
        .then(response => {
            if (!response.ok) throw new Error('Gagal memuat data');
            return response.json();
        })
        .then(data => {
            allEvents = data;
            renderTable(allEvents); // Tampilkan data awal
        })
        .catch(error => {
            console.error('Error:', error);
            tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500">Gagal mengambil data jadwal. Pastikan Anda menjalankan ini di local server (XAMPP/Live Server).</td></tr>`;
        });
});

// 2. FUNGSI RENDER TABEL
function renderTable(data) {
    tableBody.innerHTML = ''; // Bersihkan isi tabel

    if (data.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data ditemukan.</td></tr>`;
        return;
    }

    data.forEach(event => {
        const row = `
            <tr class="hover:bg-blue-50 transition duration-200">
                <td class="px-6 py-4 border-b border-gray-100 font-medium text-gray-900">#${event.id}</td>
                <td class="px-6 py-4 border-b border-gray-100 text-blue-600 font-semibold">${event.event_name}</td>
                <td class="px-6 py-4 border-b border-gray-100 whitespace-nowrap"> ${formatDate(event.event_date)}</td>
                <td class="px-6 py-4 border-b border-gray-100">
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">${event.organizer}</span>
                </td>
                <td class="px-6 py-4 border-b border-gray-100 text-gray-600 italic">"${event.description}"</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Helper: Format Tanggal ke Indonesia
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// 3. LOGIKA FILTER & SORTING
function filterAndSortData() {
    let filtered = [...allEvents];
    const searchTerm = searchInput.value.toLowerCase();
    const sortValue = sortSelect.value;

    // Filter Logic
    if (searchTerm) {
        filtered = filtered.filter(item => 
            item.event_name.toLowerCase().includes(searchTerm) ||
            item.description.toLowerCase().includes(searchTerm) ||
            item.organizer.toLowerCase().includes(searchTerm)
        );
    }

    // Sort Logic
    if (sortValue === 'date-asc') {
        filtered.sort((a, b) => new Date(a.event_date) - new Date(b.event_date));
    } else if (sortValue === 'date-desc') {
        filtered.sort((a, b) => new Date(b.event_date) - new Date(a.event_date));
    } else if (sortValue === 'name-asc') {
        filtered.sort((a, b) => a.event_name.localeCompare(b.event_name));
    }

    renderTable(filtered);
}

// Event Listeners untuk Filter/Sort
searchInput.addEventListener('input', filterAndSortData);
sortSelect.addEventListener('change', filterAndSortData);

// 4. FITUR DOWNLOAD PDF (Sisi Client)
function downloadPDF() {
    // Menggunakan library jsPDF yang di-include di HTML
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Judul PDF
    doc.setFontSize(18);
    doc.text('Jadwal Kegiatan OSKA MIEPRA', 14, 20);
    doc.setFontSize(11);
    doc.text(`Dicetak pada: ${new Date().toLocaleDateString('id-ID')}`, 14, 28);

    // Ambil data yang sedang tampil di tabel (untuk support hasil filter)
    // Kita gunakan library autoTable untuk konversi tabel HTML ke PDF dengan mudah
    doc.autoTable({
        html: '#eventsTable',
        startY: 35,
        theme: 'grid',
        headStyles: { fillColor: [37, 99, 235] }, // Warna biru sesuai Tailwind
        styles: { fontSize: 8 }, // Font lebih kecil biar muat
        columnStyles: {
            4: { cellWidth: 50 } // Kolom keterangan lebih lebar
        }
    });

    // Simpan File
    doc.save('OSKA.pdf');
}

// 5. CONTACT FORM TO WHATSAPP
contactForm.addEventListener('submit', function(e) {
    e.preventDefault(); // Mencegah reload halaman

    const name = document.getElementById('name').value;
    const className = document.getElementById('class').value;
    const message = document.getElementById('message').value;

    // Nomor Tujuan (Format Internasional tanpa +)
    const phoneNumber = '6281357980801';

    // Format Pesan
    const text = `Halo Admin OSKA MIEPRA,%0A%0APerkenalkan saya:%0ANama: ${name}%0AKelas: ${className}%0A%0AIngin menyampaikan pesan:%0A"${message}"%0A%0ATerima kasih.`;

    // Buka WhatsApp di tab baru
    window.open(`https://wa.me/${phoneNumber}?text=${text}`, '_blank');

    // Reset Form (Opsional)
    contactForm.reset();
});

// ==========================================
// 6. LOGIKA HAMBURGER MENU (MOBILE)
// ==========================================

const mobileBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const mobileLinks = document.querySelectorAll('.mobile-link');

// Toggle Menu & Animasi Ikon
mobileBtn.addEventListener('click', () => {
    // 1. Buka/Tutup Menu
    mobileMenu.classList.toggle('hidden');
    
    // 2. Animasi Ikon (Tambah/Hapus class hamburger-active)
    mobileBtn.classList.toggle('hamburger-active');
});

// Tutup menu otomatis saat link diklik
mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        // PENTING: Kembalikan ikon jadi hamburger saat menu tertutup
        mobileBtn.classList.remove('hamburger-active');
    });
});

// Tutup menu jika klik di luar
document.addEventListener('click', (e) => {
    if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.add('hidden');
        // PENTING: Kembalikan ikon jadi hamburger
        mobileBtn.classList.remove('hamburger-active');
    }
});

const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('.nav-link');

window.addEventListener('scroll', () => {
    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (scrollY >= (sectionTop - sectionHeight / 3)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active-link');
        link.classList.remove('text-blue-600');

        if (link.getAttribute('href').includes(current)) {
            link.classList.add('active-link');
            link.classList.add('text-blue-600'); 
        }
    });
});

