<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ViewController extends Controller
{
    // login view
    public function auth(){
        return view('pages.login');
    }

    // registration view
    public function register(){
        return view('pages.register');
    }

    /**
     * user dashboard
     */
    public function dashboard(Request $request){
        $user = $request->user;
        $courses = Course::where('user_id',$user['user_id'])->get();
        return view('pages.user.dashboard',compact('user','courses'));
    }

    /**
     * user course page
     */
    public function course(Request $request){
        $user = $request->user;
        $category = Category::all();
        return view('pages.user.course',compact('user','category'));
    }

}
