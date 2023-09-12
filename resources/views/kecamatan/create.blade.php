@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kecamatan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data Kecamatan</li>
            </ol>
            
            @can('tambah-kecamatan')
            <form method="POST" action="/kecamatan/create">
              @csrf
                <div class="mb-3">
                  <label for="namaKecamatan" class="form-label">Nama Kecamatan</label>
                  <input type="text" class="form-control" name="namaKecamatan" id="namaKecamatan">
                  @error('namaKecamatan')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="jendral" class="form-label">jendral</label>
                  <select class="form-select" name="jendral" id="jendral" aria-label="Default select example">
                    <option selected>Pilih jendral</option>
                    @foreach ($jendrals as $jendral)
                      <option value="{{ $jendral['id'] }}" @selected(old('jendral') == $jendral['name'])>
                          {{ $jendral['name'] }}                    @endforeach
                  </select>
                  @error('jendral')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-3">
                  <label for="jumlahDesa" class="form-label">Jumlah Desa</label>
                  <input type="number" class="form-control" name="jumlahDesa" id="jumlahDesa">
                  @error('jumlahDesa')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}
                <div class="mt-4">
                  <a href="/kecamatan"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @endcan
        </div>
    </main>
@endsection
