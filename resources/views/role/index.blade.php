
@php
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('layout.main')

    @section('body')
                <main>
                    <div class="container-fluid px-4">
                        @if (session()->has('success'))
                        <div class="alert alert-primary mt-4" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <h1 class="mt-4">Role</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar Role</li>
                        </ol>
                        <div class="card mb-4">
                            {{-- <div class="card-header">   
                                @can('tambah-role')
                                <a href="/tambah-role">
                                    <button class="btn btn-primary">Tambah Role</button>
                                </a>
                                @endcan
                            </div> --}}
                            
                            @can('lihat-role')
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($roles->resource as $key => $role)
                                        
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{$role['name'] }}</td>
                                            <td>
                                                @can('edit-role')
                                                <a href="/edit-role/{{$role['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                                                </a>
                                                @endcan
                                                {{-- @can('hapus-role')
                                                <a href="/role/delete/{{$role['id'] }}">
                                                    <button type="button" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                                                </a>
                                                @endcan --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endcan
                        </div>
                    </div>
                </main>
    @endsection
