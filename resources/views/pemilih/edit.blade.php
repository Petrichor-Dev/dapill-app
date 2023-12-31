@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Pemilih</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data Pemilih</li>
            </ol>
            
            @can('edit-pemilih')
            <div class="mb-4">
              <form method="POST" action="/pemilih/edit/{{ $pemilih['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input value="{{ $pemilih['nama'] }}" name="nama" type="text" class="form-control" id="nama">
                  @error('nama')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                {{-- <div class="mb-4">
                  <label for="NIK" class="form-label">NIK</label>
                  <input value="{{ $pemilih['nik'] }}" name="nik" type="number" class="form-control" id="NIK">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div> --}}

                <div class="mb-3">
                  <label for="kecamatan" class="form-label">Kecamatan</label>
                  <select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
                    @foreach ($kecamatans as $kecamatan)
                      <option value="{{ $kecamatan['id'] }}" @if(old('kecamatan', $pemilih['kecamatan_id']) == $kecamatan['id']) selected @endif>
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
                      <option value="{{ $desa['id'] }}" @if(old('desa', $pemilih['desa_id']) == $desa['id']) selected @endif>
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
                      <option value="{{ $tps['id'] }}" @if(old('tps', $pemilih['tps_id']) == $tps['id']) selected @endif>
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
                      <option value="{{ $leader['id'] }}" @selected(old('leader', $pemilih['leader_id']) == $leader['id'])>
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
                      <option value="{{ $mayor['id'] }}" @selected(old('mayor', $pemilih['mayor_id']) == $mayor['id'])>
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
                      <option value="{{ $kapten['id'] }}" @selected(old('kapten', $pemilih['kapten_id']) == $kapten['id'])>
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
                      <option value="Pilih Status" {{ $pemilih['status_memilih'] == 'Pilih Status' ? 'selected' : '' }}>Pilih Status</option>
                      <option value="Ragu-Ragu" {{ $pemilih['status_memilih'] == 'Ragu-Ragu' ? 'selected' : '' }}>Ragu Ragu</option>
                      <option value="Memilih" {{ $pemilih['status_memilih'] == 'Memilih' ? 'selected' : '' }}>Memilih</option>
                      <option value="Tidak-Memilih" {{ $pemilih['status_memilih'] == 'Tidak-Memilih' ? 'selected' : '' }}>Tidak Memilih</option>
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
