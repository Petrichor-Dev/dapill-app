@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
          @if (session()->has('danger'))
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ session('danger') }}
                        </div>
                        @endif
            <h1 class="mt-4">Leader</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data Leader</li>
            </ol>
            
            @can('edit-leader')
            <div class="mb-4">
              <form method="POST" action="/leader/edit/{{ $leader['id'] }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input name="name" type="text" class="form-control" id="name" value="{{ $leader['name'] }}">
                  @error('name')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mt-4">
                  <a href="/leader"><button type="button" class="btn btn-outline-primary">Batal</button></a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
