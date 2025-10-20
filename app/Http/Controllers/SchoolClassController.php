<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();

        return view('admin.classes.index', compact('classes'));
    }
}
