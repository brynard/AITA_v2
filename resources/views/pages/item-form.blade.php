@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    {{-- <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            Sayo Kravits
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Public Relations
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="ni ni-app"></i>
                                    <span class="ms-2">App</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-email-83"></i>
                                    <span class="ms-2">Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span class="ms-2">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-fluid py-4s">
        <div class="row">
            <div class="col-md-8  ">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            @if (isset($detail))
                                <p class="mb-0">Edit Item</p>
                            @else
                                <p class="mb-0">Add New Item</p>
                            @endif

                            {{-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        @if (isset($detail))
                            <form method="POST" action="" enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form action="{{ route('projects.storeItem', ['project' => $detail->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                        @endif
                        <form action="{{ route('projects.storeItem', ['project' => $detail->id]) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="item_name" class="form-control-label">Item Name <span
                                                class="text-danger">*</span> @error('item_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                        <input id="item_name" type="text"
                                            class="form-control {{ $errors->has('item_name') ? ' is-invalid' : '' }}"
                                            name="item_name" placeholder="Item name"
                                            value="{{ old('item_name', $detail->item_name) }}" required>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="type" class="form-control-label">Type <span
                                                class="text-danger">*</span> </label>
                                        <select id="type" class="form-control" name="type" required>
                                            <option value="Asset"
                                                {{ old('item_name', $detail->type) == 'Asset' ? 'selected' : '' }}>Asset
                                            </option>
                                            <option value="Inventory"
                                                {{ old('item_name', $detail->type) == 'Inventory' ? 'selected' : '' }}>
                                                Inventory</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantity" class="form-control-label">Quantity <span
                                                class="text-danger">*</span> @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                        <input id="quantity" type="text" class="form-control" name="quantity"
                                            placeholder="Quantity" value="{{ old('quantity', $detail->quantity) }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price" class="form-control-label">Unit Price <span
                                                class="text-danger">*</span> </label>
                                        <input id="unit_price" type="text" class="form-control" name="unit_price"
                                            placeholder="Unit Price" value="{{ old('unit_price', $detail->unit_price) }}"
                                            required>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="subtype" class="form-control-label">Subtype</label>
                                        <input id="subtype" type="text" class="form-control" name="subtype"
                                            placeholder="Subtype" value="{{ old('subtype', $detail->subtype) }}">
                                    </div>
                                </div>
                                <div class="col-md-4    ">
                                    <div class="form-group">
                                        <label for="serial_number" class="form-control-label">Serial Number</label>
                                        <input id="serial_number" type="text" class="form-control" name="serial_number"
                                            placeholder="Serial Number"
                                            value="{{ old('serial_number', $detail->serial_number) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="model" class="form-control-label">Model</label>
                                        <input id="model" type="text" class="form-control" name="model"
                                            placeholder="Model" value="{{ old('model', $detail->model) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="engine_type" class="form-control-label">Engine Type</label>
                                        <input id="engine_type" type="text" class="form-control" name="engine_type"
                                            placeholder="Engine Type"
                                            value="{{ old('engine_type', $detail->engine_type) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="voltage" class="form-control-label">Voltage</label>
                                        <input id="voltage" type="text" class="form-control" name="voltage"
                                            placeholder="Voltage" value="{{ old('voltage', $detail->voltage) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier" class="form-control-label">Supplier Name</label>
                                        <input id="supplier" type="text" class="form-control" name="supplier"
                                            placeholder="Supplier Name" value="{{ old('supplier', $detail->supplier) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="location" class="form-control-label">Location <span
                                            class="text-danger">*</span> </label>
                                    <input id="location" type="text" class="form-control" name="location" required
                                        placeholder="Location" value="{{ old('location', $detail->location) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_received" class="form-control-label">Date Received <span
                                            class="text-danger">*</span> </label>
                                    <input id="date_received" type="date" class="form-control" name="date_received"
                                        required value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Image</label>
                                    <div class="position-relative flex-column">
                                        <div id="preview-container" class="bg-white border rounded"
                                            style="width: 150px; height: 150px;">
                                            <img id="preview" {{-- src="data:image/jpeg;base64,{{ base64_decode($detail->image) }}" --}} src="{{ asset('img/AITA.png') }}"
                                                alt="Preview"
                                                style="display:none; max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                        <input id="image" type="file" class="form-control mt-3" name="image"
                                            accept="image/*">
                                        <button type="button" class="btn btn-danger mt-3" id="remove-image"
                                            style="display: none;">Remove Image</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets/js/project.js') }}"></script>
@endsection
