@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Desa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data Desa</li>
            </ol>
            
            @can('tambah-desa')
            <div class="mb-4">
              <form method="POST" action="/desa/create">
                @csrf
                <div class="mb-3">
                  <label for="namaDesa" class="form-label">Nama Desa</label>
                  <input type="text" name="namaDesa" class="form-control" id="namaDesa">
                  @error('namaDesa')
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
                      {{-- </option> --}}
                    @endforeach
                  </select>
                  @error('kecamatan')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="mb-3">
                  <label for="mayor" class="form-label">mayor</label>
                  <select class="form-select" name="mayor" id="mayor" aria-label="Default select example">
                    <option selected>Pilih mayor</option>
                    @foreach ($mayors as $mayor)
                      <option value="{{ $mayor['id'] }}" @selected(old('mayor') == $mayor['name'])>
                          {{ $mayor['name'] }}
                    @endforeach
                  </select>
                  @error('mayor')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-4">
                  <label for="jumlahTps" class="form-label">Jumlah Tps</label>
                  <input type="number" name="jumlahTps" class="form-control" id="jumlahTps">
                  @error('jumlahTps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}
                <div class="mt-4">
                  <a href="/desa"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
