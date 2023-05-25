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
            <div class="modal-body">
                <p>Are you sure you want to return the item?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelRequest()">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmReturnBtn" >Confirm</button>
            </div>
        </div>
    </div>
</div>
