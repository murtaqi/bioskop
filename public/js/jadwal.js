const jadwalForm = document.getElementById('jadwal-form');
const formTitle = document.getElementById('form-title');
const inputIdJadwal = document.getElementById('input-id-jadwal');
const inputFilm = document.getElementById('input-film');
const inputTanggal = document.getElementById('input-tanggal');
const inputJam = document.getElementById('input-jam');
const inputHarga = document.getElementById('input-harga');
const btnSubmitForm = document.getElementById('btn-submit-form');
const btnCancelEdit = document.getElementById('btn-cancel-edit');

function prepareEditJadwal(jadwal) {
    if (!jadwalForm) return;
    
    // Populate inputs
    inputIdJadwal.value = jadwal.id_jadwal;
    inputFilm.value = jadwal.id_film;
    inputTanggal.value = jadwal.tanggal_tayang;
    
    // Format jam_tayang to fit input time value (HH:MM)
    const timeVal = jadwal.jam_tayang.substring(0, 5);
    inputJam.value = timeVal;
    
    inputHarga.value = jadwal.harga_tiket;

    // Change titles & actions
    formTitle.textContent = 'Ubah Jadwal Tayang';
    formTitle.style.color = '#38bdf8'; // Accent Cyan for Edit Mode
    jadwalForm.action = BASEURL + '/jadwal/ubah';
    btnSubmitForm.className = 'btn btn-secondary';
    btnSubmitForm.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
    btnCancelEdit.style.display = 'inline-block';
    
    // Scroll to form panel smoothly on mobile
    document.getElementById('form-panel').scrollIntoView({ behavior: 'smooth' });
}

function resetJadwalForm() {
    if (!jadwalForm) return;
    
    // Clear inputs
    inputIdJadwal.value = '';
    inputFilm.value = '';
    inputTanggal.value = '';
    inputJam.value = '';
    inputHarga.value = '';

    // Reset title & actions
    formTitle.textContent = 'Tambah Jadwal Baru';
    formTitle.style.color = 'var(--primary)';
    jadwalForm.action = BASEURL + '/jadwal/tambah';
    btnSubmitForm.className = 'btn btn-primary';
    btnSubmitForm.innerHTML = '<i class="fas fa-plus"></i> Tambah Jadwal';
    btnCancelEdit.style.display = 'none';
}
