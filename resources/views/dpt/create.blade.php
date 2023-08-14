@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">DPT</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data DPT</li>
            </ol>
            
            <div class="mb-4">
              <form method="POST" action="/dpt/create">
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input name="nama" type="text" class="form-control" id="nama">
                  @error('nama')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="NIK" class="form-label">NIK</label>
                  <input name="nik" type="number" class="form-control" id="NIK">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                    <option selected>Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                      <option value="{{ $kecamatan['id'] }}" @selected(old('kecamatan') == $kecamatan['nama'])>
                          {{ $kecamatan['nama'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('kecamatan')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="mb-3">
                  <label for="desa" class="form-label">Desa</label>
                  <select class="form-select" name="desa" id="desa" aria-label="Default select example">
                    <option selected>Pilih Desa</option>
                    @foreach ($desas as $desa)
                      <option value="{{ $desa['id'] }}" @selected(old('desa') == $desa['nama'])>
                          {{ $desa['nama'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('desa')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="tps" class="form-label">TPS</label>
                  <select class="form-select" name="tps" id="tps" aria-label="Default select example">
                    <option selected>Pilih TPS</option>
                    @foreach ($tpss as $tps)
                    <option value="{{ $tps['id'] }}" @selected(old('tps') == $tps['nama'])>
                        {{ $tps['nama'] }}
                    </option>
                  @endforeach
                  </select>
                  @error('tps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>
    </main>
@endsection
