{{--
  Komponen Wilayah Indonesia via REST API emsifa
  Props:
    $prefix  = prefix nama field, misal 'ktp' -> field: provinsi_id_ktp, desa_ktp, dll
    $data    = object/array dengan nilai terpilih (untuk edit)
    $label   = label prefix teks (opsional)
--}}
@props(['prefix' => '', 'data' => null, 'label' => ''])

@php
$sfx = $prefix ? '_'.$prefix : '';   // suffix field name
$pid  = 'provinsi_id'.$sfx;
$pnm  = 'provinsi'.$sfx;
$kid  = 'kabupaten_id'.$sfx;
$knm  = 'kabupaten'.$sfx;
$cid  = 'kecamatan_id'.$sfx;
$cnm  = 'kecamatan'.$sfx;
$did  = 'desa_id'.$sfx;
$dnm  = 'desa'.$sfx;

$uid = str_replace('_','-', $prefix ?: 'wil');
@endphp

<div class="row">
    <div class="col-md-6 mb-2">
        <label class="font-weight-bold">Provinsi {{ $label }}</label>
        <select name="{{ $pid }}" id="prov-{{ $uid }}" class="form-control wilayah-provinsi" data-uid="{{ $uid }}"
                data-selected="{{ $data ? ($data[$pid] ?? $data->{'provinsi_id'.$sfx} ?? '') : '' }}">
            <option value="">-- Pilih Provinsi --</option>
        </select>
        <input type="hidden" name="{{ $pnm }}" id="prov-nama-{{ $uid }}"
               value="{{ $data ? ($data[$pnm] ?? $data->{$pnm} ?? '') : '' }}">
    </div>
    <div class="col-md-6 mb-2">
        <label class="font-weight-bold">Kabupaten/Kota {{ $label }}</label>
        <select name="{{ $kid }}" id="kab-{{ $uid }}" class="form-control wilayah-kabupaten" data-uid="{{ $uid }}"
                data-selected="{{ $data ? ($data[$kid] ?? $data->{'kabupaten_id'.$sfx} ?? '') : '' }}">
            <option value="">-- Pilih Kabupaten --</option>
        </select>
        <input type="hidden" name="{{ $knm }}" id="kab-nama-{{ $uid }}"
               value="{{ $data ? ($data[$knm] ?? $data->{$knm} ?? '') : '' }}">
    </div>
    <div class="col-md-6 mb-2">
        <label class="font-weight-bold">Kecamatan {{ $label }}</label>
        <select name="{{ $cid }}" id="kec-{{ $uid }}" class="form-control wilayah-kecamatan" data-uid="{{ $uid }}"
                data-selected="{{ $data ? ($data[$cid] ?? $data->{'kecamatan_id'.$sfx} ?? '') : '' }}">
            <option value="">-- Pilih Kecamatan --</option>
        </select>
        <input type="hidden" name="{{ $cnm }}" id="kec-nama-{{ $uid }}"
               value="{{ $data ? ($data[$cnm] ?? $data->{$cnm} ?? '') : '' }}">
    </div>
    <div class="col-md-6 mb-2">
        <label class="font-weight-bold">Desa/Kelurahan {{ $label }}</label>
        <select name="{{ $did }}" id="des-{{ $uid }}" class="form-control wilayah-desa" data-uid="{{ $uid }}"
                data-selected="{{ $data ? ($data[$did] ?? $data->{'desa_id'.$sfx} ?? '') : '' }}">
            <option value="">-- Pilih Desa --</option>
        </select>
        <input type="hidden" name="{{ $dnm }}" id="des-nama-{{ $uid }}"
               value="{{ $data ? ($data[$dnm] ?? $data->{$dnm} ?? '') : '' }}">
    </div>
</div>
