@extends('layout.main')

    @section('body')
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dapil 1</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">List Kecamatan</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">   
                                    {{-- <i class="fas fa-table"></i>
                                    DataTable Exampel --}}
                                    <div class="d-flex justify-content-end">
                                        <a href="/kecamatan">
                                            <button class="btn btn-primary">Tambah Kecamatan</button>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
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
                                            <tr>
                                                <td>Binjai Utara</td>
                                                <td>Miun Malehoy</td>
                                                <td>10</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                    <button type="button" class="btn btn-outline-danger">Hapus</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Binjai selatan</td>
                                                <td>Miun Malehoy</td>
                                                <td>10</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary">Edit</button>
                                                    <button type="button" class="btn btn-outline-danger">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
    @endsection
