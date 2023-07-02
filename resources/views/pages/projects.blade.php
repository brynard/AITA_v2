@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', [
        'title' => $readOnly == 1 ? 'UserManagent / Project' : 'Projects',
    ])
    <div class="container-fluid py-4">
        @if ($readOnly == 1)
            <div class="row mb-3">
                <form action="#" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search projects" name="search"
                            value="{{ Request::get('search') }}">
                        <button type="submit" class="btn btn-primary btn-dark">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        @endif
        <div class="row">
            {{-- <div class="col-12"> --}}
            <div class="card mb-4">
                <div class="row mb-3 mt-2">
                    <div class="col-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Projects table </h6>

                        @if ($readOnly == 2)
                            <div class="mt-2 mt-md-0 ">
                                <button id="addProjectModalButton" class="btn btn-primary">
                                    <i class="fa fa-plus me-2"></i>
                                    Add Project
                                </button>
                            </div>
                        @endif
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
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Project</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Budget</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                        Completion</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src=" {{ $project->logo ? 'data:image/png;base64,' . $project->logo : '/img/itembox.png' }} "
                                                        class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                </div>

                                                <div class="my-auto">
                                                    <a
                                                        href="{{ route('projects.show', ['project' => $project->id, 'readOnly' => $readOnly]) }}">
                                                        <h6 class="mb-0 text-sm">{{ $project->name }}</h6>
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $project->budget }}</p>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">{{ $project->status }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span
                                                    class="me-2 text-xs font-weight-bold">{{ $project->completion }}%</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                            aria-valuenow="{{ $project->completion }}" aria-valuemin="0"
                                                            aria-valuemax="100" style="width: {{ $project->completion }}%;">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        @if ($readOnly == 2)
                                            <td class="align-middle">
                                                <div class="btn-group position-relative">
                                                    <button type="button" class="btn btn-link text-secondary mb-0"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Change Status</a>
                                                        <form action="{{ route('projects.destroy', $project->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
        {{ $projects->links() }}

    </div>


    @include('layouts.footers.auth.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/project.js') }}"></script>

    <script>
        .btn - group.position - relative.dropdown - menu {
            left: auto;
            right: 0;
            transform: translateX(-100 % );
        }
    </script>
    <!-- Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true"
        style="margin-top: 100px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter project name">
                        </div>
                        <div class="mb-3">
                            <label for="budget" class="form-label">Budget Allocated</label>
                            <input type="number" class="form-control" id="budget" name="budget"
                                placeholder="Enter budget allocated" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Project Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="cancelModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
