@extends('layout.main')

    @section('body')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        
                        <div class="card-body"><b>Total DPT</b></div>
                        <p class="mx-3"><b> {{ $totalDpt }}</b></p>
                        @can('lihat-dpt')
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            
                            <a class="small text-white stretched-link" href="/dashboard/">Lihat Detail</a>
                            
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body"><b>Memilih</b></div>
                        <p class="mx-3"><b> {{ $jumlahMemilih }}</b></p>
                        @can('lihat-pemilih')
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="/dashboard/Memilih">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body"><b>Ragu Ragu</b></div>
                        <p class="mx-3"><b> {{ $jumlahRaguRagu }}</b></p>
                        @can('lihat-pemilih')
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="/dashboard/Ragu-Ragu">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-black text-white mb-4">
                        <div class="card-body"><b>Tidak Memilih</b></div>
                        <p class="mx-3"><b> {{ $jumlahTidakMemilih }}</b></p>
                        @can('lihat-pemilih')
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="/dashboard/Tidak-Memilih">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" value="{{ $totalDpt }}" id="totalDpt">
                <div class="col-xl-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Grafik Kapten
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
