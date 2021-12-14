<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\result;
use App\Models\game;
use App\Models\team;
use Carbon\Carbon;
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

    public function show_popular_players()
    {
        $popular_player = DB:: table('players')->limit(3)->get();
        return response()->json($popular_player);
        
    }
    public function latest_results()
    {   
       
        $last_result = DB::table('results')->latest()->first();
        $score = $last_result->score;
        $teamwinnner = team::find($last_result->winner_team_id);
        $winnerName = $teamwinnner['team_name'];
        $teamtwo = game::where('id',$last_result->game_id)->get('team_two_id');
        $teamtwoId = $teamtwo[0]['team_two_id'];
        $team_two_obj =  team::find($teamtwoId)->get('team_name');
        $team_two_name = $team_two_obj[0]['team_name'];
        $date = game::find($last_result->game_id);
        $date_of_match = $date['date'];
        $time = $date['time'];
        
        return response()->json([
            "winner" => $winnerName,
            "loser" => $team_two_name,
            "score" => $score,
            "date"=> $date_of_match,
            "time"=> $time]);
    }

    public function get_next_matche()
    {
       $date = Carbon::now();
       $date->toDateString();
       $game = game::where('date', '>=', $date)->orderBy('created_at', 'asc')->first();
       $game_time = $game->time;
       $game_date = $game->date;
       $gdate = substr($game_time, 0, -3);
       $team_one = team::find($game->team_one_id);
       $team_one_name = $team_one['team_name'];
       $team_two = team::find($game->team_two_id);
       $team_two_name = $team_two['team_name'];
       return response()->json([
           "team_one" => $team_one_name,
           "team_two" => $team_two_name,
            "date" => $game_date,
            "time" => $gdate ]);
    }

    public function show_all_games()
    {
        $game = game::all();
        foreach($game as $g ){
            $teamone[$g->id]['id'] = $g->id;
            $teamone[$g->id]['team_one'] = team::find($g->team_one_id)->team_name;
            $teamone[$g->id]['team_two'] = team::find($g->team_two_id)->team_name;
            $teamone[$g->id]['date'] = game::find($g->id)->date;
            $teamone[$g->id]['time'] = game::find($g->id)->time;
        }
        return response()->json([$teamone]);

    }
}
