<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function switch($locale) 
    {
        if(in_array($locale, config('app.available_locales'))) {
            cookie()->queue(cookie('locale', $locale, 60*24*30));
        }

        return back();
    }
}
