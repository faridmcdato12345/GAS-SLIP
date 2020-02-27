<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;

class gmDisapprovedController extends Controller
{
    public function edit($id)
    {
        $applicant = Application::findOrFail($id);
        return response()->json($applicant);
    }
}
