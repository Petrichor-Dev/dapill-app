<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Geni App</title>
        
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            {{-- <a class="navbar-brand ps-3" href="/">Pemilu App</a> --}}
            <a href="/"><img src="{{url('/assets/img/logo.png')}}" class="navbar-brand px-3" alt="" /></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        {{-- <li><a class="dropdown-item" href="#"></a></li> --}}
                        
                        <li>
                            <a class="dropdown-item" href="#">
                                <form method="POST" class="dropdown-item " action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" class="link-offset-2 link-underline link-underline-opacity-0 link-dark">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </a>
                        </li>

                        
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            @can('lihat-dashboard')
                            {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                            <a class="nav-link mt-4" href="/">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                Dashboard
                            </a>
                            @endcan
                            
                            {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
                            
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                                Dapil 1
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                 
                                            @can('lihat-kecamatan')
                                            
                                                <a class="nav-link collapsed" href="/kecamatan">
                                                    Kecamatan
                                                    {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                                                </a>
                                            @endcan
                                                
                                            @can('lihat-desa')
                                            <a class="nav-link collapsed" href="/desa">
                                                Desa
                                                {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                                            </a>

                                            @endcan
                                            
                                            @can('lihat-tps')
                                            <a class="nav-link collapsed" href="/tps">
                                                TPS
                                                {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                                            </a>
                                            @endcan
                                            
                                            @can('lihat-pemilih')
                                            <a class="nav-link collapsed" href="/pemilih">
                                                Pemilih
                                                {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                                            </a>
                                            @endcan

                                            @can('lihat-leader')
                                            <a class="nav-link collapsed" href="/leader">
                                                Leader
                                                {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
                                            </a>
                                            @endcan
                                </nav>
                            </div>
                                @can('lihat-dpt')
                                <a class="nav-link" href="/dpt">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-lock"></i></div>
                                    DPT
                                </a>
                                @endcan
                            {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                                Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @can('lihat-role')
                                    <a class="nav-link" href="/role">Role</a>
                                    @endcan
                                    
                                    @can('lihat-user')
                                    <a class="nav-link" href="/user">Users</a>
                                    @endcan
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Login Sebagai:</div>
                        {{ $roleName['name'] }} - {{ $roleName['jabatan']['name'] }}
                    </div>
                </nav>
            </div>
                <div id="layoutSidenav_content">
                @yield('body')
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; GENI App</div>
                                <div>
                                    <a href="#">Privacy Policy</a>
                                    &middot;
                                    <a href="#">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
        </div>
        
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#kecamatan').on('change', function () {
                    var kecamatanId = $(this).val();
                    if (kecamatanId) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-desa/' + kecamatanId,
                            success: function (data) {
                                $('#desa').empty();
                                $('#desa').append('<option value="">Pilih Desa</option>');
                                $.each(data, function (key, value) {
                                    $('#desa').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#desa').empty();
                        $('#desa').append('<option value="">Pilih Desa</option>');
                    }
                });

                $('#desa').on('change', function () {
                    var desaId = $(this).val();
                    if (desaId) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-tps/' + desaId,
                            success: function (data) {
                                $('#tps').empty();
                                $('#tps').append('<option value="">Pilih TPS</option>');
                                $.each(data, function (key, value) {
                                    $('#tps').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#tps').empty();
                        $('#tps').append('<option value="">Pilih TPS</option>');
                    }
                });
            });
        </script>

        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
            // Bar Chart Example
            let ctx = document.getElementById("myBarChart");

            $( document ).ready(function() {
                $.ajax({
                    type: 'GET',
                    url: '/get-kapten',
                    success: function (data) {
                        let nameOrder = data.sort((a, b) => a.total_pemilih - b.total_pemilih);
                        let namResult = nameOrder.map(item => item.name);
                        let totalResult = nameOrder.map(item => item.total_pemilih);
                        let myLineChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            //nama leader
                            labels: namResult,
                            datasets: [{
                            label: "Total Input Suara",
                            backgroundColor: "rgba(2,117,216,1)",
                            borderColor: "rgba(2,117,216,1)",
                            //data jumlah suara
                            data: totalResult
                            // data: [12, 31, 45, 83, 75].sort((a,b) => a-b),
                            // sort((a,b) => a-b)
                            }],
                        },
                        options: {
                            scales: {
                            xAxes: [{
                            time: {
                                unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                        //max total data yang di tampilkan
                        maxTicksLimit: 5
                        }
                     }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: 150,
                        maxTicksLimit: 20
                        },
                        gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
                            }
                        });
            });
            

            

        </script>
        {{-- <script src="/assets/demo/chart-area-demo.js"></script>
        <script src="/assets/demo/chart-bar-demo.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="/js/datatables-simple-demo.js"></script>
    </body>
</html>
