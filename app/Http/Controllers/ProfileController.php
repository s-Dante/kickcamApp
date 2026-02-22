<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            $user->load(['badges', 'customization']);
        }
        return view('profile.index', compact('user'));
    }
}
