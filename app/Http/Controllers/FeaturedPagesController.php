<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use Illuminate\Support\Str;

class FeaturedPagesController extends Controller
{

    public function index(Request $request)
    {
        return view('pages.manage-featured');
    }


    public function add_artists()
    {
        return view('pages.add-artists');
    }

    public function add_featured()
    {
        return view('pages.add-featured');
    }
}
