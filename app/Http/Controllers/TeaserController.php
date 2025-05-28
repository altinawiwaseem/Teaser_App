<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teaser;

class TeaserController extends Controller
{
    public function show($id)
    {
        $teaser = Teaser::findOrFail($id);
        return view('teasers.show', compact('teaser'));
    }
}
