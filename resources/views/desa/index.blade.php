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
                                    <button class="btn btn-primary">Tambah Desa</button>
                                </a>
                                @endcan
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Desa</th>
                                            <th>Major</th>
                                            <th>Jumlah TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Desa</th>
                                            <th>Major</th>
                                            <th>Jumlah TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($desas as $key => $desa)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $desa['nama'] }}</td>
                                            <td>{{ $desa['ketua'] }}</td>
                                            <td>{{ $desa['jumlah_tps'] }}</td>
                                            <td>
                                                @can('edit-desa')
                                                <a href="/edit-desa/{{ $desa['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @endcan

                                                @can('hapus-desa')
                                                <a href="/desa/delete/{{ $desa['id'] }}">
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
