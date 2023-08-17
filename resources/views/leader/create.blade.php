@extends('layout.main')
@section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Leader</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Data Leader</li>
            </ol>
            
            @can('tambah-leader')
            <div class="mb-4">
              <form method="POST" action="/leader/create">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input name="name" type="text" class="form-control" id="name">
                  @error('name')
                      <div class="form-text text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
            @endcan
        </div>
    </main>
@endsection
