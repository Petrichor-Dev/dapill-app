@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kecamatan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data Kecamatan</li>
            </ol>
            
            @can('edit-kecamatan')
            <form method="POST" action="/kecamatan/edit/{{ $kecamatan['id'] }}">
              @method('PUT')
              @csrf
                <div class="mb-3">
                  <label for="namaKecamatan" class="form-label">Nama Kecamatan</label>
                  <input value="{{ $kecamatan['nama'] }}" type="text" class="form-control" name="namaKecamatan" id="namaKecamatan">
                  @error('namaKecamatan')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="jendral" class="form-label">jendral</label>
                  <select class="form-select" name="jendral" id="jendral" aria-label="Default select example">
                    <option selected>Pilih jendral</option>
                    @foreach ($jendrals as $jendral)
                      <option value="{{ $jendral['id'] }}" @selected(old('jendral', $kecamatan['jendral_id']) == $jendral['id'])>
                          {{ $jendral['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('jendral')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-3">
                  <label for="jumlahDesa" class="form-label">Jumlah Desa</label>
                  <input value="{{ $kecamatan['jumlah_desa'] }}" type="number" class="form-control" name="jumlahDesa" id="jumlahDesa">
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
