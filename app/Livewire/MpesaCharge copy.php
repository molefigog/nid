<?php

namespace App\Livewire;

use Livewire\Component;
use Openpesa\Pesa\Facades\Pesa;

class MpesaCharge extends Component
{
    public $phoneNumber; // To store the user's phone number
    public $amount; // To store the amount the user wants to charge
    public $response; // To store the response from the charge
    public $showModal = false; // To control the visibility of the modal

    // Method to handle charging
    public function charge()
    {
        $this->validate([
            'phoneNumber' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
        ]);

        $this->response = Pesa::c2b([
            'input_Amount' => $this->amount,
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_CustomerMSISDN' => '266' . $this->phoneNumber,
            'input_ServiceProviderCode' => '000000',
            'input_ThirdPartyConversationID' => 'rasderekf',
            'input_TransactionReference' => 'asdodfdferre',
            'input_PurchasedItemsDesc' => 'Test Item'
        ]);

        // Show the modal after receiving the response
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.mpesa-charge');
    }
}
