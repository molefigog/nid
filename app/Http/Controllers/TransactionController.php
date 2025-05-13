<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\VclController;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    private $options;

    public function __construct()
    {
        $this->options = [
            'api_key' => config('laravel-pesa.api_key'),
            'public_key' => config('laravel-pesa.public_key'),
            'service_provider_code' => config('laravel-pesa.short_code'),
            'country' => 'LES',
            'currency' => 'LSL',
            'persistent_session' => false,
            'env' => config('laravel-pesa.env')
        ];
    }

    public function charge(Request $request)
    {
        Log::info("Charge route accessed.");
        Log::info("Options for VclController: ", $this->options);

        $number = $request->input('input_CustomerMSISDN');
        $mssid = '266' . $number;

        $vclController = new VclController($this->options);
        $response = $vclController->c2b([
            'input_Amount' => $request->input('input_Amount'),
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_CustomerMSISDN' => $mssid,
            'input_ServiceProviderCode' => config('laravel-pesa.short_code'),
            'input_ThirdPartyConversationID' => 'NID' . rand(),
            'input_TransactionReference' => 'nidptyltd',
            'input_PurchasedItemsDesc' => $request->input('input_PurchasedItemsDesc')
        ]);

        Log::info("Charge response: " . print_r($response, true));
        return response()->json($response);
    }

    public function b2c(Request $request)
    {
        Log::info("B2C route accessed.");
        Log::info("Options for VclController: ", $this->options);

        $number = $request->input('input_CustomerMSISDN');
        $mssid = '266' . $number;

        $vclController = new VclController($this->options);
        $response = $vclController->b2c([
            'input_Amount' => $request->input('input_Amount'),
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_CustomerMSISDN' => $mssid,
            'input_ServiceProviderCode' => config('laravel-pesa.short_code'),
            'input_ThirdPartyConversationID' => 'NID' . rand(),
            'input_TransactionReference' => 'nidptyltd',
            'input_PaymentItemsDesc' => $request->input('input_PaymentItemsDesc')
        ]);

        Log::info("Charge response: " . print_r($response, true));
        return response()->json($response);
    }

    public function b2b(Request $request)
    {
        Log::info("B2B route accessed.");
        Log::info("Options for VclController: ", $this->options);

        $number = $request->input('input_ReceiverPartyCode');
        $mssid =  $number;

        $vclController = new VclController($this->options);
        $response = $vclController->b2b([
            'input_Amount' => $request->input('input_Amount'),
            'input_Country' => 'LES',
            'input_Currency' => 'LSL',
            'input_PrimaryPartyCode' => config('laravel-pesa.short_code'),
            'input_ReceiverPartyCode' => $mssid,
            'input_ThirdPartyConversationID' => 'NID' . rand(),
            'input_TransactionReference' => 'nidptyltd',
            'input_PurchasedItemsDesc' => $request->input('input_PurchasedItemsDesc')
        ]);

        Log::info("Charge response: " . print_r($response, true));
        return response()->json($response);
    }

    public function reverse(Request $request)
    {
        Log::info("Reverse route accessed.");
        Log::info("Options for VclController: ", $this->options);

        $vclController = new VclController($this->options);

        $response = $vclController->reverse([
            'input_ReversalAmount' => $request->input('input_Amount'),
            'input_Country' => 'LES',
            'input_ServiceProviderCode' => config('laravel-pesa.short_code'),
            'input_ThirdPartyConversationID' => 'NID' . rand(),
            'input_TransactionReference' => 'nidptyltd',
            'input_TransactionID' => $request->input('input_TransactionID')
        ]);

        Log::info("Reverse response: " . print_r($response, true));
        return response()->json($response);
    }
}
