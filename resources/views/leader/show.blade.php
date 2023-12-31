@extends('layout.main')

    @section('body')
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pemilih</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar Pemilih Yang Memilih <b>{{ strtoupper($leader) }}</b></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">   
                                <a href="/leader">
                                    <button class="btn btn-primary">&larr; Kembali</button>
                                </a>
                            </div>                  
                            @can('lihat-pemilih')
                            <div class="card-body">
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
                                        @foreach ($pemilihs as $key => $pemilih)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            @if($pemilih['is_dpt'] === 1)
                                                <td><b><span class="text-primary">{{ $pemilih['nama'] }}</span></b></td>
                                            @else
                                                <td><b>{{ $pemilih['nama'] }}</b></td>
                                            @endif
                                            <td>{{ $pemilih['leader']['name'] }}</td>
                                            {{-- <td>asd</td> --}}
                                            <td>{{ $pemilih['kapten']['name'] }}</td>
                                            <td>{{ $pemilih['mayor']['name'] }}</td>
                                            <td>{{ $pemilih['namaKecamatan'] }}</td>
                                            <td>{{ $pemilih['namaDesa'] }}</td>
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
                                            <td>{{ $pemilih['admin']['name'] }}</td>
                 
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
