@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Loan'])

    <div class="container-fluid py-4">

        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Loaned Item Management</h6>
                        </div>
                    </div>
                    <div class="table-responsive ">
                        <table class="table align-items-center ">
                            <tbody>
                                @foreach ($loanRequests as $request)
                                    <tr>
                                        <td class="">
                                            <div class="d-flex px-2 py-1 align-items-center">

                                                <div class="ms-4">
                                                    <p class="text-xs font-weight-bold mb-0">Item:</p>
                                                    <h6 class="text-sm mb-0">{{ $request->projectDetails->item_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Date Range</p>
                                                <h6 class="text-sm mb-0">
                                                    {{ date('d/m/Y', strtotime($request->loan_start_date)) }}
                                                    -
                                                    {{ date('d/m/Y', strtotime($request->loan_end_date)) }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Status</p>
                                                <h6 class="text-sm mb-0">
                                                    {{ $request->status }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="button-cell">
                                            <div class="text-end">
                                                @if ($request->status == 'pending')
                                                    <button type="button" class="btn btn-secondary" onclick="#">Cancel
                                                        Request</button>
                                                @elseif ($request->status == 'approved')
                                                    <button type="button" class="btn btn-dark"
                                                        onclick="showReturnItemModal('{{ $request->id }}')">Return
                                                        Item</button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle text-sm button-cell">
                                            <button type="button" class="btn btn-primary ">Edit
                                                Request</button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Pending Approval</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Devices</h6>
                                        <span class="text-xs">250 in stock, <span class="font-weight-bold">346+
                                                sold</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-tag text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                                        <span class="text-xs">123 closed, <span class="font-weight-bold">15
                                                open</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-box-2 text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                                        <span class="text-xs">1 is active, <span class="font-weight-bold">40
                                                closed</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-satisfied text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                                        <span class="text-xs font-weight-bold">+ 430</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 mt-3">
            <div class="search-bar text-center">
                <form action="#" method="GET">
                    <div class="input-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-rectangular btn-dark" type="button"
                                id="filterDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                                All
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="filterDropdownButton">
                                <li><a class="dropdown-item" href="#">All</a></li>
                                <li><a class="dropdown-item" href="#">Asset</a></li>
                                <li><a class="dropdown-item" href="#">Inventory</a></li>
                            </ul>
                        </div>

                        <input type="text" class="form-control" placeholder="Search projects" name="search"
                            value="{{ Request::get('search') }}" style="width: auto; padding: 0.5rem 1rem;">
                        <button type="submit" class="btn btn-primary btn-dark">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-12"> --}}
            <div class="card mb-4">
                <div class="row mb-3 mt-2">
                    <div class="col-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Availabe Items</h6>

                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Item Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Owner</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                        Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loanItems as $loanItems)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="data:image/png;base64,{{ $loanItems->image }}"
                                                        class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                </div>
                                                <div class="my-auto">

                                                    <h6 class="mb-0 text-sm itemName">{{ $loanItems->item_name }}</h6>


                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $loanItems->project->user->username ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">RM {{ $loanItems->price }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{ $loanItems->quantity }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-primary loanButton"
                                                data-item="{{ json_encode($loanItems) }}">
                                                Request Loan
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- {{ $loanItems->links() }} --}}

            </div>
        </div>
    </div>






    @include('layouts.footers.auth.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('pages.toastr')
    @include('pages.modal.return-item-modal-confirmation')


    <script>
        // Function to open the modal and display the item name
        function openModal(itemId, itemName) {

            $('#addLoanModal').modal('show');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("loanForm").reset();
            $('#addLoanModal').modal('hide');
        }

        // Event listener for loan buttons click

        $('.loanButton').on('click', function() {
            document.getElementById("loanForm").reset();
            var item = null
            var itemData = $(this).data('item'); // Retrieve the data-item attribute value
            console.log(itemData);
            // var item = JSON.parse(itemData); // Parse the JSON back into an object
            item = itemData
            // Example: Update the modal content with the item details
            $('#itemName').text(item.item_name);
            $('#itemOwner').text(item.project && item.project.user ? item.project.user.username : '-');
            $('#itemPrice').text('RM ' + item.price);
            $('#itemQuantity').text(item.quantity);


            $('#requester_id').val({{ Auth()->user()->id }});
            $('#owner_id').val(item.project && item.project.user ? item.project.user.id : '0');
            $('#project_details_id').val(item.id);
            // Show the modal
            $('#addLoanModal').modal('show');
        });


        // Event listener for modal close button click
        $('#addLoanModal').on('hidden.bs.modal', function() {
            item = null
            closeModal();
        });
    </script>



    <script>
        $('#confirmReturnBtn').on('click', function() {
            console.log("asdasd");
            var itemId = $(this).data('id');
            // Send an AJAX request to the controller endpoint
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: '{{ route('loan.updateReturnStatus') }}',
                method: 'PUT',
                data: {
                    itemId: itemId, // Replace with the actual item ID
                },
                success: function(response) {
                    console.log('Return status updated successfully');
                    $('#returnItemModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error updating return status:', error);
                }
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="addLoanModal" tabindex="-1" aria-labelledby="addLoanModalLabel" aria-hidden="true"
        style="margin-top: 100px;" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Request Loan</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id='itemName'>
                    </h4>
                    <p id='itemOwner'>

                    </p>
                    <form method="POST" action="{{ route('loan.requestLoan') }}" enctype="multipart/form-data"
                        id="loanForm">
                        @csrf
                        <div class="mb-3">
                            <label for="desc" class="form-label">Usage Description</label>
                            <input type="text" class="form-control" id="desc" name="desc"
                                placeholder="Enter usage description">
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control datepicker" id="start_date"
                                name="start_date" placeholder="Select start date">
                        </div>
                        <div class="mb-3">
                            <label for="return_date" class="form-label">Return Date</label>
                            <input type="datetime-local" class="form-control datepicker" id="return_date"
                                name="return_date" placeholder="Select return date">
                        </div>
                        <input type="hidden" name="project_details_id" id="project_details_id">
                        <input type="hidden" name="owner_id" id="owner_id">
                        <input type="hidden" name="requester_id" id="requester_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/project.js') }}"></script>
@endsection
<script>
    flatpickr("input[type=datetime-local]");
</script>
