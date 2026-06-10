const filmForm = document.getElementById('film-form');
const formTitle = document.getElementById('form-title');
const inputIdFilm = document.getElementById('input-id-film');
const inputJudul = document.getElementById('input-judul');
const inputGenre = document.getElementById('input-genre');
const inputDurasi = document.getElementById('input-durasi');
const btnSubmitForm = document.getElementById('btn-submit-form');
const btnCancelEdit = document.getElementById('btn-cancel-edit');

function prepareEditFilm(film) {
    // Populate inputs
    inputIdFilm.value = film.id_film;
    inputJudul.value = film.judul;
    inputGenre.value = film.genre;
    inputDurasi.value = film.durasi_menit;

    // Change titles & actions
    formTitle.textContent = 'Ubah Detail Film';
    formTitle.style.color = '#38bdf8'; // Accent Cyan for Edit Mode
    filmForm.action = BASEURL + '/film/ubah';
    btnSubmitForm.className = 'btn btn-secondary';
    btnSubmitForm.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
    btnCancelEdit.style.display = 'inline-block';
    
    // Scroll to form panel smoothly on mobile
    document.getElementById('form-panel').scrollIntoView({ behavior: 'smooth' });
}

function resetFilmForm() {
    // Clear inputs
    inputIdFilm.value = '';
    inputJudul.value = '';
    inputGenre.value = '';
    inputDurasi.value = '';

    // Reset title & actions
    formTitle.textContent = 'Tambah Film Baru';
    formTitle.style.color = 'var(--primary)';
    filmForm.action = BASEURL + '/film/tambah';
    btnSubmitForm.className = 'btn btn-primary';
    btnSubmitForm.innerHTML = '<i class="fas fa-plus"></i> Tambah Film';
    btnCancelEdit.style.display = 'none';
}
