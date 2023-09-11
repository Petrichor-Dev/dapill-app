
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

                        @if (session()->has('danger'))
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ session('danger') }}
                        </div>
                        @endif
                        <h1 class="mt-4">Leader</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar Leader</li>
                        </ol>

                        @can('lihat-leader')
                        <div class="card mb-4">
                            <div class="card-header">   
                                @can('tambah-leader')
                                <a href="/tambah-leader">
                                    <button class="btn btn-primary">Tambah Leader</button>
                                </a>
                                @endcan
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Leader</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Leader</th>
                                            <th>Jumlah Pemilih</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($leaders as $key => $leader)
                                        {{-- @dd(strlen($leader['pemilih'])) --}}
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <a href="/leader/detail/{{ $leader['id'] }}" class="text-grey text-reset">
                                                    <b>{{ strtoupper($leader['name']) }}</b>
                                                </a>
                                            </td>
                                            <td><b>{{ count($leader['pemilih']) }} Orang</b></td>
                                            <td>
                                                @can('edit-leader')
                                                <a href="/edit-leader/{{ $leader['id'] }}">
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                </a>
                                                @endcan
                                                
                                                @can('hapus-leader')
                                                <a  href="/leader/delete/{{ $leader['id'] }}">
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
                        @endcan
                    </div>
                </main>
    @endsection
