<script>
const roleDescriptions = {
    superadmin : 'Akses penuh ke seluruh fitur dan data.',
    admin      : 'Akses hampir penuh, kecuali pengaturan role & sistem.',
    operator   : 'Dapat kelola data petani, lahan, panen, dan tanaman.',
    admin_desa : 'Hanya melihat dan membantu data dari wilayah yang ditentukan.',
    petani     : 'Hanya melihat dan mengubah data miliknya sendiri (terhubung ke akun anggota).',
    bumdes     : 'Hanya melihat dan mengubah data BUMDes yang terhubung.',
};

const roleSelect      = document.getElementById('roleSelect');
const panelWilayah    = document.getElementById('panelWilayah');
const panelPetani     = document.getElementById('panelPetani');
const panelBumdes     = document.getElementById('panelBumdes');
const roleInfo        = document.getElementById('roleInfo');
const kabupatenSelect = document.getElementById('kabupatenSelect');
const kecamatanSelect = document.getElementById('kecamatanSelect');
const desaSelect      = document.getElementById('desaSelect');

function togglePanels() {
    const role = roleSelect.value;
    panelWilayah.style.display  = role === 'admin_desa' ? '' : 'none';
    panelPetani.style.display   = role === 'petani'     ? '' : 'none';
    panelBumdes.style.display   = role === 'bumdes'     ? '' : 'none';
    if (roleDescriptions[role]) {
        roleInfo.style.display  = '';
        roleInfo.innerHTML = '<i class="fas fa-info-circle me-1"></i> ' + roleDescriptions[role];
    } else {
        roleInfo.style.display = 'none';
    }
}
roleSelect.addEventListener('change', togglePanels);
togglePanels();

// Wilayah API (for admin_desa)
const API = 'https://www.emsifa.com/api-wilayah-indonesia/api';

function resetSelect(sel, placeholder) {
    sel.innerHTML = `<option value="">${placeholder}</option>`;
    $(sel).trigger('change');
}

// Load kabupaten on page load if editing
@php
    $initProv = null; // We don't store provinsi, load from kabupaten's parent if needed
@endphp

// Load kecamatan when kabupaten is chosen
$(kabupatenSelect).on('change', function () {
    const kabId   = this.value;
    const kabText = this.options[this.selectedIndex]?.text ?? '';
    document.getElementById('kabupatenNama').value = kabId ? kabText : '';
    resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
    resetSelect(desaSelect, '-- Pilih Desa --');
    document.getElementById('kecamatanNama').value = '';
    document.getElementById('desaNama').value = '';

    if (!kabId) return;
    fetch(`${API}/districts/${kabId}.json`)
        .then(r => r.json())
        .then(data => {
            const selVal = @json(optional($user ?? null)?->wilayah_kecamatan_id);
            data.forEach(d => {
                const opt = new Option(d.name, d.id, false, d.id == selVal);
                kecamatanSelect.add(opt);
            });
            $(kecamatanSelect).trigger('change');
        });
});

$(kecamatanSelect).on('change', function () {
    const kecId   = this.value;
    const kecText = this.options[this.selectedIndex]?.text ?? '';
    document.getElementById('kecamatanNama').value = kecId ? kecText : '';
    resetSelect(desaSelect, '-- Pilih Desa --');
    document.getElementById('desaNama').value = '';

    if (!kecId) return;
    fetch(`${API}/villages/${kecId}.json`)
        .then(r => r.json())
        .then(data => {
            const selVal = @json(optional($user ?? null)?->wilayah_desa_id);
            data.forEach(d => {
                const opt = new Option(d.name, d.id, false, d.id == selVal);
                desaSelect.add(opt);
            });
            $(desaSelect).trigger('change');
        });
});

$(desaSelect).on('change', function () {
    const desaText = this.options[this.selectedIndex]?.text ?? '';
    document.getElementById('desaNama').value = this.value ? desaText : '';
});

// Load provinces, populate kabupaten dropdown
fetch(`${API}/regencies.json`)
    .catch(() => null); // pre-warm (optional)

// Actually load all regencies for the kabupaten select
fetch(`${API}/regencies.json`)
    .then(r => r.json())
    .then(data => {
        const selVal = @json(optional($user ?? null)?->wilayah_kabupaten_id);
        data.forEach(d => {
            const opt = new Option(d.name, d.id, false, d.id == selVal);
            kabupatenSelect.add(opt);
        });
        $(kabupatenSelect).trigger('change');
    });
</script>
