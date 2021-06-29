<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AssignmentCollection;
use App\Assignments;

class ScoreController extends Controller
{
    public function countVolumeScore($id){
        $volume = Assignments::whereId($id)->get(['volume', 'realization'])->first();
        $target = $volume->volume;
        $realization = $volume->realization;

        $compare = ($realization/$target)*100;
        if($compare >= 95){
            return 4;
        }else if($compare >=80 && $compare <= 94){
            return 3;
        }else if($compare >=60 && $compare <= 79){
            return 2;
        }else if($compare < 60){
            return 1;
        }
    }

    public function countTimeScore($id){
        $date = Assignments::whereId($id)->get(['finish_date', 'collect_date'])->first();
        $finish_date = new Carbon($date->finish_date);
        $collect_date = new Carbon($date->collect_date);
        $difference = $collect_date->diff($finish_date)->days;

        if($difference >= 2){
            return 4;
        }else if($difference >= 1 && $difference < 2){
            return 3;
        }else if($difference < 1 && $difference >= 0){
            return 2;
        }else{
            return 1;
        }
    }

    public function getMonth($id){
        $date = Assignments::whereId($id)->get(['collect_date'])->first();
        $collect_date = new Carbon($date->collect_date);
        return $collect_date->month;
    }

    public function getYear($id){
        $date = Assignments::whereId($id)->get(['collect_date'])->first();
        $collect_date = new Carbon($date->collect_date);
        return $collect_date->year;
    }

    public function countFinalScore(Request $request, $id){
        $volumeScore = countVolumeScore($id);
        $timeScore = countTimeScore($id);
        $finalScore = 0.7*$volumeScore+0.3*$timeScore;
        $month = getMonth($id);

        Score::create([
            'volume_score' => $volumeScore, 
            'time_score' => $timeScore, 
            'final_score' => $finalScore, 
            'month' => $month,
            'assignment_id' => $request->assignment_id,
            'user_to_id' => $request->user_to_id,
            'user_from_id' => $request->user_from_id,
            'section_id' => $request->section_id]);

        return response()->json(['status' => 'success'], 200);
    }
}
