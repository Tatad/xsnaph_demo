<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name', 'xsnaph') }}</title>
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="nav-fixed">
        <span id="app">
            <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
                <a class="navbar-brand d-none d-sm-block" href="/">{{ config('app.name', 'X-snaPH') }}</a>

                <ul class="navbar-nav align-items-center ml-auto">
                    <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <img class="img-fluid" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"/> -->
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                            <h6 class="dropdown-header d-flex align-items-center">
                                <!-- <img class="dropdown-user-img" src="https://source.unsplash.com/QAB-WJcbgJk/60x60" /> -->
                                <div class="dropdown-user-details">
                                   
                                </div>
                            </h6>
                            <div class="dropdown-divider"></div>
                            <!-- <a class="dropdown-item" href="#!">
                                <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                                Account
                            </a> -->
                            {{--<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="dropdown-item-icon">
                                    <i data-feather="log-out"></i>
                                </div>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>--}}
                            <a class="dropdown-item" href="/logout-org">
                                <div class="dropdown-item-icon">
                                    <i data-feather="log-out"></i>
                                </div>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sidenav shadow-right sidenav-light">
                        <div class="sidenav-menu">
                            <div class="nav accordion" id="accordionSidenav">
                                <div class="sidenav-menu-heading">Accounting</div>

                                <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#reports" aria-expanded="false" aria-controls="reports"
                                    ><div class="nav-link-icon"><i data-feather="layout"></i></div>
                                    Reports
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                                ></a>
                                <div class="collapse" id="reports" data-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                        <a class="nav-link" href="/sales-journal-report">Sales Journal Report</a>
                                    </nav>
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                        <a class="nav-link" href="/purchases-journal-report">Purchases Journal Report</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="sidenav-footer">
                            <div class="sidenav-footer-content">
                                <div class="sidenav-footer-subtitle">Logged in as: {{$_SESSION['org']['organization_name']}}</div>
                                <div class="sidenav-footer-title"></div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content">
                    <main>
                        @yield('content')
                    </main>
                    <footer class="footer mt-auto footer-light">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 small">Copyright &copy; xsnaph {{date('Y')}}</div>
                                <div class="col-md-6 text-md-right small">
                                    <a href="#!">Privacy Policy</a>
                                    &middot;
                                    <a href="#!">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </span>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="/js/scripts.js" defer></script>

    </body>
</html>
