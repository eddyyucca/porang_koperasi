{{-- Script wilayah Indonesia – include sekali di @push('scripts') halaman --}}
<script>
(function(){
    const API = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    function setHidden(id, val) {
        const el = document.getElementById(id);
        if (el) el.value = val;
    }

    function populateSelect(sel, items, valKey, lblKey, selectedVal) {
        sel.innerHTML = '<option value="">-- Pilih --</option>';
        items.forEach(function(item) {
            const opt = document.createElement('option');
            opt.value = item[valKey];
            opt.textContent = item[lblKey];
            if (String(item[valKey]) === String(selectedVal)) opt.selected = true;
            sel.appendChild(opt);
        });
        $(sel).trigger('change.select2');
    }

    function initWilayah(uid) {
        const provSel = document.getElementById('prov-' + uid);
        const kabSel  = document.getElementById('kab-'  + uid);
        const kecSel  = document.getElementById('kec-'  + uid);
        const desSel  = document.getElementById('des-'  + uid);
        if (!provSel) return;

        const selProv = provSel.dataset.selected || '';
        const selKab  = kabSel  ? kabSel.dataset.selected  || '' : '';
        const selKec  = kecSel  ? kecSel.dataset.selected  || '' : '';
        const selDes  = desSel  ? desSel.dataset.selected  || '' : '';

        // Load Provinsi
        fetch(API + '/provinces.json')
            .then(r => r.json())
            .then(function(data) {
                populateSelect(provSel, data, 'id', 'name', selProv);
                if (selProv) loadKabupaten(uid, selProv, selKab, selKec, selDes);
            })
            .catch(function() {
                console.warn('Gagal memuat data provinsi. Cek koneksi internet.');
            });

        // Event: ganti provinsi
        provSel.addEventListener('change', function() {
            const nama = this.options[this.selectedIndex]?.text || '';
            setHidden('prov-nama-' + uid, this.value ? nama : '');
            if (kabSel) { kabSel.innerHTML = '<option value="">-- Pilih Kabupaten --</option>'; }
            if (kecSel) { kecSel.innerHTML = '<option value="">-- Pilih Kecamatan --</option>'; }
            if (desSel) { desSel.innerHTML = '<option value="">-- Pilih Desa --</option>'; }
            setHidden('kab-nama-' + uid, '');
            setHidden('kec-nama-' + uid, '');
            setHidden('des-nama-' + uid, '');
            if (this.value) loadKabupaten(uid, this.value, '', '', '');
        });
    }

    function loadKabupaten(uid, provId, selKab, selKec, selDes) {
        const kabSel = document.getElementById('kab-' + uid);
        if (!kabSel) return;
        fetch(API + '/regencies/' + provId + '.json')
            .then(r => r.json())
            .then(function(data) {
                populateSelect(kabSel, data, 'id', 'name', selKab);
                if (selKab) loadKecamatan(uid, selKab, selKec, selDes);
            });

        kabSel.addEventListener('change', function() {
            const nama = this.options[this.selectedIndex]?.text || '';
            setHidden('kab-nama-' + uid, this.value ? nama : '');
            const kecSel = document.getElementById('kec-' + uid);
            const desSel = document.getElementById('des-' + uid);
            if (kecSel) kecSel.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            if (desSel) desSel.innerHTML = '<option value="">-- Pilih Desa --</option>';
            setHidden('kec-nama-' + uid, '');
            setHidden('des-nama-' + uid, '');
            if (this.value) loadKecamatan(uid, this.value, '', '');
        }, { once: false });
    }

    function loadKecamatan(uid, kabId, selKec, selDes) {
        const kecSel = document.getElementById('kec-' + uid);
        if (!kecSel) return;
        fetch(API + '/districts/' + kabId + '.json')
            .then(r => r.json())
            .then(function(data) {
                populateSelect(kecSel, data, 'id', 'name', selKec);
                if (selKec) loadDesa(uid, selKec, selDes);
            });

        kecSel.addEventListener('change', function() {
            const nama = this.options[this.selectedIndex]?.text || '';
            setHidden('kec-nama-' + uid, this.value ? nama : '');
            const desSel = document.getElementById('des-' + uid);
            if (desSel) desSel.innerHTML = '<option value="">-- Pilih Desa --</option>';
            setHidden('des-nama-' + uid, '');
            if (this.value) loadDesa(uid, this.value, '');
        }, { once: false });
    }

    function loadDesa(uid, kecId, selDes) {
        const desSel = document.getElementById('des-' + uid);
        if (!desSel) return;
        fetch(API + '/villages/' + kecId + '.json')
            .then(r => r.json())
            .then(function(data) {
                populateSelect(desSel, data, 'id', 'name', selDes);
            });

        desSel.addEventListener('change', function() {
            const nama = this.options[this.selectedIndex]?.text || '';
            setHidden('des-nama-' + uid, this.value ? nama : '');
        }, { once: false });
    }

    // Init semua komponen wilayah di halaman
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wilayah-provinsi').forEach(function(el) {
            initWilayah(el.dataset.uid);
        });
    });
})();
</script>
