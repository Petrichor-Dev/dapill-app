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
              
            <h1 class="mt-4">Dapil 1</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Daftar Kecamatan</li>
            </ol>
            
            <div class="card mb-4">
                <div class="card-header">   
                    @can('tambah-kecamatan')
                    <a href="/tambah-kecamatan">
                        <button class="btn btn-primary">Tambah Kecamatan</button>
                    </a>
                    @endcan
                </div>
                
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th>Ketua</th>
                                <th>Jumlah Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Ketua</th>
                                <th>Jumlah Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($kecamatans as $key => $kecamatan)
                            <tr>
                                <td>{{ $key+1 }}</td> 
                                <td>{{ $kecamatan['nama'] }}</td>
                                <td>{{ $kecamatan['ketua'] }}</td>
                                <td>{{ $kecamatan['jumlah_desa'] }}</td>
                                <td>
                                    @can('edit-kecamatan')
                                    <a href="/edit-kecamatan/{{ $kecamatan['id'] }}">
                                        <button type="button" class="btn btn-outline-primary">Edit</button>
                                    </a>
                                    @endcan
                                    
                                    @can('hapus-kecamatan')
                                    <a href="/kecamatan/delete/{{ $kecamatan['id'] }}">
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
