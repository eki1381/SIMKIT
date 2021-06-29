<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PositionCollection;
use App\Positions;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Positions::with(['section'])->orderBy('id', 'ASC');
        if (request()->id != '') {
            $positions = $positions->where('id', request()->id);
        }
        return new PositionCollection($positions->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'section_id' => 'required',
            'code' => 'required|numeric|digits_between:3,3',
            'name' => 'required|string|max:100',
        ]);

        Positions::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'section_id' => 'required',
            'code' => 'required|numeric|digits_between:3,3',
            'name' => 'required|string|max:100',
        ]);

        $position = Positions::whereId($id)->first();
        $position->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $position = Positions::whereId($id);
        $position->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function getId()
    {
        $positions = Positions::whereId(request()->id)->orderBy('created_at', 'DESC');
        
        return new PositionCollection($positions->get());
    }
}
