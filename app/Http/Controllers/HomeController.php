<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Realm;
use App\Models\Stock;
use App\Models\Vote;
use App\Models\SocialLink;
use App\Models\HowToStart;
use App\Models\Feature;
use App\Models\LanguageSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first();
        $news = News::orderBy('id', 'desc')->limit(4)->get();
        $realms = Realm::where('version', 'lich')->orderBy('id')->get();
        $stocks = Stock::orderBy('id')->get();
        $votes = Vote::orderBy('id')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('id')->get();
        $hts = HowToStart::first();
        $features = Feature::where('status', true)->orderBy('sort')->orderBy('id')->get();
        $activeLangs = LanguageSetting::where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact('settings', 'news', 'realms', 'stocks', 'votes', 'socialLinks', 'hts', 'features', 'activeLangs'));
    }
}
