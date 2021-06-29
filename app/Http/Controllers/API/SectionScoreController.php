<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SectionCollection;
use App\SectionScore;
use App\Score;
use App\Sections;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SectionScoreController extends Controller
{
    public function index()
    {
        if(request()->month != null){
            $month = request()->month;
            $sections = Sections::with(
                [
                    'score' => function ($query) use ($month) {
                        $query->where('month', $month);
                    }
                ]
            )->where('code', '<>', '92800')->get();
            return new SectionCollection($sections);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'final_score' => 'required',
            'month' => 'required',
            'section_id' => 'required',
        ]);

        SectionScore::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'final_score' => 'required',
            'month' => 'required',
            'section_id' => 'required',
        ]);

        $sectionScore = SectionScore::whereId($id)->first();
        $sectionScore->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $sectionScore = SectionScore::whereId($id);
        $sectionScore->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function recap(){
        $average_rating = Score::select('section_id','month', DB::raw('avg(final_score) as final_score'))
                            ->groupBy('section_id')
                            ->groupBy('month')
                            ->get();

        for ($i = 0; $i < count($average_rating); $i++)
        {
            $check = SectionScore::select('id')
                ->where('section_id',$average_rating[$i]->section_id)
                ->where('month',$average_rating[$i]->month)
                ->first();

            if($check != null){
                $sectionScore = SectionScore::whereId($check->id)->first();
                $sectionScore->update(['final_score' => $average_rating[$i]->final_score]);
            }else{
                SectionScore::create([
                    'final_score' => $average_rating[$i]->final_score,
                    'month' => $average_rating[$i]->month,
                    'section_id' => $average_rating[$i]->section_id,
                ]);
            }
        }
        return response()->json(['status' => 'success'], 200);
    }
}
