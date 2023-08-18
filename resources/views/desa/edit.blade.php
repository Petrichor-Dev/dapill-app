@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Desa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data Desa</li>
            </ol>
            
            @can('edit-desa')
            <div class="mb-4">
              <form method="POST" action="/desa/edit/{{ $desa['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="namaDesa" class="form-label">Nama Desa</label>
                  <input value="{{ $desa['nama'] }}" type="text" name="namaDesa" class="form-control" id="namaDesa">
                </div>

                <div class="mb-3">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                      {{-- <option value="" selected>Pilih Kecamatan</option> --}}
                      @foreach ($kecamatans as $kecamatan)
                          <option value="{{ $kecamatan['id'] }}" @if(old('kecamatan', $desa['kecamatan_id']) == $kecamatan['id']) selected @endif>
                              {{ $kecamatan['nama'] }}
                          </option>
                      @endforeach
                  </select>
              </div>
              
              <div class="mb-3">
                <label for="mayor" class="form-label">mayor</label>
                <select class="form-select" name="mayor" id="mayor" aria-label="Default select example">
                  <option selected>Pilih mayor</option>
                  @foreach ($mayors as $mayor)
                    <option value="{{ $mayor['id'] }}" @selected(old('mayor', $desa['mayor_id']) == $mayor['id'])>
                        {{ $mayor['name'] }}
                    </option>
                  @endforeach
                </select>
                @error('mayor')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
              </div>

                <div class="mb-4">
                  <label for="jumlahTps" class="form-label">Jumlah Tps</label>
                  <input value="{{ $desa['jumlah_tps'] }}" type="number" name="jumlahTps" class="form-control" id="jumlahTps">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
