<div>
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card-body box-profile">
                        <h4>Deactivate Account</h4>
                        <p>
                            Deactivate your account.
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <p>
                        Once your account is deactivated, all of its resources and data will not be accessible to you. Before deactivating your account, please download any data or information that you wish to retain.
                    </p>
                    <div class="box-footer">
                        <button class="btn btn-danger" wire:click="confirmAccountDeactivation">Deactivate Account</button>
                    </div>

                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal" id="modal-account-deactivation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Deactivate Account</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Please enter your password to confirm you would like to deactivate your account.
                        </p>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" wire:model.defer="password" wire:keydown.enter="deleteAccountPermanently">
                        <p style="color: red">
                            {{$alert}}
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="deactivateAccount">Deactivate Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
