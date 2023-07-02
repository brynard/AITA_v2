@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Projects'])
    <div class="card shadow-lg mx-4 ">
        <div class="card-body p-3">
            <h4>Report page</h1>
                <p>Select a category</p>
        </div>
    </div>
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-lg-6 ">
                <div class="card report-card">
                    <a href="{{ route('report.itemOverview') }}">
                        <div class="card-body">

                            <div class="card-header mx-4 p-3 text-center">
                                <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                    <i class="fas fa-building opacity-10"></i>
                                </div>
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                                <h6 class="text-center mb-0">Asset</h6>
                                <span class="text-L">Asest or blalbalbalba</span>
                                <hr class="horizontal dark my-3">
                                <h5 class="mb-0">Above RM 3000</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card report-card">
                    <a href="{{ route('report.LoanOverview') }}">
                        <div class="card-body">
                            <div class="card-header mx-4 p-3 text-center">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                    <i class="fas fa-cubes opacity-10"></i>
                                </div>
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                                <h6 class="text-center mb-0">Inventory</h6>
                                <span class="text-L">Inventory or blalbalbalba</span>
                                <hr class="horizontal dark my-3">
                                <h5 class="mb-0">between RM500 - RM 3000</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>




        </div>

    </div>


    {{-- @include('layouts.footers.auth.footer') --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/project.js') }}"></script>


    <style>

    </style>
@endsection
