<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignments;
use App\Sections;
use App\SectionScore;
use App\Http\Resources\MonitoringCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        return new MonitoringCollection(array(
            'finish_chart' => $this->getFinishChart(),
            'section_chart' => $this->getSectionChart(),
            'section_score_chart' => $this->getSectionScoreChart(request()->month),
            'recent_assignment' => $this->getRecentAssignment(),
        ));
    }

    public function getFinishChart(){
        $user = Auth::user();
        $result = [];
        if($user->position()->get()[0]->type != 1){
            $notFinishedAssignments = Assignments::where('user_to_id', $user->id)
                            ->where('is_finished', 'Belum selesai')->count();
            $pendingAssignments = Assignments::where('user_to_id', $user->id)
                            ->where('is_finished', 'Menunggu pengecekan')->count();
            $finishedAssignments = Assignments::where('user_to_id', $user->id)
                            ->where('is_finished', 'Sudah selesai')->count();
            $result = array($notFinishedAssignments, $pendingAssignments, $finishedAssignments);
        }else{
            $notFinishedAssignments = Assignments::where('is_finished', 'Belum selesai')->count();
            $pendingAssignments = Assignments::where('is_finished', 'Menunggu pengecekan')->count();
            $finishedAssignments = Assignments::where('is_finished', 'Sudah selesai')->count();
            $result = array($notFinishedAssignments, $pendingAssignments, $finishedAssignments);
        }
        return $result;
    }

    public function getSectionChart(){
        $user = Auth::user();
        $result = [];
        $sections = Sections::where('code', '<>', '92800')->get();
        if($user->position()->get()[0]->type != 1){
            for($i = 0;$i < sizeof($sections);$i++){
                $assignment = Assignments::where('user_to_id', $user->id)->where('section_id', $sections[$i]->id)->count();
                $result[$i] = $assignment;
            }
        }else{
            for($i = 0;$i < sizeof($sections);$i++){
                $assignment = Assignments::where('section_id', $sections[$i]->id)->count();
                $result[$i] = $assignment;
            }
        }
        $name = Sections::select('name')->where('code', '<>', '92800')->pluck('name');
        $color = Sections::select('color')->where('code', '<>', '92800')->pluck('color');
        return array($result, $name, $color);
    }

    public function getSectionScoreChart($month){
        $sections = Sections::where('code', '<>', '92800')->get();
        $results = Sections::where('code', '<>', '92800')->with(
            [
                'score' => function ($query) use ($month) {
                    $query->where('month', $month);
                }
            ]
        )->get();
        for($i = 0;$i < sizeof($sections);$i++){
            if($results[$i]->score == null){
                $result[$i]['x'] = $results[$i]->name;
                $result[$i]['y'] = 0;
                $result[$i]['fillColor'] = $results[$i]->color;
            }else{
                $result[$i]['x'] = $results[$i]->name;
                $result[$i]['y'] = (float) $results[$i]->score->final_score;
                $result[$i]['fillColor'] = $results[$i]->color;
            }
        }
        return array($result);
    }

    public function getRecentAssignment(){
        $result = Assignments::with('section', 'user_from', 'user_to')->orderBy('updated_at', 'DESC')->take(20)->get();
        return array($result);
    }
}
