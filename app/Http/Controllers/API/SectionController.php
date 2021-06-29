<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SectionCollection;
use App\Sections;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Sections::with(['score'])->orderBy('id', 'ASC');
        if (request()->q != '') {
            $sections = $sections->where('name', 'LIKE', '%' . request()->q . '%');
        }
        return new SectionCollection($sections->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|numeric|digits_between:5,5',
            'name' => 'required|string|max:100',
            'color' => 'required|string',
        ]);

        Sections::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|numeric|digits_between:5,5',
            'name' => 'required|string|max:100',
            'color' => 'required|string',
        ]);

        $section = Sections::whereId($id)->first();
        $section->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $section = Sections::whereId($id);
        $section->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
