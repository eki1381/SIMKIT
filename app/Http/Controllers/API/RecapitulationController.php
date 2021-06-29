<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Assignments;
use Excel;
use App\Http\Resources\AssignmentCollection;
use Illuminate\Support\Facades\Log;
use App\Exports\AssignmentExport;

class RecapitulationController extends Controller
{
    public function index()
    {
        $recapitulations = Assignments::with(['activity'])
                            ->where('assignments.user_to_id', request()->q)
                            ->where('assignments.is_finished', 'LIKE', 'Sudah selesai')
                            ->whereMonth('assignments.collect_date', request()->m)->get();
        return new AssignmentCollection($recapitulations);
    }

    public function download()
    {
        return (new AssignmentExport(request()->id, request()->ein, request()->name, request()->position, request()->period, request()->month, request()->section))->download('ckp.xlsx');
    }
}