<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GetMusicXMLController extends Controller
{
    public function getMusicXML(Request $request)
    {
        $user = Auth::user();
        return Storage::get('musicXML/' . $request->input('userID') . '/' . $request->input('fileName'));
    }
}
