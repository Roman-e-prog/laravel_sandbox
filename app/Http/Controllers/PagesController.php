<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    
    public function home()
    {
        //hier Setze ich die Werte, die ich in der Web.php übergebe, statische werte
    //     $name = "Roman";
    //      $users = [
    //     ['name' => 'Roman', 'age' => 30],
    //     ['name' => 'Anna', 'age' => 25],
    //     ['name' => 'Leo', 'age' => 40]
    // ];
    //     return view('home', ['name'=>$name, 'age'=>30, 'skills'=>['Laravel', 'React', 'Typescript'], 'users'=>$users]);
    $title = [
        'blogTitle' => 'Programmieren für Ü 40',
        'blogAuthor'=> 'Roman Armin Rostock',
    ];
    return view('home', ['title'=>$title]);
    }

    public function about()
    {
        return view('about');
    }
    public function register()
    {
        return view('register');
    }
    public function login()
    {
        return view('login');
    }
    public function passwordForgotten()
    {
        return view('password-forgotten');
    }
    public function passwordReset()
    {
        return view('password-reset');
    }
    public function forum()
    {
        $ressorts = [
            "HTML",
            "CSS",
            "Laravel",
            "JavaScript",
            "React", 
        ];
        return view('forum', ['ressorts'=> $ressorts]);
    }
    public function dashboard()
    {
        return view('dashboard.dashboard');
    }
    public function myAccount()
    {
        return view('myAccount.myAccount');
    }
}
