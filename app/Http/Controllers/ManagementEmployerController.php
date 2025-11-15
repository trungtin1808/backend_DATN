<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;

class ManagementEmployerController extends Controller
{
    public function employers()
    {
        $employers = Employer::all();

        if ($employers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No employers found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $employers,
        ], 200);
    }

    public function show(string $id)
    {
        $employer = Employer::find($id);

        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $employer,
        ], 200);
    }

    // them chuc nang bann/unban/duyet tai khoan
    
}
