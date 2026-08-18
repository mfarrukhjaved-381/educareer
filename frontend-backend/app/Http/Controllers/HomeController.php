<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_page()
    {
        return view('home.index');
    }

    public function courses()
    {
        return view('home.courses');
    }
    public function about_area()
    {
        return view('home.about-area');
    }

    public function coursers_details()
    {
        return view('home.coursers_details');
    }

    public function element()
    {
        return view('home.element');

    }

    public function blog()
    {
        return view('home.blog');
    }

    public function single_blog()
    {
        return view('home.single-blog');
    }

    public function contact_page()
    {
        return view('home.contact');

    }







}
