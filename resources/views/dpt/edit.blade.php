@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">DPT</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data DPT</li>
            </ol>
            {{-- @dd($dpt['id']) --}}
            @can('edit-dpt')
            <div class="mb-4">
              <form method="POST" action="/dpt/edit/{{ $dpt['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input value="{{ $dpt['nama'] }}" name="nama" type="text" class="form-control" id="nama">
                  @error('nama')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-4">
                  <label for="NIK" class="form-label">NIK</label>
                  <input value="{{ $dpt['nik'] }}" name="nik" type="number" class="form-control" id="NIK">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}

                <div class="mb-3">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                    @foreach ($kecamatans as $kecamatan)
                      <option value="{{ $kecamatan['id'] }}" @if(old('kecamatan', $dpt['kecamatan_id']) == $kecamatan['id']) selected @endif>
                          {{ $kecamatan['nama'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('kecamatan')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
                
                {{-- <div class="mb-3">
                  <label for="desa" class="form-label">Desa</label>
                  <select class="form-select" name="desa" id="desa" aria-label="Default select example">
                    <option value="">
                      Pilih Desa
                    </option>
                  </select>
                  @error('desa')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}

                <div class="mb-3">
                  <label for="desa" class="form-label">Desa</label>
                  <select class="form-select" name="desa" id="desa" aria-label="Default select example">
                    @foreach ($desas as $desa)
                      <option value="{{ $desa['id'] }}" @if(old('desa', $dpt['desa_id']) == $desa['id']) selected @endif>
                          {{ $desa['nama'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('desa')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-3">
                  <label for="tps" class="form-label">TPS</label>
                  <select class="form-select" name="tps" id="tps" aria-label="Default select example">
                    <option value="">
                      Pilih TPS
                    </option>
                  </select>
                  @error('tps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}
                
                <div class="mb-3">
                  <label for="tps" class="form-label">TPS</label>
                  <select class="form-select" name="tps" id="tps" aria-label="Default select example">
                    @foreach ($tpss as $tps)
                      <option value="{{ $tps['id'] }}" @if(old('tps', $dpt['tps_id']) == $tps['id']) selected @endif>
                          {{ $tps['nama'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('tps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>
              
                <div class="mt-4">
                  <a href="/dpt"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
