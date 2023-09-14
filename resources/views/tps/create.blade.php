@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">TPS</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data TPS</li>
            </ol>
            
            @can('tambah-tps')
            <div class="mb-4">
              <form method="POST" action="/tps/create">
                @csrf
                <div class="mb-3">
                  <label for="namaTps" class="form-label">Nama TPS</label>
                  <input type="text" name="namaTps" class="form-control" id="namaTps">
                  @error('namaTps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                @if($userRoleId !== 4)
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
                @endif
                
                <div class="mb-3">
                  <label for="desa" class="form-label">Desa</label>
                  <select class="form-select" name="desa" id="desa" aria-label="Default select example">
                    <option value="">
                      Pilih Desa
                    </option>
                  </select>
                  @error('desa')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-3">
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
                </div> --}}

                <div class="mt-4">
                  <a href="/tps"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
