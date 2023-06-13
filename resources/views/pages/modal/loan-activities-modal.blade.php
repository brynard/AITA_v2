<!-- Modal -->
<div class="modal fade" id="loanActivitiesModal" tabindex="-1" aria-labelledby="loanActivitiesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loanActivitiesModalLabel">Loan Activities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loan Activities content here -->
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
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
