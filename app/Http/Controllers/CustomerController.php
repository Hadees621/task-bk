<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        return Customers::cursorPaginate(20);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['message' => 'Search query is required'], 400);
        }

        $results = Customers::search($query)->get();

        return response()->json($results);
    }
}
