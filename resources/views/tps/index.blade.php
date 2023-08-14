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
                        <h1 class="mt-4">TPS</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar TPS</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                {{-- <i class="fas fa-table"></i>
                                DataTable Exampel --}}
                                {{-- <div class="d-flex justify-content-end"> --}}
                                    <a href="/tambah-tps">
                                        <button class="btn btn-primary">Tambah TPS</button>
                                    </a>
                                {{-- </div> --}}
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama TPS</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Prajurit</th>
                                            <th>Alamat TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama TPS</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Prajurit</th>
                                            <th>Alamat TPS</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($tpss as $tps)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $tps['nama'] }}</td>
                                            <td>{{ $tps['jumlah_pemilih'] }} orang</td>
                                            <td>{{ $tps['ketua'] }}</td>
                                            <td>Desa {{ $tps['namaDesa'] }}, kecamatan {{ $tps['namaKecamatan'] }}</td>
                                            <td>
                                                <a href="/edit-tps/{{ $tps['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @if (Auth::user()->id == 1)
                                                    <a href="/tps/delete/{{ $tps['id'] }}">
                                                    <button type="button" class="btn btn-outline-danger">Hapus</button>
                                                </a>
                                                @endif
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
