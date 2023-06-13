@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Loan'])

    <div class="container-fluid py-4">

        <div class="row mt-4">
            <div class="col-lg-9 mb-lg-0 mb-4">
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
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Owner</p>
                                                <h6 class="text-sm mb-0">
                                                    {{ $request->owner->username }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="button-cell">
                                            <div class="text-end">
                                                @if ($request->status == 'pending')
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="showCancelRequestModal('{{ $request->id }}')">Cancel
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
                    {{ $loanRequests->links() }}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Pending Approval</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @foreach ($pendingApprovals as $pendingApproval)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">

                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">
                                                {{ $pendingApproval->projectDetails->item_name }}</h6>
                                            <span class="text-xs">
                                                Requester: {{ $pendingApproval->requester->username }}</span>
                                            <span class="text-xs">
                                                {{ date('d/m/Y', strtotime($pendingApproval->loan_start_date)) }}
                                                -
                                                {{ date('d/m/Y', strtotime($pendingApproval->loan_end_date)) }}</span>
                                            <span class="text-xs">
                                                {{ $pendingApproval->desc }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-top my-auto"
                                            data-toggle="modal" data-target="#confirmationModal"
                                            onclick="showConfirmationModal('decline', {{ $pendingApproval->projectDetails->id }})">
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        </button>

                                        <!-- Tick Button -->
                                        <button
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-top my-auto"
                                            data-toggle="modal" data-target="#confirmationModal"
                                            onclick="showConfirmationModal('approve', {{ $pendingApproval->id }})">
                                            <i class="fas fa-check" aria-hidden="true"></i>
                                        </button>


                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{ $pendingApprovals->links() }}
                </div>
            </div>
        </div>
        <div class="row mb-3 mt-3">
            <div class="search-bar text-center">
                <form action="#" method="GET">
                    <div class="input-group">


                        <input type="text" class="form-control" placeholder="Search available items" name="search"
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
                                        Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loanItems as $loanItem)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="{{ $loanItem->image ? 'data:image/png;base64,' . $loanItem->image : '/img/itembox.png' }}"
                                                        class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                </div>
                                                <div class="my-auto">

                                                    <h6 class="mb-0 text-sm itemName">{{ $loanItem->item_name }}</h6>


                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $loanItem->project->user->username ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">RM {{ $loanItem->price }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{ $loanItem->type }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-primary loanButton"
                                                data-item="{{ json_encode($loanItem) }}">
                                                Request Loan
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    {!! $loanItemsPagination !!}

                </div>
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
    @include('pages.modal.cancel-item-modal-confirmation')
    @include('pages.modal.pending-approval-modal')
    <!-- Request Loan Item !-->
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
