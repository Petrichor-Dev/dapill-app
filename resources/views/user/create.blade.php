@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data User</li>
            </ol>
            
            <div class="mb-4">
              <form method="POST" action="/user/create">
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input name="nama" type="text" class="form-control" id="nama">
                  @error('nama')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="NIK" class="form-label">Email</label>
                  <input name="nik" type="email" class="form-control" id="NIK">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="NIK" class="form-label">Password</label>
                  <input name="nik" type="password" class="form-control" id="NIK">
                  @error('nik')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="tps" class="form-label">Tentukan Hak Akses</label>
                    <div class="row">
                      @foreach ($permissions as $permission)
                      <div class="col-md-3 col-xs-6 mt-1">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="module[]" value="{{ $permission['name'] }}" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            {{ $permission['name'] }}
                          </label>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  
                  @error('tps')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>  
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>
    </main>
@endsection
