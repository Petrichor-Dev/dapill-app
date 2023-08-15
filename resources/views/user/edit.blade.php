@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data User</li>
            </ol>
            
            <div class="mb-4">
              <form method="POST" action="/user/edit/{{ $user['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input name="name" type="text" class="form-control" id="name" value="{{ $user['name'] }}">
                  @error('name')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="email" class="form-label">Email</label>
                  <input name="email" type="email" class="form-control" id="email" value="{{ $user['email'] }}">
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

                {{-- @dd($user['roles']) --}}
                @dd(array_column($user['roles'], 'id'))
                <div class="mb-3">
                  <label for="role" class="form-label">Pilih Role</label>
                  <select class="form-select" name="role" id="role" aria-label="Default select example">
                    
                    @foreach ($roles as $role)
                      {{-- <option value="{{ $role['id'] }}" @if(old('role', (array_column($user['roles'], 'name') === $role['name']))) selected @endif>
                          {{ $role['name'] }}
                      </option> --}}
                      <option value="" {{ in_array($role['name'], array_column($user['roles'], 'name')) ? 'checked' : '' }}>
                        {{ $role['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('role')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>
    </main>
@endsection
