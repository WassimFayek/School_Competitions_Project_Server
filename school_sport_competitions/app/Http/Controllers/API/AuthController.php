<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\team;
use App\Models\player;
use App\Models\school;
use App\Models\game;
use App\Models\competition;
use App\Models\result;
use Illuminate\Support\Facades\Validator;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendEmail(Request $request){
        $email = $request->email;
        Mail::to($email)->send(new WelcomeMail());  
        return response()->json([
            "message"=> "Email Sent",
            new WelcomeMail(),
        ],201);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
           
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password),
              'role'    => 2,
              'school_id' => -1,
             ]
            
        ));
        $this -> sendEmail($request);
        return response()->json([
            'status' => true,
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function register_coach(Request $request)
    {
        $coordinator = auth()->user();//->schools;
        //return("schools are " .$coordinator);

        $logged_user = $coordinator->role;
        if($logged_user != 2 ){
            return response()->json(["message"=>"your not allowed to add coach"],201);
        }
        else{
        //return("logger user :" .$logged_user);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
           
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password),
              'role'    => 3,
              'school_id'=> $coordinator->school_id,
             ]
            
        ));
      
        return response()->json([
            'status' => true,
            'message' => 'coach successfully registered',
            'user' => $user
        ], 201);
    }
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function Add_teams(Request $request)
    {
        $coach = auth()->user();
        $logged_user = $coach->role;
        if($logged_user != 3 ){
            return response()->json(["message"=>"your not allowed to add teams"],201);
        }
        else{
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|string|between:2,100',
            'description' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

      
        $team = new team;
        $team->team_name = $request->team_name;
        $team->description = $request->description;
        $team->school_id = $coach->school_id;
        $team->user_id= $coach->id;
        $team->save();
       // return json_encode($team);


        return response()->json([
            'status' => true,
            'message' => 'team successfully registered',
            'team' => $team
        ], 201);
        }
    }


    public function Add_players(Request $request)
    {
        $coach = auth()->user();
        $coach_team = User::find($coach->id)->teams;
        $team_id = $coach_team->pluck('id')->toArray();
        $team_id_string = $team_id[0];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'date_of_birth' => 'required',  
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

       
        $player = new player;
        $player->first_name = $request->first_name;
        $player->last_name = $request->last_name;
        $player->gender = $request->gender;
        $player->class = $request->class;
        $player->age = $request->date_of_birth;
        $player->school_id = $coach->school_id;
        $player->team_id = $team_id_string;
        $player->save();
       // return json_encode($team);


        return response()->json([
            'status' => true,
            'message' => 'Player successfully registered',
            'player' => $player
        ], 201);
    }

    public function Add_schools(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|between:2,200',
            'school_address' => 'required|string|max:200',
            'school_phone' => 'required|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

       
        $school = new school;
        $school->school_name = $request->school_name;
        $school->school_address = $request->school_address;
        $school->school_phone = $request->school_phone;
        $school->save();
       // update the school_id in user table after we inserted the new school
        $user= auth()->user();
        $logged = User::find($user->id);
        $logged->school_id =$school->id;
        $logged->save();
        //return($user);
        return response()->json([
            'status' => true,
            'message' => 'school successfully registered',
            'school' => $school
        ], 201);
    }


    function approveAccount(Request $request){

        $user = auth()->user();
        $logged_user = $user->role;
        if($logged_user != 2 ){
            return response()->json(["message"=>"your not allowed to approve"],201);
        }
        else{
        $school = school::find($request->id);
        $school->is_approved = 1;
        $school->save();
        return response()->json($school);
        }
    }


    function declineAccount(Request $request){
        $user = auth()->user();
        $logged_user = $user->role;
        if($logged_user != 2 ){
            return response()->json(["message"=>"your not allowed to approve"],201);
        }
        else
        {
        $school = school::where('id', $request->id)
                     ->delete();
         return response()->json("This record successfully deleted");
        }
    }

    public function teamsInMatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'competition_id'=> 'required|numeric',
            'team_one_id' => 'required|numeric',
            'team_two_id' => 'required|numeric',
            'date'=> 'required',
            'time'=> 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }
       
        $game = new game;
        $game->competition_id = $request->competition_id;
        $game->team_one_id = $request->team_one_id;
        $game->team_two_id = $request->team_two_id;
        $game->date = $request->date;
        $game->time = $request->time;
        $game->save();


        return response()->json([
            'status' => true,
            'message' => 'game successfully done',
            'school' => $game
        ], 201);



    }

    public function create_competition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|between:2,200',
            'description' => 'required|string|between:2,200',
            'start_date' => 'required|after:today',
            'end_date'=> 'required|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }
       
        $competition = new competition;
        $competition->name = $request->name;
        $competition->description = $request->description;
        $competition->start_date = $request->start_date;
        $competition->end_date = $request->end_date;
        $competition->school_id = -1;
        $competition->save();


        return response()->json([
            'status' => true,
            'message' => 'competition successfully Added',
            'school' => $competition
        ], 201);



    }
    public function set_results(Request $request)
    {
        $results = new result;
        $results->game_id = $request->id;
        $results->score = $request->score;
        $results->winner_team_id = $request->winner_id;
        $results->save();


        return response()->json([
            'status' => true,
            'message' => 'results successfully addded',
            'school' => $results
        ], 201);

    }

    public function show_results()
    {
        $result = result:: all();
        foreach($result as $res){
        $game = $res->game_id;
        $winner_team = $res-> winner_team_id;
        $specific_game = game::find($game);
        $team1 =$specific_game->team_one_id;
        $team2 = $specific_game->team_two_id;
        $team_name1 = team::find($team1)->team_name;
        $team_name2 = team::find($team2)->team_name;
        $team_winner = team::find($winner_team)->team_name;
        return response()->json([
            "winner" => $team_winner,
            "team one " => $team_name1,
            "team two" => $team_name2,
        ]);
        }
    }

   

 



  
}