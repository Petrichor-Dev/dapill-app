@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data User</li>
            </ol>
            
            @can('tambah-user')
            <div class="mb-4">
              <form method="POST" action="/user/create">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input name="name" type="text" class="form-control" id="name">
                  @error('name')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="email" class="form-label">Email</label>
                  <input name="email" type="email" class="form-control" id="email">
                  @error('email')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input name="password" type="password" class="form-control" id="password">
                  @error('password')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" name="role" id="role" aria-label="Default select example">
                    <option selected>Pilih Role</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role['id'] }}" @selected(old('role') == $role['name'])>
                          {{ $role['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('role')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>  

                <div class="mt-4">
                  <a href="/user"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
