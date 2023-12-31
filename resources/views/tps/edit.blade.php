@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">TPS</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data TPS</li>
            </ol>
            
            @can('edit-tps')
            <div class="mb-4">
              <form method="POST" action="/tps/edit/{{ $tps['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="namaTps" class="form-label">Nama TPS</label>
                  <input value="{{ $tps['nama'] }}" name="namaTps" type="text" class="form-control" id="namaTps">
                  {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                </div>

                @if ($userRoleId !== 4)
                  <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                      @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan['id'] }}" @if(old('kecamatan', $tps['kecamatan_id']) == $kecamatan['id']) selected @endif>
                                {{ $kecamatan['nama'] }}
                            </option>
                        @endforeach
                    </select>
                  </div>
                @endif
                
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
                            <option value="{{ $desa['id'] }}" @if(old('desa', $tps['desa_id']) == $desa['id']) selected @endif>
                                {{ $desa['nama'] }}
                            </option>
                        @endforeach
                    </select>
                  </div>

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
