<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        $post_visit = visits('App\Models\Post');
        $sum_post = Post::count();
        $today  = visits('App\Models\Post')->period('day')->count();
        $week   = visits('App\Models\Post')->period('week')->count();
        $month  = visits('App\Models\Post')->period('month')->count();
        if($request->ajax()) {
            if($request->has('filter-top')) {
                $populer = visits('App\Models\Post')->period($request->get('filter-top'))->top(7);
                return view('back._populer', compact('populer'));
            }
        }

        $populer = visits('App\Models\Post')->period('day')->top(7);

        return view('back.dashboard', compact('sum_post', 'today', 'week', 'month', 'populer'));
    }
}
