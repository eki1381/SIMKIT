<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\PersonScore;
use App\Score;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonScoreController extends Controller
{
    public function index()
    {
        if(request()->month != null){
            $month = request()->month;
            $users = User::with(
                [
                    'position',
                    'score' => function ($query) use ($month) {
                        $query->where('month', $month);
                    }
                ]
            )->whereHas('position', function ($query) {
                $query->where('code', '<>', '100');
            })->orderBy('ein', 'ASC')->get();
            return new UserCollection($users);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'final_score' => 'required',
            'month' => 'required',
            'user_id' => 'required',
        ]);

        PersonScore::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'final_score' => 'required',
            'month' => 'required',
            'user_id' => 'required',
        ]);

        $personScore = PersonScore::whereId($id)->first();
        $personScore->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $personScore = PersonScore::whereId($id);
        $personScore->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function recap()
    {
        $average_rating = Score::select('user_to_id as user_id','month', DB::raw('avg(final_score) as final_score'))
                            ->groupBy('user_to_id')
                            ->groupBy('month')
                            ->get();
        
        for ($i = 0; $i < count($average_rating); $i++)
        {
            $check = PersonScore::select('id')
                ->where('user_id',$average_rating[$i]->user_id)
                ->where('month',$average_rating[$i]->month)
                ->first();

            if($check != null){
                $personScore = PersonScore::whereId($check->id)->first();
                $personScore->update(['final_score' => $average_rating[$i]->final_score]);
            }else{
                PersonScore::create([
                    'final_score' => $average_rating[$i]->final_score,
                    'month' => $average_rating[$i]->month,
                    'user_id' => $average_rating[$i]->user_id,
                ]);
            }
        }
        return response()->json(['status' => 'success'], 200);
    }
}