<?php

namespace App\Http\Controllers;

use App\Models\MenuManagement;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class ManuManagmentController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 10);
        $menuType = $request->query('menu_type', 'navbar'); // Default to 'navbar' if not specified
        $navigationItems = MenuManagement::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->paginate($itemsPerPage);
        return view('pages.navigation.index', compact('navigationItems', 'itemsPerPage'));
    }

    public function create()
    {
        $parents = MenuManagement::whereNull('parent_id')->pluck('name', 'id');
        return view('pages.navigation.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_management,id',
            'sort_order' => 'required|integer',
            'menu_type' => 'required|string'
        ]);
        // dd('post');
        MenuManagement::create($request->all());

        return redirect()->route('navigation.index')->with('success', 'Item created successfully.');
    }

    public function edit(MenuManagement $navigationItem)
    {
        
        $parents = MenuManagement::whereNull('parent_id')->pluck('name', 'id');
        return view('pages.navigation.edit', compact('navigationItem', 'parents'));
    }

    public function update(Request $request, MenuManagement $navigationItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_management,id',
            'sort_order' => 'required|integer',
            'menu_type' => 'required|string'
        ]);
        $navigationItem->update($request->all());

        return redirect()->route('navigation.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(MenuManagement $navigationItem)
    {
       
        $navigationItem->delete();

        return redirect()->route('navigation.index')->with('success', 'Item deleted successfully.');
    }
}
