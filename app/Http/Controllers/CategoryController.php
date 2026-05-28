<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // CategoryController@index
public function index(Request $request)
{
    $categories = Category::with('parent')
        ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                                             ->orWhere('slug', 'like', "%{$request->search}%"))
        ->when($request->status !== null && $request->status !== '', fn($q) => $q->where('is_active', $request->status))
        ->when($request->type === 'root', fn($q) => $q->whereNull('parent_id'))
        ->when($request->type === 'sub',  fn($q) => $q->whereNotNull('parent_id'))
        ->paginate(15);

    return view('categories.index', [
        'categories'       => $categories,
        'parentCategories' => Category::whereNull('parent_id')->get(),
        'totalCount'       => Category::count(),
        'activeCount'      => Category::where('is_active', true)->count(),
        'inactiveCount'    => Category::where('is_active', false)->count(),
        'rootCount'        => Category::whereNull('parent_id')->count(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','Category deleted.');
    }
}
