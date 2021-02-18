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
        $my_activities = CompanyInformation::query()->with(['my_activities', 'user'])->where('user_id', 'like', $user->id)->limit(2)->orderByDesc('created_at')->get();
        $other_activities = CompanyInformation::query()->with('my_activities', 'user')->where('user_id', 'not like', $user->id)->limit(3)->orderByDesc('created_at')->get();
//        $my_activities = MyActivity::query()->with('compony_informations.user.desired_occupation', function($query) use ($user) {
//            return $query->where('id', 'like', $user->id);
//        })->limit(2)->get();
//        $other_activities = MyActivity::query()->with('compony_informations.user.desired_occupation', function($query) use($user) {
//            return $query->where('id', 'not like', $user->id);
//        })->limit(2)->get();

        return response()->json([
            "companies" => $companies,
            "my_activities" => $my_activities,
            "other_activities" => $other_activities
        ]);
    }
}
