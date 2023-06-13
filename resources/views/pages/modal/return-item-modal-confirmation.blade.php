<!-- return-item-modal.blade.php -->

<div id="returnItemModal" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return Item Confirmation</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form action="{{ route('loan.updateReturnStatus') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to return the item?</p>
                    <input type="hidden" name="id" id="id">
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



<!-- Update Return Status and Cancel request !-->
<script>
    function showReturnItemModal(id) {
        // console.log(id);
        $('#id').val(id);
        $('#returnItemModal').modal('show');
    }


    function hideModal() {
        // Perform any necessary actions

        // Close the modal

        $('#returnItemModal').modal('hide');
        $('#cancelRequestModal').modal('hide');
    }


    // $('#confirmReturnBtn').on('click', function() {

    //     var itemId = $(this).data('id');
    //     // Send an AJAX request to the controller endpoint
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-Token': '{{ csrf_token() }}',
    //         },
    //         url: '{{ route('loan.cancelLoanRequest') }}',
    //         method: 'PUT',
    //         data: {
    //             itemId: itemId, // Replace with the actual item ID
    //         },
    //         success: function(response) {
    //             console.log('Return status updated successfully');
    //             $('#returnItemModal').modal('hide');
    //             location.reload();
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error updating return status:', error);
    //         }
    //     });
    // });
</script>
