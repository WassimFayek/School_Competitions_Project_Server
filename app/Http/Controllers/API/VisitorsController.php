<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VisitorsController extends Controller
{
    
    public function show_players()
    {
        $player = DB:: table('players')->get();
        return response()->json($player);
        
    }

    public function show_teams()
    {
        $team = DB:: table('teams')->get();
        return response()->json($team);
        
    }
}
