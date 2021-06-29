<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assignments;
use App\Sections;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MonitoringCollection;

class MonitoringController extends Controller
{
    public function index()
    {
        $result = Sections::select('id', 'name')->where('code', '<>', '92800')->get();
        return new MonitoringCollection($result);
    }

    public function getAssignments()
    {
        $result = Assignments::with('user_to', 'activity')->where('section_id', request()->sectionid)->orderBy('finish_date', 'DESC')->get();
        return new MonitoringCollection($result);
    }
}
