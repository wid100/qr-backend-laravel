<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Color';
        $colors = Color::all();
        return view('admin.color.index', compact('colors'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Create Color';
        return view('admin.color.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);
        $color = new Color();
        $color->name = $validatedData['name'];
        $color->code = $validatedData['code'];
        $status = $request->has('status') ? true : false;
        $color->status = $status;
        $color->save();

        return redirect()->route('admin.color.index')->with('success', 'Color Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Color';
        $color = Color::find($id);
        return view('admin.color.edit', compact('color'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',

        ]);
        $color = Color::findOrFail($id);
        $color->name = $validatedData['name'];
        $color->code = $validatedData['code'];

        $status = $request->has('status') ? true : false;
        $color->status = $status;
        $color->save();

        return redirect()->route('admin.color.index')->with('success', 'Color Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        $color->delete();
        return redirect()->route('admin.color.index')->with('success', 'Color Deleted Successfully');
    }
}