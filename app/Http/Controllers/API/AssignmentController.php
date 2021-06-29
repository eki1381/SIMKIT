<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AssignmentCollection;
use App\Http\Resources\ScoreCollection;
use App\Assignments;
use App\Notifications;
use App\User;
use App\Score;
use Carbon\Carbon;
use App\Notifications\AssignmentNotification;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignments::with(['user_to', 'user_from', 'section', 'activity'])->orderBy('id', 'ASC');
        if (request()->p != '') {
            $assignments = $assignments->where('user_from_id', 'LIKE', request()->p);
        }else if(request()->q != '') {
            $assignments = $assignments->where('user_to_id', 'LIKE', request()->q);
        }
        return new AssignmentCollection($assignments->get());
    }

    public function store(Request $request)
    {
        $request->merge(["is_finished"=>"Belum selesai"]);
        $request->merge(["user_from_id"=>Auth::user()->id]);
        $request->merge(["section_id"=>Auth::user()->section_id]);
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'volume' => 'required|numeric',
            'start_date' => 'required',
            'finish_date' => 'required',
            'is_finished' => 'required',
            'activity_id' => 'required',
            'user_from_id' => 'required',
            'user_to_id' => 'required',
            'section_id' => 'required',
        ]);
        $assignments = Assignments::create($request->except(['file']));
        if($assignments){
            $recipients = User::select('reg_token')
                            ->where('id', $request->user_to_id)
                            ->value('reg_token');

            $photo = User::select('photo')
                            ->where('id', $request->user_from_id)
                            ->value('photo');

            if(Carbon::parse($request->finish_date)->subDays(1)->gte(Carbon::now())){
                $assignments->notifyAt(
                    new AssignmentNotification($assignments), 
                    Carbon::parse($request->finish_date)->subDays(1)
                );
            }

            $this->sendNotification(
                $recipients, 
                'Ada tugas baru nih!', 
                $assignments->name, 
                $assignments->user_to_id, 
                $photo);
        }
        return response()->json(['status' => 'success', 'data' => $assignments], 200);
    }

    public function update(Request $request, $id)
    {
        $request->merge(["is_finished"=>"Belum selesai"]);
        $request->merge(["user_from_id"=>Auth::user()->id]);
        $request->merge(["section_id"=>Auth::user()->section_id]);
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'volume' => 'required|numeric',
            'start_date' => 'required',
            'finish_date' => 'required',
            'is_finished' => 'required',
            'file_path' => 'string',
            'activity_id' => 'required',
            'user_from_id' => 'required',
            'user_to_id' => 'required',
            'section_id' => 'required',
        ]);
        $assignments = Assignments::whereId($id)->first();
        $assignments->update($request->except(['file']));
        $scores = Score::where('assignment_id',$assignments->id);
        if($scores != null){
            $scores->delete();
        }
        $recipients = User::select('reg_token')
                    ->where('id', $request->user_to_id)
                    ->value('reg_token');

        $photo = User::select('photo')
                    ->where('id', $request->user_from_id)
                    ->value('photo');

        $this->sendNotification(
            $recipients, 
            'Ada tugasmu yang diubah tuh!', 
            $assignments->name,
            $assignments->user_to_id,
            $photo);

        return response()->json(['status' => 'success'], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $assignments = Assignments::whereId($id)->first();
        if($request->is_finished == "Belum selesai"){
            $assignments->update($request->all());
            $scores = Score::where('assignment_id',$assignments->id);
            if($scores != null){
                $scores->delete();
            }
        }else if($request->is_finished == "Sudah selesai"){
            $assignments->update($request->all());

            $recipients = User::select('reg_token')
                            ->where('id', $assignments->user_to_id)
                            ->value('reg_token');

            $photo = User::select('photo')
                            ->where('id', $assignments->user_from_id)
                            ->value('photo');

            $this->sendNotification(
                $recipients, 
                'Horee! Tugasmu sudah dinilai', 
                $assignments->name,
                $assignments->user_to_id, 
                $photo);
            $this->countFinalScore($id, $assignments->id, $assignments->user_to_id, $assignments->user_from_id, $assignments->section_id);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function upload(Request $request, $id)
    {
        if($request->hasFile('file')){
            $realization = $request->realization;
            $comment = $request->comment;
            $file = $request->file('file');
            $file_path = Storage::disk('bukti')->put('/', $file);
            if(substr($file_path, -1) == 'f' || substr($file_path, -1) == 'F' ){
                $collect_date = $request->collect_date;
                $assignments = Assignments::whereId($id)->first();
                $assignments->update(['realization' => $realization, 'comment' => $comment, 'file_path' => $file_path, 'is_finished' => "Menunggu pengecekan", 'collect_date' => $collect_date]);
                $recipients = User::select('reg_token')
                                ->where('id', $assignments->user_from_id)
                                ->value('reg_token');
                $photo = User::select('photo')
                                ->where('id', $assignments->user_to_id)
                                ->value('photo');
                $this->sendNotification(
                    $recipients,
                    'Cek tugas yuk!',
                    $assignments->name,
                    $assignments->user_from_id, 
                    $photo);
            }else{
                return response()->json(['status' => 'error'], 504);
            }
        }else{
            $realization = $request->realization;
            $comment = $request->comment;
            $assignments = Assignments::whereId($id)->first();
            $assignments->update(['realization' => $realization, 'comment' => $comment, 'is_finished' => "Belum selesai"]);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function download()
    {
        $file_path = Assignments::whereId(request()->id)->get('file_path')->first()->file_path;
        return Storage::disk('bukti')->download($file_path);
    }

    public function destroy($id)
    {
        $assignments = Assignments::whereId($id);
        $recipients = User::select('reg_token')
                        ->where('id', $assignments->first()->user_to_id)
                        ->value('reg_token');
        $user_to_id = $assignments->first()->user_to_id;
        $assignment_id = $assignments->first()->id;
        $name = $assignments->first()->name;
        $photo = User::select('photo')
                    ->where('id', $assignments->first()->user_from_id)
                    ->value('photo');
        $assignments->delete();
        $this->sendNotification(
            $recipients,
            'Tugasmu baru saja dibatalkan',
            $name,
            $user_to_id,
            $photo);
        return response()->json(['status' => 'success'], 200);
    }

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
        if($collect_date->gt($finish_date)){
            return 1;
        }else{
            if($difference >= 2){
                return 4;
            }else if($difference >= 1 && $difference < 2){
                return 3;
            }else if($difference < 1 && $difference >= 0){
                return 2;
            }
        }
    }

    public function getMonth($id){
        $date = Assignments::whereId($id)->get(['collect_date'])->first();
        $collect_date = new Carbon($date->collect_date);
        return $collect_date->month;
    }

    public function countFinalScore($id, $assignment_id, $user_to_id, $user_from_id, $section_id){
        $volumeScore = $this->countVolumeScore($id);
        $timeScore = $this->countTimeScore($id);
        $finalScore = 0.7*$volumeScore+0.3*$timeScore;
        $month = $this->getMonth($id);
        $test = Score::whereId($assignment_id)->first();
        if($test == null){
            return Score::create([
                'volume_score' => $volumeScore, 
                'time_score' => $timeScore, 
                'final_score' => $finalScore, 
                'month' => $month,
                'assignment_id' => $assignment_id,
                'user_to_id' => $user_to_id,
                'user_from_id' => $user_from_id,
                'section_id' => $section_id]);
        }else{
            return $test->update([
                'volume_score' => $volumeScore, 
                'time_score' => $timeScore, 
                'final_score' => $finalScore, 
                'month' => $month,
                'assignment_id' => $assignment_id,
                'user_to_id' => $user_to_id,
                'user_from_id' => $user_from_id,
                'section_id' => $section_id]);
        }
    }

    public function sendNotification($recipients, $title, $message, $user_id, $icon){
        fcm()
            ->to([$recipients])
            ->priority('high')
            ->timeToLive(10)
            ->notification([
                'title' => $title,
                'body' => $message,
                'image' => $icon,
                'icon' => 'https://simkit.bpsanambas.com/logo_alone_1.png',
                'click_action' => 'https://simkit.bpsanambas.com'
            ])->send();
    
        $notifications = Notifications::create([
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'is_read' => false,
            'user_id' => $user_id,
        ]);
    }
}