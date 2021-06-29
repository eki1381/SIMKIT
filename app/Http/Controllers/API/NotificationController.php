<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignments;
use App\User;
use App\Notifications;
use App\Http\Resources\MonitoringCollection;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $result = Notifications::where('user_id', request()->user)
                    ->where('is_read', false)
                    ->get();
        return new MonitoringCollection([
            'data' => $result
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'is_read' => 'required',
            'user_id' => 'required',
            'assignment_id' => 'required',
        ]);

        Notifications::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request)
    {
        for($i = 0;$i < count($request->all());$i++){
            $notification = Notifications::whereId($request[$i]['id'])->first();
            $notification->update(['is_read' => true]);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $notification = Notifications::whereId($id);
        $notification->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
