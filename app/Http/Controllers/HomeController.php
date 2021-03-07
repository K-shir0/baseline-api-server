<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $companies = Company::with('prefectures:name')->orderByDesc('created_at',)->limit(4)->get();

        // ログインユーザの取得
        $user = Auth::user();

        // アクティビティを取得し投稿者を表示
        $my_activities = CompanyInformation::query()->with(['my_activities', 'user'])->where('user_id', 'like', $user->id)->limit(16)->orderByDesc('created_at')->get();
        $other_activities = CompanyInformation::query()->with('my_activities', 'user')->where('user_id', 'not like', $user->id)->limit(16)->orderByDesc('created_at')->get();

        // my_activityのみ取り出す処理
        $filtered_my_activities = $my_activities->filter(function ($my_activity) {
            return $my_activity->my_activities->isNotEmpty();
        })->slice(0, 3)->flatten();

        $filtered_other_my_activities = $other_activities->filter(function ($my_activity) {
            return $my_activity->my_activities->isNotEmpty();
        })->slice(0, 3)->flatten();

        return response()->json([
            "companies" => $companies,
            "my_activities" => $filtered_my_activities,
            "other_activities" => $filtered_other_my_activities
        ]);
    }
}
