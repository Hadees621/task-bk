<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customers::cursorPaginate(20);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json(['message' => 'Search query is required'], 400);
        }

        $results = Customers::search($query)->get();

        return response()->json($results);
    }
}
