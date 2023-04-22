@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Projects'])
    <div class="container-fluid py-4">
        <div class="row mb-3">
            <form action="{{ route('projects.show', ['project' => $projectWithDetails->id]) }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search asset or inventory" name="search"
                        value="{{ Request::get('search') }}">
                    <button type="submit" class="btn btn-primary btn-dark">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

        </div>
        <div class="row">
            {{-- <div class="col-12"> --}}
            <div class="card mb-4">
                <div class="col-4 d-flex justify-content-between align-items-center mt-2">
                    @php $prevProjectName = '' @endphp

                    @foreach ($projectWithDetails->projectDetails as $detail)
                        @if ($detail->project->name != $prevProjectName)
                            <h6 class="mb-0">{{ $detail->project->name }}</h6>
                            @php $prevProjectName = $detail->project->name @endphp
                        @endif
                    @endforeach

                    <div class="mt-2 mt-md-0 ">
                        <a href="{{ route('projects.createItem', ['project' => $projectWithDetails->id]) }}"
                            class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i> Add items
                        </a>


                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdownButton"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter {{ Request::get('filter') ? ': ' . ucfirst(Request::get('filter')) : '' }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filterDropdownButton">
                            <a class="dropdown-item {{ !Request::get('filter') ? 'active' : '' }}"
                                href="{{ route('projects.show', ['project' => $projectWithDetails->id]) }}">All</a>
                            <a class="dropdown-item {{ Request::get('filter') == 'assets' ? 'active' : '' }}"
                                href="{{ route('projects.show', ['project' => $projectWithDetails->id, 'filter' => 'assets']) }}">Assets</a>
                            <a class="dropdown-item {{ Request::get('filter') == 'inventory' ? 'active' : '' }}"
                                href="{{ route('projects.show', ['project' => $projectWithDetails->id, 'filter' => 'inventory']) }}">Inventory</a>
                        </div>
                    </div>



                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Items</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price &#40;RM&#41;</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date received</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projectWithDetails->projectDetails as $detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $detail->item_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $detail->type }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">RM {{ $detail->price }}</p>
                                            {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($detail->status == 'Available')
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $detail->status }}</span>
                                            @elseif($detail->status == 'In-Use')
                                                <span
                                                    class="badge badge-sm bg-gradient-warning">{{ $detail->status }}</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-danger">{{ $detail->status }}</span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \DateTime::createFromFormat('Y-m-d H:i:s', $detail->date_received)->format('Y-m-d') }}
                                            </span>

                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('projects.editItem', ['project' => $projectWithDetails->id, 'detail' => $detail->id]) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="{{ asset('assets/js/project.js') }}"></script>
@endsection
