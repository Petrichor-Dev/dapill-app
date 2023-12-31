
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
                        <h1 class="mt-4">Detail {{ $status }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar {{ $status }}</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                <a href="/">
                                    <button class="btn btn-primary">&larr; Kembali</button>
                                </a>
                            </div>
                            @can('lihat-pemilih')
                            <div class="card-body">
                                @if($status === "DPT")
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Nama TPS</th>
                                                <th>Status Memilih</th>
                                                <th>Admin</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Nama TPS</th>
                                                <th>Status Memilih</th>
                                                <th>Admin</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($datas as $key => $data)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                @if($data['is_pemilih'] === 1)
                                                    <td><b><span class="text-primary">{{ $data['nama'] }}</span></b></td>
                                                @else
                                                    <td><b>{{ $data['nama'] }}</b></td>
                                                @endif
                                                
                                                <td>{{ $data['namaKecamatan'] }}</td>
                                                <td>{{ $data['namaDesa'] }}</td>
                                                <td>{{ $data['namaTps'] }}</td>
                                                <td>
                                                    @if ($status === "DPT")
                                                        -
                                                    @else
                                                    @switch($data['status_memilih'])
                                                        @case('Ragu-Ragu')
                                                            <span class="badge text-bg-warning">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                        @case('Memilih')
                                                            <span class="badge text-bg-success">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                        @case('Tidak-Memilih')
                                                            <span class="badge text-bg-danger">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                    
                                                        @default
                                                            
                                                    @endswitch
                                                    @endif

                                                    
                                                </td>
                                                <td>{{ $data['admin']['name'] }}</td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Leader</th>
                                                <th>Kapten</th>
                                                <th>Mayor</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Nama TPS</th>
                                                <th>Status Memilih</th>
                                                <th>Admin</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Leader</th>
                                                <th>Kapten</th>
                                                <th>Mayor</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Nama TPS</th>
                                                <th>Status Memilih</th>
                                                <th>Admin</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($datas as $key => $data)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                @if($data['is_dpt'] === 1)
                                                    <td><b><span class="text-primary">{{ $data['nama'] }}</span></b></td>
                                                @else
                                                    <td><b>{{ $data['nama'] }}</b></td>
                                                @endif
                                                <td>{{ $data['leader']['name'] }}</td>
                                                <td>{{ $data['kapten']['name'] }}</td>
                                                <td>{{ $data['mayor']['name'] }}</td>
                                                <td>{{ $data['namaKecamatan'] }}</td>
                                                <td>{{ $data['namaDesa'] }}</td>
                                                <td>{{ $data['namaTps'] }}</td>
                                                <td>
                                                    @if ($status === "DPT")
                                                        -
                                                    @else
                                                    @switch($data['status_memilih'])
                                                        @case('Ragu-Ragu')
                                                            <span class="badge text-bg-warning">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                        @case('Memilih')
                                                            <span class="badge text-bg-success">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                        @case('Tidak-Memilih')
                                                            <span class="badge text-bg-danger">{{ $data['status_memilih'] }}</span>
                                                            @break

                                                    
                                                        @default
                                                            
                                                    @endswitch
                                                    @endif

                                                    
                                                </td>
                                                <td>{{ $data['admin']['name'] }}</td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            @endcan
                        </div>
                    </div>
                </main>
    @endsection
