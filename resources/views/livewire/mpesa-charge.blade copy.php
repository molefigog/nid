<div class="container mt-5">
    <!-- Bootstrap Card for the form -->
    <div class="card">
        <div class="card-header">
            <h5>Charge via M-Pesa</h5>
        </div>
        <div class="card-body">
            <!-- Input field for phone number -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number (MSISDN):</label>
                <input type="text" id="phoneNumber" wire:model="phoneNumber" class="form-control" placeholder="Enter phone number">
            </div>

            <!-- Input field for amount -->
            <div class="mb-3">
                <label for="amount" class="form-label">Amount (LSL):</label>
                <input type="number" id="amount" wire:model="amount" class="form-control" placeholder="Enter amount">
            </div>

            <!-- Display validation error messages -->
            @error('phoneNumber')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('amount')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <!-- Button to trigger the charge -->
            <button wire:click="charge" class="btn btn-primary">Charge via M-Pesa</button>
        </div>
    </div>

    <!-- Bootstrap Modal to display the response -->
    @if ($showModal)
        <div class="modal fade show" tabindex="-1" style="display: block;" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">M-Pesa Charge Response</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Response from M-Pesa:</h6>
                        <pre>{{ var_dump($response) }}</pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal backdrop -->
        <div class="modal-backdrop fade show" wire:click="$set('showModal', false)"></div>
    @endif
</div>
