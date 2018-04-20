<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Timetable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',[
            'records' => Timetable::where('user_id',Auth::id())->orderBy('from','DESC')->paginate(31),
        ]);
    }
    
    public function show(Reuqest $request){
        
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'note' => 'max:512'
        ]);
        
        $record = new Timetable();
        $record->user_id = Auth::id();
        $record->from = $request->from;
        $record->to = $request->to;
        $record->note = $request->note;
        $record->save();
        
        return back()->with('status','Success!');
    }
    
    public function update($id,Request $request){
        $record = Timetable::find($id);
        
        if($record->user_id != Auth::id()){
            return back()->with('status','Something went wrong. Refresh and try again...');
        }
        
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'note' => 'max:512'
        ]);
        $record->user_id = Auth::id();
        $record->from = $request->from;
        $record->to = $request->to;
        $record->note = $request->note;
        $record->save();
        
        return back()->with('status','Success!');
    }
    
    public function destroy($id,Request $request) {
        $record = Timetable::find($id);
        
        if($record->user_id != Auth::id()){
            return back()->with('status','Something went wrong. Refresh and try again...');
        }
        
        Timetable::destroy($id);
        return back()->with('status','Success!');
    }
    
    public function settings() {
        return view('settings');
    }
    
    public function updatePassword(Request $request){
        $user = User::find(Auth::id());
        if(!password_verify($request->old_password, $user->password)){
            return back()->with('status','The old password you have entered does not math our records!');
        }
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/')->with('status','Success!');
    }
}
