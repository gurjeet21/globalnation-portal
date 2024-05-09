<?php

namespace App\Http\Controllers;

use App\Models\InterocitorMember;
use App\Models\InterocitorMemberDevices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterociterMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (\Auth::user()->role == 'Admin' || \Auth::user()->role == 'Super Admin') {
            $currentPage = $request->query('page', 1);
            $itemsPerPage = $request->query('itemsPerPage', 10); // Default to 10 items per page if not specified
            $members = InterocitorMember::orderBy('last_time', 'desc')->paginate($itemsPerPage);
            return view('pages.interocitor-members', compact('members', 'itemsPerPage'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function sortData(Request $request)
{
    $sortBy = $request->input('sortBy');
    $sortDirection = $request->input('sortDirection');
    $itemsPerPage = $request->query('itemsPerPage', 10);
    $members = InterocitorMember::with('devices')->orderBy($sortBy, $sortDirection)->get();
    return response()->json($members);
}
}
