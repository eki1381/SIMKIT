<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityCollection;
use App\Activities;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activities::with(['section'])->orderBy('id', 'ASC');
        if (request()->q != '') {
            $activities = $activities->where('name', 'LIKE', '%' . request()->q . '%');
        }
        return new ActivityCollection($activities->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|numeric|digits_between:4,4',
            'name' => 'required|string|max:100',
            'volumeUnit' => 'required|string|max:20',
            'timeUnit' => 'required|string|max:20',
        ]);

        Activities::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|numeric|digits_between:4,4',
            'name' => 'required|string|max:100',
            'volumeUnit' => 'required|string|max:20',
            'timeUnit' => 'required|string|max:20',
        ]);

        $activity = Activities::whereId($id)->first();
        $activity->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $activity = Activities::whereId($id);
        $activity->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function getActivitiesBySection($id)
    {
        $activities = Activities::with(['section'])->orderBy('id', 'ASC')->where('section_id', $id);
        return new ActivityCollection($activities->get());
    }
}
