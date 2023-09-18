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
                        <h1 class="mt-4">Desa</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar Desa</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                @can('tambah-desa')
                                <a href="/tambah-desa">
                                    <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Desa</button>
                                </a>
                                @endcan
                            </div>
                            
                            @can('lihat-desa')
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Desa</th>
                                            <th>Major</th>
                                            <th>Jumlah TPS</th>
                                            <th>Asal Kecamatan</th>
                                            @can(['edit-desa', 'hapus-desa'])
                                                <th>Aksi</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Desa</th>
                                            <th>Major</th>
                                            <th>Jumlah TPS</th>
                                            <th>Asal Kecamatan</th>
                                            @can(['edit-desa', 'hapus-desa'])
                                                <th>Aksi</th>
                                            @endcan
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($desas as $key => $desa)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $desa['nama'] }}</td>
                                            <td>{{ $desa['mayor']['name'] }}</td>
                                            <td><b>{{ count($desa['tps']) }}</b></td>
                                            <td>{{ $desa['kecamatan']['nama'] }}</td>
                                            @can(['edit-desa', 'hapus-desa'])
                                            <td>
                                                @can('edit-desa')
                                                <a href="/edit-desa/{{ $desa['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary mt-1"><i class="fa-regular fa-pen-to-square"></i></button>
                                                </a>
                                                @endcan

                                                @can('hapus-desa')
                                                <a href="/desa/delete/{{ $desa['id'] }}">
                                                    <button type="button" class="btn btn-outline-danger mt-1"><i class="fa-regular fa-trash-can"></i></button>
                                                </a>
                                                @endcan
                                            </td>
                                            @endcan
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
