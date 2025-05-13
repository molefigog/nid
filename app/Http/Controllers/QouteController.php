<?php

namespace App\Http\Controllers;

use App\Models\Qoute;
use Illuminate\Http\Request;

class QouteController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
            'qoutation_number' => 'required|string',
            'customer' => 'required|string',
        ]);

        $quote = new Qoute();
        $quote->items = $data['items'];
        $quote->total = $data['total'];
        $quote->customer = $data['customer'];
        $quote->qoutation_number = $data['qoutation_number'];
        $quote->save();

        return response()->json([
            'message' => 'Quote created successfully',
            'quote' => $quote,
        ]);
    }

    public function update(Request $request, $id)
    {

        $quote = Qoute::findOrFail($id);
        $data = $request->only(['items', 'total']);

        if (isset($data['items'])) {
            $quote->items = $data['items'];
        }
        if (isset($data['total'])) {
            $quote->total = $data['total'];
        }

        $quote->save();

        return response()->json($quote, 200);
    }

    public function search(Request $request)
    {
        $query = Qoute::query();

        if ($request->has('qoutation_number') && $request->qoutation_number) {
            $query->where('qoutation_number', '=', $request->qoutation_number);
        }

        $quotes = $query->get();
        return response()->json($quotes);
    }


    public function index()
    {
        return Qoute::select('id', 'qoutation_number', 'customer', 'created_at', 'items')
            ->latest()
            ->get();
    }

    public function show(Qoute $qoute)
    {
        return $qoute;
    }
}
