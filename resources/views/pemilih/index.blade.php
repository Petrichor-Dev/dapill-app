
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
                                {{-- <i class="fas fa-table"></i>
                                DataTable Exampel --}}
                                {{-- <div class="d-flex justify-content-end"> --}}
                                    <a href="/tambah-pemilih">
                                        <button class="btn btn-primary">Tambah Pemilih</button>
                                    </a>
                                {{-- </div> --}}
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
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
                                            <th>NIK</th>
                                            <th>Nama TPS</th>
                                            <th>Status Memilih</th>
                                            <th>Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($pemilihs as $pemilih)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $pemilih['nama'] }}</td>
                                            <td>{{ $pemilih['nik'] }}</td>
                                            <td>{{ $pemilih['namaTps'] }}</td>
                                            <td>
                                                <span class="badge text-bg-success">{{ $pemilih['status_memilih'] }}</span>
                                            </td>
                                            <td>isan</td>
                                            <td>
                                                <a href="/edit-pemilih/{{ $pemilih['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @if (Auth::user()->id == 1)
                                                    <a href="/pemilih/delete/{{ $pemilih['id'] }}">
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
