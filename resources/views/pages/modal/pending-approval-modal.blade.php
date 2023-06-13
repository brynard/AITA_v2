<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true" style="margin-top: 100px">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>

            </div>
            <form action="{{ route('loan.processPendingRequest') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <p id="confirmationText"></p>
                    <input type="hidden" name="action" id="action">
                    <input type="hidden" name="itemId" id="itemId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="cancelButton">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmButton">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function showConfirmationModal(action, itemId, requester) {
        // Set the confirmation text based on the action
        var confirmationText = '';
        if (action === 'decline') {
            confirmationText = 'Are you sure you want to decline the loan request?';
        } else if (action === 'approve') {
            confirmationText = 'Are you sure you want to approve the loan request?';
        }

        // Update the modal body with the confirmation text
        $('#confirmationText').text(confirmationText);

        // Set the data-item attribute of the confirm button
        $('#itemId').val(itemId)
        $('#action').val(action)

        // Show the modal
        $('#confirmationModal').modal('show');
    }


    // Event listener for cross button click
    $('.icon-move-top[data-action="delete"]').on('click', function() {
        var action = $(this).data('action');
        showConfirmationModal(action);
    });

    // Event listener for tick button click
    $('.icon-move-top[data-action="confirm"]').on('click', function() {
        var action = $(this).data('action');
        showConfirmationModal(action);
    });


    $('#cancelButton').on('click', function() {
        // Hide the modal
        $('#confirmationModal').modal('hide');
    });
</script>
