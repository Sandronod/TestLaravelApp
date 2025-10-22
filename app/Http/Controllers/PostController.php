<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $user = Post::get();
        dd($user);
        return view('welcome');
    }
}
