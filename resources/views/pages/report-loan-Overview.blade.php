@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Report / Loan Overview'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <h4>Loan Overview</h4>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Loan Request made by user
                                    </p>
                                    <h5 class="font-weight-bolder">
                                        {{ $totalLoan }}
                                    </h5>

                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total approved request by
                                        user</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $totalApprovedLoanRequest }}
                                    </h5>

                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Loaned Item Overdue Count
                                    </p>
                                    <h5 class="font-weight-bolder">
                                        {{ $totalOverdue }}/{{ $totalRequest }}
                                    </h5>

                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">

            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Total Number of Loaned Items Over Time</h6>

                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="loaned-items-chart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-5 mb-lg-0 mb-4">
                <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Loan Activities</h6>
                            </div>
                        </div>
                    </div>

                    @foreach ($sortedLoanActivities as $key => $activity)
                        <div class="card-body pt-4 p-3">
                            @php
                                $counter = 0;
                            @endphp
                            @foreach ($activity as $rowKey => $row)
                                @php
                                    $formattedKey = str_replace('_', ' ', $rowKey);
                                @endphp
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                                    {{ $formattedKey }}
                                </h6>
                                <ul class="list-group">
                                    @foreach ($row as $item)
                                        @if ($counter < 4)
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <button
                                                        class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">{{ $item['content'] }}</h6>
                                                        <span class="text-xs">{{ $item['date'] }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @else
                                        @break
                                    @endif
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                @endforeach

                <div class="card-footer px-3 pb-3 ">
                    <div class=" text-end">
                        <a href="#" class="text-primary" data-bs-toggle="modal"
                            data-bs-target="#loanActivitiesModal">See More</a>

                    </div>

                </div>
            </div>
        </div>



        {{-- <div class="row mt-3">
            <div class="col-lg-6 mb-lg-0 mb-4 mt-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Average Loan Duration</h6>

                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="loanDurationChart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 mb-lg-0 mb-4 mt-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Items by project</h6>

                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div> --}}

    </div>
</div>
</div>

@include('layouts.footers.auth.footer')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-boxplot"></script>


<script src="{{ asset('assets/js/project.js') }}"></script>

{{-- @include('pages.chart.item-overview-chart'); --}}

@include('pages.modal.loan-activities-modal');

<script>
    var timestamps = {!! json_encode($timestamps) !!};
    var requesterCounts = {!! json_encode($requesterCounts) !!};
    var ownerCounts = {!! json_encode($ownerCounts) !!};
    var lineChartCanvas = document.getElementById('loaned-items-chart').getContext('2d');
    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                    label: 'Current user loan item from others.',
                    data: requesterCounts,
                    borderColor: 'blue',
                    fill: false
                },
                {
                    label: 'Other user loam item from current user.',
                    data: ownerCounts,
                    borderColor: 'green',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Total Number of Loaned Items Over Time'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Number of Items'
                    }
                }
            }
        }
    });
</script>



<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 10px;
        height: 100%;
        border-right: 2px dotted #999999;
    }

    .timeline-item {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item-marker {
        position: relative;
        display: flex;
        align-items: center;
    }

    .timeline-marker-dot {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #999999;
        color: #ffffff;
        font-weight: bold;
        font-size: 14px;
    }

    .timeline-marker-line {
        position: absolute;
        top: 50%;
        left: 8px;
        width: 6px;
        height: calc(100% - 24px);
        background-color: #999999;
    }

    .timeline-marker-date {
        margin-left: 10px;
        font-size: 14px;
        font-weight: bold;
    }

    .timeline-item-description {
        margin-left: 40px;
        font-size: 14px;
        line-height: 1.5;
    }
</style>
@endsection
