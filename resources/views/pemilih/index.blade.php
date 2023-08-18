
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
                        <h1 class="mt-4">Pemilih</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar Pemilih</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                @can('tambah-pemilih')
                                <a href="/tambah-pemilih">
                                    <button class="btn btn-primary">Tambah Pemilih</button>
                                </a>
                                @endcan
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Leader</th>
                                            <th>Kapten</th>
                                            <th>Mayor</th>
                                            <th>Nama TPS</th>
                                            <th>Status Memilih</th>
                                            <th>Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Leader</th>
                                            <th>Kapten</th>
                                            <th>Mayor</th>
                                            <th>Nama TPS</th>
                                            <th>Status Memilih</th>
                                            <th>Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($pemilihs as $key => $pemilih)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $pemilih['nama'] }}</td>
                                            <td>{{ $pemilih['leader']['name'] }}</td>
                                            <td>{{ $pemilih['kapten']['name'] }}</td>
                                            <td>{{ $pemilih['mayor']['name'] }}</td>
                                            <td>{{ $pemilih['namaTps'] }}</td>
                                            <td>
                                                @switch($pemilih['status_memilih'])
                                                    @case('Ragu-Ragu')
                                                        <span class="badge text-bg-warning">{{ $pemilih['status_memilih'] }}</span>
                                                        @break

                                                    @case('Memilih')
                                                        <span class="badge text-bg-success">{{ $pemilih['status_memilih'] }}</span>
                                                        @break

                                                    @case('Tidak-Memilih')
                                                        <span class="badge text-bg-danger">{{ $pemilih['status_memilih'] }}</span>
                                                        @break

                                                
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                            <td>{{ $pemilih['user_admin']['name'] }}</td>
                                            <td>
                                                @can('edit-pemilih')
                                                <a href="/edit-pemilih/{{ $pemilih['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @endcan
                                                @can('hapus-pemilih')
                                                <a href="/pemilih/delete/{{ $pemilih['id'] }}">
                                                    <button type="button" class="btn btn-outline-danger">Hapus</button>
                                                </a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
    @endsection
