<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Page;
use App\Models\Doctor;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $doctors = Doctor::count();
        $pages = Page::count();
        $blogs = Blog::count();
        $tags = Tag::count();
        $blogcategories = Blogcategory::count();
        $categories = Category::count();
        $inquiries = Inquiry::count();
        $pending = Inquiry::where('status', 'pending')->count();
        $completed = Inquiry::where('status', 'completed')->count();
        $canceled = Inquiry::where('status', 'canceled')->count();

        $data = compact('inquiries', 'pending', 'completed', 'canceled', 'categories', 'doctors', 'blogs', 'tags', 'blogcategories', 'pages');
        return view('backend.inc.dashboard', $data);
    }
}
