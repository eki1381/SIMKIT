<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignments;
use App\Http\Resources\ProcessingCollection;

class ProcessingController extends Controller
{
    public function index()
    {
        $processing = Assignments::with(['user_from', 'section', 'activity'])->orderBy('id', 'ASC');
        if (request()->q != '') {
            $processing = $processing->where('user_to', 'LIKE', getUserIdLogin());
        }
        return new ProcessingCollection($processing->get());
    }

    function getUser(Request $request)
    {
       return json_encode($request->user());
    }
}
