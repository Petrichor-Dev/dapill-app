@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Pemilih</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data Pemilih</li>
            </ol>
            
            @can('tambah-pemilih')
            <div class="mb-4">
              <form method="POST" action="/pemilih/create">
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input name="nama" type="text" class="form-control" id="nama" value="{{ old('nama') }}">
                  @error('nama')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-4">
                  <label for="NIK" class="form-label">NIK</label>
                  <input name="nik" type="number" class="form-control" id="NIK" value="{{ old('nik') }}">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}

                <div class="mb-3">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                    <option selected>Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                    {{-- @selected(old('kecamatan')) --}}
                      <option value="{{ $kecamatan['id'] }}" >
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
                    {{-- @selected(old('desa')) --}}
                      <option value="{{ $desa['id'] }}" >
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
                    {{-- @selected(old('tps')) --}}
                    <option value="{{ $tps['id'] }}" >
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
                      {{-- @selected(old('leader')) --}}
                      <option value="{{ $leader['id'] }}" >
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
                    {{-- @selected(old('mayor')) --}}
                      <option value="{{ $mayor['id'] }}" >
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
                    {{-- @selected(old('kapten')) --}}
                      <option value="{{ $kapten['id'] }}" >
                          {{ $kapten['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('kapten')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="statusMemilih" class="form-label">Status Memilih</label>
                  <select class="form-select" name="statusMemilih" id="statusMemilih" aria-label="Default select example">
                    <option selected>Pilih Status</option>
                    @foreach ($statusMemilih as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                  </select>
                  @error('statusMemilih')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mt-4">
                  <a href="/pemilih"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
