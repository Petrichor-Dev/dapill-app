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

                <div class="mb-3">
                  <label for="leader" class="form-label">Leader</label>
                  <select class="form-select" name="leader" id="leader" aria-label="Default select example">
                    <option selected>Pilih Leader</option>
                    @foreach ($leaders as $leader)
                      <option value="{{ $leader['id'] }}" @selected(old('leader') == $leader['name'])>
                          {{ $leader['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('leader')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="mayor" class="form-label">Mayor</label>
                  <select class="form-select" name="mayor" id="mayor" aria-label="Default select example">
                    <option selected>Pilih Mayor</option>
                    @foreach ($mayors as $mayor)
                      <option value="{{ $mayor['id'] }}" @selected(old('mayor') == $mayor['name'])>
                          {{ $mayor['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('mayor')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="kapten" class="form-label">Kapten</label>
                  <select class="form-select" name="kapten" id="kapten" aria-label="Default select example">
                    <option selected>Pilih Kapten</option>
                    @foreach ($kaptens as $kapten)
                      <option value="{{ $kapten['id'] }}" @selected(old('kapten') == $kapten['name'])>
                          {{ $kapten['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('kapten')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>
    </main>
@endsection
