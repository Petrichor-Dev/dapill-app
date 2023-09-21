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
                        <h1 class="mt-4">TPS</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar TPS</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                @can('tambah-tps')
                                    <a href="/tambah-tps">
                                        <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah TPS</button>
                                    </a>
                                    @endcan
                            </div>
                            
                            @can('lihat-tps')
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama TPS</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Kapten</th>
                                            <th>Alamat TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama TPS</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Kapten</th>
                                            <th>Alamat TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($tpss as $key => $tps)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $tps['nama'] }}</td>
                                            <td>{{ count($tps['pemilih']) }} orang</td>
                                            <td>{{ $tps['ketua'] }}</td>
                                            <td>Desa {{ $tps['namaDesa'] }}, kecamatan {{ $tps['namaKecamatan'] }}</td>
                                            <td>
                                                @can('edit-tps')
                                                <a href="/edit-tps/{{ $tps['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary mt-1"><i class="fa-regular fa-pen-to-square"></i></button>
                                                </a>
                                                @endcan
                                                
                                                @can('hapus-tps')
                                                <form class="d-inline" action="/tps/delete/{{ $tps['id'] }}" method="post">
                                                    @method('delete')
                                                    @csrf
            
                                                    <button  class="btn btn-outline-danger mt-1" onclick="return confirm('Yakin Hapus Data ?')">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                                <a href="/tps/download/{{ $tps['id'] }}">
                                                    <button type="button" class="btn btn-outline-success mt-1"><i class="fa-solid fa-download"></i></button>
                                                </a>
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
