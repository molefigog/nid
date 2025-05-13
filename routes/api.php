<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\QouteController;
use App\Http\Controllers\FrontendController;
use App\Models\Company;
use App\Models\Transaction;
use App\Models\SoldItemsCollection;
use App\Models\Qoute;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\AuthController;
// 🔒 JWT-protected user info
// Route::middleware('auth:api')->get('/user', fn(Request $request) => $request->user());
Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::prefix('auth:sanctum')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::middleware('auth:sanctum')->get('/check-access', function (Request $request) {
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $exist = User::where('id', $user->id)->exists();
    if ($exist) {
        return response()->json(['access' => true]);
    } else {
        return response()->json(['access' => false], 403);
    }
});

Route::get('/seo', function () {
    $seo = Company::orderBy('created_at', 'desc')
        ->select('name', 'address', 'phone', 'vat', 'email', 'logo')
        ->first();
    return response()->json($seo);
});

Route::middleware('auth:sanctum')->get('/me', fn(Request $request) => $request->user());
Route::middleware('auth:sanctum')->put('/me', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/charge', [TransactionController::class, 'charge']);
Route::get('/b2c', [TransactionController::class, 'b2c']);
Route::get('/b2b', [TransactionController::class, 'b2b']);
Route::put('/reverse', [TransactionController::class, 'reverse']);


// Route::middleware('auth:sanctum')->group(function () {
// Products
Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products/update-stock', [ProductsController::class, 'updateStock']);
Route::get('/products/{productId}/stock-history', [ProductsController::class, 'getHistory']);
Route::get('/products/stock-history', [ProductsController::class, 'getStockHistory']);

// Product CRUD
Route::prefix('products')->group(function () {
    Route::post('/', [ProductsController::class, 'store']);
    Route::put('/{id}', [ProductsController::class, 'update']);
    Route::delete('/{id}', [ProductsController::class, 'delete']);
});

// Categories
Route::get('/categories', [ProductsController::class, 'categories']);

// Transactions
Route::post('/transactions', [ProductsController::class, 'invoice']);
Route::get('/transactions/latest', [ProductsController::class, 'latest']);
// });
Route::post('/collections', [ProductsController::class, 'SoldItemsColletion']);
Route::get('/collections/latest', [ProductsController::class, 'latestCollection']);
// Route::get('/transactions', function () {
//     return Transaction::select('id', 'invoice_number', 'total')->orderBy('id', 'desc')->get();
// });
Route::get('/transactions', function (Request $request) {
    $query = Transaction::select('id', 'invoice_number', 'total', 'created_at');
    if ($request->has('search') && $request->search) {
        $query->where('invoice_number', 'like', '%' . $request->search . '%');
    }
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }
    $transactions = $query->orderBy('id', 'desc')->get();
    return response()->json($transactions);
});
Route::get('/collections_index', function (Request $request) {
    $query = SoldItemsCollection::select('id', 'invoice_number', 'total', 'created_at', 'customer', 'original_receipt_date');
    if ($request->has('search') && $request->search) {
        $query->where('invoice_number', 'like', '%' . $request->search . '%');
    }
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }
    $transactions = $query->orderBy('id', 'desc')->get();
    return response()->json($transactions);
});

Route::get('/qoutes', [QouteController::class, 'index']);
Route::post('qoutes_save', [QouteController::class, 'store']);
Route::put('qoutes/{id}', [QouteController::class, 'update']);
Route::get('/invoice-sequence', [ProductsController::class, 'getInvoiceSequence']);
Route::get('/qoute/{id}', function ($id) {
    return Qoute::findOrFail($id);
});
Route::post('/refunds', [ProductsController::class, 'refund']);
Route::put('/products/{product}/restock', [ProductsController::class, 'restock']);
Route::get('/qoute', [ProductsController::class, 'latestQ']);
Route::get('/qoutes/search', [QouteController::class, 'search']);
Route::get('/transactions/{id}', function ($id) {
    $transaction = App\Models\Transaction::findOrFail($id);
    return response()->json($transaction);
});
Route::get('/collections/{id}', function ($id) {
    $transaction = App\Models\SoldItemsCollection::findOrFail($id);
    return response()->json($transaction);
});
// New endpoint to fetch company details
Route::get('/company', function () {
    $company = App\Models\Company::first();

    // Prepare the company data
    return response()->json([
        'name' => $company->name,
        'address' => $company->address,
        'vat_number' => $company->vat,
        'contact' => $company->phone,
        'email' => $company->email,
        'bank' => $company->bank,
        'acc' => $company->acc,
        'branch_code' => $company->branch_code,
        'logo' => asset('img/' . $company->logo),

    ]);
});
Route::post('/generate-opening-stock', function (Request $request) {
    Artisan::call('stock:set-opening');
    return response()->json(['message' => 'Opening stock generated successfully']);
});

Route::post('/generate-closing-stock', function (Request $request) {
    Artisan::call('stock:set-closing');
    return response()->json(['message' => 'Closing stock generated successfully']);
});
Route::get('/company1', [FrontendController::class, 'index']);
Route::post('/company1', [FrontendController::class, 'store']);
Route::put('/company1/{id}', [FrontendController::class, 'update']);
