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
                        <h1 class="mt-4">DPT</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar DPT</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                @if ($dpts !== [])
                                @can('lihat-dpt')
                                <a href="/dpt/export">
                                    <button class="btn btn-success">Eksport Data</button>
                                </a>
                                @endcan
                                @endif  
                                @can('tambah-dpt')
                                <a href="/tambah-dpt">
                                    <button class="btn btn-primary">Tambah DPT</button>
                                </a>
                                @endcan
                            </div>
                            
                            @can('lihat-dpt')
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
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
                                            <th>Nama TPS</th>
                                            <th>Status Memilih</th>
                                            <th>Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($dpts as $key => $dpt)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $dpt['nama'] }}</td>
                                            <td>{{ $dpt['namaTps'] }}</td>
                                            <td>
                                                -
                                            </td>
                                            <td>{{ $dpt['admin']['name'] }}</td>
                                            <td>
                                                @can('edit-dpt')
                                                <a href="/edit-dpt/{{ $dpt['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @endcan
                                                
                                                @can('hapus-dpt')
                                                <a href="/dpt/delete/{{ $dpt['id'] }}">
                                                    <button type="button" class="btn btn-outline-danger">Hapus</button>
                                                </a>
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
