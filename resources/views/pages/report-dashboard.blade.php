@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Projects'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <h4>Report page</h1>
                <p>Select a category</p>
        </div>
    </div>
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-lg-6">
                <div class="card report-card">
                    <a href="{{ route('report.itemOverview') }}">
                        <div class="card-body">
                            <h5 class="card-title">Item Overview</h5>
                            <p class="card-text">View detailed information about your inventory.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card report-card">
                    <a href="{{ route('report.LoanOverview') }}">
                        <div class="card-body">
                            <h5 class="card-title">Loan and Borrowing</h5>
                            <p class="card-text">View detailed information about your loan .</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card report-card">
                    <a href="{{ route('report.userActivity') }}">
                        <div class="card-body">
                            <h5 class="card-title">User Activities</h5>
                            <p class="card-text">Analyze the utilization of your assets.</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card report-card">
                    <a href="inventory.html">
                        <div class="card-body">
                            <h5 class="card-title">Coming Soon </h5>
                            <p class="card-text">Coming Soon</p>
                        </div>
                    </a>
                </div>
            </div>


        </div>

    </div>


    @include('layouts.footers.auth.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/project.js') }}"></script>


    <style>

    </style>
@endsection
