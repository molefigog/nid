<?php

namespace App\Livewire;

use Livewire\Component;
use Openpesa\Pesa\Facades\Pesa;
use Illuminate\Support\Facades\log;
class MPesaCharge extends Component
{
    public $c2bphoneNumber;
    public $b2cphoneNumber;
    public $ddcphoneNumber;
    public $ddpphoneNumber;
    public $c2bamount;
    public $b2camount;
    public $b2bamount;
    public $ddcamount;
    public $ddamount;
    public $rsamount;
    public $showModal = false;
    public $response;

    // B2B additional fields
    public $businessAccount;

    // Query & Reverse additional fields
    public $transactionId ='0000000000001';

    public function chargeC2B()
    {
        $this->response = Pesa::c2b([
            'input_Amount' => $this->c2bamount,
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_CustomerMSISDN' => '266' . $this->c2bphoneNumber,
            'input_ServiceProviderCode' => '000000',
            'input_ThirdPartyConversationID' => uniqid(),
            'input_TransactionReference' => uniqid(),
            'input_PurchasedItemsDesc' => 'Test Item',
        ]);

        $this->showModal = true;
    }

    public function chargeB2C()
    {
        try {
            $this->response = Pesa::b2c([
                'input_Amount' => $this->b2camount,
                'input_Country' => 'LES',
                'input_Currency' => 'LSL',
                'input_CustomerMSISDN' =>'266' .  $this->b2cphoneNumber,
                'input_ServiceProviderCode' => '000000',
                'input_ThirdPartyConversationID' => 'asv02e5958774f7ba228d83d0d689761',
                'input_TransactionReference' => 'T12344C',
                'input_PaymentItemsDesc' => 'Salary payment'
            ]);

            Log::info('M-Pesa B2C Response:', ['response' => $this->response]);

        } catch (\Exception $e) {
            Log::error('M-Pesa B2C Error: ' . $e->getMessage());

        }
    }


    public function chargeB2B()
{
    try {
        Log::info('Charge B2B function started');

        $requestData = [
            'input_Amount' => $this->b2bamount,
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_PrimaryPartyCode' => $this->businessAccount,
            'input_ReceiverPartyCode' => '000001',
            'input_ThirdPartyConversationID' => 'asv02e5958774f7ba228d83d0d689761',
            'input_TransactionReference' => 'T12344C',
            'input_PurchasedItemsDesc' => 'Shoes'
        ];

        Log::info('M-Pesa B2B Request Data:', $requestData);

        $this->response = Pesa::b2b($requestData);

        Log::info('M-Pesa B2B Response:', ['response' => $this->response]);

        if (empty($this->response)) {
            Log::error('M-Pesa B2B Response is NULL!');
        }

        $this->showModal = true;
    } catch (\Exception $e) {
        Log::error('M-Pesa B2B Error:', ['message' => $e->getMessage()]);
        dd($e->getMessage()); // Show error on screen
    }
}

    public function reverseTransaction()
    {
        $this->response = Pesa::reverse([

            'input_Country' => 'LES',
            'input_ReversalAmount' => $this->rsamount,
            'input_ServiceProviderCode' => '000000',
            'input_ThirdPartyConversationID' => 'sv02e5958774f7ba228d83d0d689761',
            'input_TransactionID' => $this->transactionId,
        ]);

        $this->showModal = true;
    }

    public function queryTransactionStatus()
    {
        $this->response = Pesa::query([
            'input_TransactionID' => $this->transactionId,
        ]);

        $this->showModal = true;
    }

    public function directDebitCreate()
    {
        $this->response = Pesa::ddc([
            'input_Amount' => $this->ddcamount,
            'input_CustomerMSISDN' => '266' . $this->ddcphoneNumber,
        ]);

        $this->showModal = true;
    }

    public function directDebitPayment()
    {
        $this->response = Pesa::ddp([
            'input_Amount' => $this->ddpamount,
            'input_CustomerMSISDN' => '266' . $this->ddpphoneNumber,
        ]);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.mpesa-charge');
    }
}
