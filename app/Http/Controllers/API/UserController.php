<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['position', 'score'])->orderBy('ein', 'ASC');
        if (request()->q != '') {
            $users = $users->where('name', 'LIKE', '%' . request()->q . '%');
        }
        return new UserCollection($users->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'ein' => 'required|numeric',
            'section_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'photo' => 'required',
        ]);

        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'ein' => $request->ein,
                    'section_id' => $request->section_id,
                    'position_id' => $request->position_id,
                    'photo' => $request->photo,
                ]);
        return response()->json(['status' => 'success', 'id' => $user->id], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'ein' => 'required|numeric',
            'section_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'photo' => 'required',
        ]);

        $user = User::whereId($id)->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ein' => $request->ein,
            'section_id' => $request->section_id,
            'position_id' => $request->position_id,
            'photo' => $request->photo,
        ]);
        return response()->json(['status' => 'success', 'id' => $id], 200);
    }

    public function storeRegToken(Request $request)
    {
        $user = Auth::user();
        $user->update(['reg_token' => $request->reg_token]);

        return response()->json(['status' => 'success'], 200);
    }

    public function getUserLogin()
    {
        $user = Auth::user();
        $user = $user->load(['position', 'score']);
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function getUsersEchelonStaff()
    {
        $users = User::with(['position', 'score'])->whereHas('position', function($q){
            $q->where('section_id', '<>', 1);
        });
        return new UserCollection($users->get());
    }

    public function destroy($id)
    {
        $user = User::whereId($id);
        $user->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
