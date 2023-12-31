
@php
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('layout.main')

    @section('body')
                <main>
                    <div class="container-fluid px-4">
                        @if (session()->has('success'))
                        <div class="alert alert-primary mt-4" role="alert">
                           <b>{{ session('success') }}</b>
                        </div>
                        @endif
                        <h1 class="mt-4">User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar User</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                @can('tambah-user')
                                <a href="/tambah-user">
                                    <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah User</button>
                                </a>
                                @endcan
                            </div>
                            
                            @can('lihat-dpt')
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama User</th>
                                            <th>Email</th>
                                            @if ($roleName['jabatan_id'] === 2)
                                                <th>Password</th>
                                            @endif
                                            <th>Roles</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama User</th>
                                            <th>Email</th>
                                            @if ($roleName['jabatan_id'] === 2)
                                                <th>Password</th>
                                            @endif
                                            <th>Roles</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $user['name'] }}</td>
                                            <td>
                                                {{ $user['email'] }}
                                            </td>
                                            @if ($roleName['jabatan_id'] === 2)
                                                <td>{{ $user['show_password'] }}</td>
                                            @endif
                                            <td>{{ $user['jabatan']['name'] }}</td>
                                            <td>
                                                @can('edit-user')
                                                <a href="/edit-user/{{ $user['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary mt-1"><i class="fa-regular fa-pen-to-square"></i></button>
                                                </a>
                                                @endcan
                                                
                                                @can('hapus-user')
                                                <form class="d-inline" action="/user/delete/{{ $user['id'] }}" method="post">
                                                    @method('delete')
                                                    @csrf
            
                                                    <button  class="btn btn-outline-danger mt-1" onclick="return confirm('Yakin Hapus Data ?')">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                                @endcan
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
