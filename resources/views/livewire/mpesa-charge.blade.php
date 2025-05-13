<div class="container mt-5" wire:poll.5s>
    <div class="row">
        <!-- C2B Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Consumer to Business (C2B)</div>
                <div class="card-body">
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="text" id="phoneNumber" wire:model="c2bphoneNumber" class="form-control">

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" wire:model="c2bamount" class="form-control">

                    <button wire:click="chargeC2B" wire:loading.attr="disabled" wire:target="chargeC2B"
                        class="btn btn-primary mt-2">
                        <span wire:loading wire:target="chargeC2B">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                        Charge
                    </button>
                </div>
            </div>
        </div>

        <!-- B2C Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Business to Consumer (B2C)</div>
                <div class="card-body">
                    <form method="GET" wire:submit.prevent="chargeB2C">
                        <label for="phoneNumber">Receiver Phone:</label>
                        <input type="text" id="phoneNumber" name="b2cphoneNumber" class="form-control" required>

                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="b2camount" class="form-control" required>

                        <button type="submit" class="btn btn-primary mt-2">
                            <span wire:loading wire:target="chargeB2C">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                            Pay
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- B2B Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Business to Business (B2B)</div>
                <div class="card-body">

                    <label for="businessAccount">Business Account:</label>
                    <input type="text" id="businessAccount" wire:model="businessAccount" class="form-control">

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" wire:model="b2bamount" class="form-control">

                    <button wire:click="chargeB2B" wire:loading.attr="disabled" wire:target="chargeB2B"
                        class="btn btn-primary mt-2">
                        <span wire:loading wire:target="chargeB2B">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                        Transfer
                    </button>
                </div>
            </div>
        </div>

        <!-- Reverse Transaction Card -->
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header">Reverse Transaction</div>
                <div class="card-body">
                    <label for="transactionId">Transaction ID:</label>
                    <input type="text" id="transactionId" wire:model="transactionId" class="form-control"
                        value="0000000000001">
                    <label for="transactionId">Amount:</label>
                    <input type="text" id="rsamount" wire:model="rsamount" class="form-control">

                    <button wire:click="reverseTransaction" wire:loading.attr="disabled"
                        wire:target="reverseTransaction" class="btn btn-danger mt-2">
                        <span wire:loading wire:target="reverseTransaction">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                        Reverse
                    </button>
                </div>
            </div>
        </div>

        <!-- Query Transaction Card -->
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header">Query Transaction Status</div>
                <div class="card-body">
                    <label for="transactionId">Transaction ID:</label>
                    <input type="text" id="transactionId" wire:model="transactionId" class="form-control">

                    <button wire:click="queryTransactionStatus" wire:loading.attr="disabled"
                        wire:target="queryTransactionStatus" class="btn btn-info mt-2">
                        <span wire:loading wire:target="queryTransactionStatus">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                        Check Status
                    </button>
                </div>
            </div>
        </div>

        <!-- Direct Debit Creation -->
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header">Direct Debit Create</div>
                <div class="card-body">
                    <label for="phoneNumber">Customer Phone:</label>
                    <input type="text" id="phoneNumber" wire:model="ddcphoneNumber" class="form-control">

                    <label for="amount">Amount:</label>
                    <input type="number" id="ddcamount" wire:model="amount" class="form-control">

                    <button wire:click="directDebitCreate" wire:loading.attr="disabled"
                        wire:target="directDebitCreate" class="btn btn-warning mt-2">
                        <span wire:loading wire:target="directDebitCreate">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                        Create Debit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal for Response -->
    @if ($showModal)
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">M-Pesa Response</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <pre>{{ var_dump($response) }}</pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showModal', false)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
