@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Projects'])
    <div class="container-fluid py-4">
        <form action="#" method="GET">
            <div class="row mb-3">

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search projects" name="search"
                        value="{{ Request::get('search') }}">
                    <button type="submit" class="btn btn-primary btn-dark">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            </div>
            <div class="card shadow-lg">
                <div class="card-body p-3">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateStartRangeFilter">Start Date:</label>
                                <input type="text" class="form-control" id="dateStartRangeFilter"
                                    placeholder="Select Start Date" data-provide="datepicker">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateEndRangeFilter">End Date:</label>
                                <input type="text" class="form-control" id="dateEndRangeFilter"
                                    placeholder="Select End Date" data-provide="datepicker">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="typeFilter">Type:</label>
                                <select class="form-control" id="typeFilter">
                                    <option value="">All Types</option>
                                    <option value="project">Project</option>
                                    <option value="item">Item</option>
                                    <option value="loan">Loan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="actionFilter">Action:</label>
                                <select class="form-control" id="actionFilter">
                                    <option value="">All Actions</option>
                                    <option value="create">Create</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                    <option value="approve">Approve</option>
                                    <option value="request">Request</option>
                                    <option value="reject">Reject</option>
                                    <option value="return">Return</option>
                                </select>
                            </div>
                        </div>
                        <div class=" text-start ">
                            <button class="btn btn-primary" id="filterButton">Filter</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="row mt-2">
            {{-- <div class="col-12"> --}}
            <div class="card mb-4">
                <div class="row mb-3 mt-2">
                    <div class="col-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">User Activites History</h6>

                        {{-- <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdownButton"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter
                            </button>
                            <div class="dropdown-menu" aria-labelledby="filterDropdownButton">
                                <a class="dropdown-item " href="#">All</a>
                                <a class="dropdown-item " href="#">Assets</a>
                                <a class="dropdown-item" href="#">Inventory</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="timeline">
                        @foreach ($userActivity as $activity)
                            <div class="timeline-item">
                                <div class="timeline-item-content">
                                    <div class="timeline-item-marker">
                                        <span class="timeline-marker-dot"></span>
                                        <span
                                            class="timeline-marker-date">{{ $activity->getFormattedActionTimestampAttribute() }}</span>
                                    </div>
                                    <div class="timeline-item-description">
                                        {{ $activity->description }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
            {{-- </div> --}}
        </div>

    </div>


    @include('layouts.footers.auth.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('assets/js/project.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                // additional options and configurations
            });
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
