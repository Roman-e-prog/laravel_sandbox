<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class UserController extends Controller
{
    public function showAllUser(Request $request){
        $users = User::all();

    return redirect()->route('dashboard.dashboard', ['users'=>$users])
        ->with('status', 'All users ready');
    }
    public function showAllQuestionsFromUser(Request $request, $id){
        $allQuestions = Post::where('user_id'=== $id)->get();

    return redirect()->route('myAccount.myAccount', ['myQuestions'=>$allQuestions])
        ->with('status', 'All users ready');
    }
}
