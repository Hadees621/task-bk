<?php
namespace App\Http\Controllers;

class LeadController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'LeadController is working!',
            'status'  => 'success',
        ]);
    }

}
