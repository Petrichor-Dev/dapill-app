@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Role</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data Role</li>
            </ol>
            
            @can('tambah-role')
            <div class="mb-4">
              <form method="POST" action="/role/create">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input name="name" type="text" class="form-control" id="name">
                  @error('name')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="tps" class="form-label">Tentukan Hak Akses</label>
                    <div class="row">
                      @foreach ($permissions as $permission)
                      <div class="col-md-3 col-xs-6 mt-1">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission['name'] }}" id="{{ $permission['name'] }}">
                          <label class="form-check-label" for="{{ $permission['name'] }}">
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
                <div class="mt-4">
                  <a href="/role"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
