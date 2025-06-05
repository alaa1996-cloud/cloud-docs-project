<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // تأكد من وجود الميدلوير للادمن
    }

    public function index()
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'documentsCount' => Document::count(),
            'categoriesCount' => Category::count(),
            'latestDocuments' => Document::latest()->take(5)->get(),
        ]);
    }
}
