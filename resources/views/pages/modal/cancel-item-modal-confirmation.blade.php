<!-- return-item-modal.blade.php -->

<div id="cancelRequestModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Request Cancellation</h5>
            </div>
            <form action="{{ route('loan.cancelLoanRequest') }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to cancel the loan request?</p>
                    <input type="hidden" name="id" id="cancelRequestId">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="hideModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function showCancelRequestModal(id) {
        $('#cancelRequestId').val(id)
        console.log(id);
        $('#cancelRequestModal').modal('show');
    }


    // $('#confirmCancelBtn').on('click', function() {
    //     var itemId = $('#cancelRequestModal').data('id');

    //     // Send an AJAX request to the controller endpoint
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-Token': '{{ csrf_token() }}',
    //         },
    //         url: '{{ route('loan.cancelLoanRequest') }}',
    //         method: 'DELETE',
    //         data: {
    //             itemId: itemId, // Replace with the actual item ID
    //         },
    //         success: function(response) {
    //             console.log('Loan request canceled successfully');
    //             $('#cancelRequestModal').modal('hide');
    //             location.reload();
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error canceling loan request:', error);
    //         }
    //     });
    // });
</script>
