<?php
namespace App\Http\Controllers;

use App\Models\AchievementModel;
use App\Models\CompetitionModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\RekomendasiModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications(): JsonResponse
    {
        $user          = Auth::user();
        $notifications = [
            'data'  => [],
            'total' => 0,
        ];

        if ($user->hasRole('ADM')) {
            $pending_achievements                          = AchievementModel::where('status', 'pending')->count();
            $pending_competitions                          = CompetitionModel::where('status', 'pending')->count();
            $notifications['data']['pending_achievements'] = $pending_achievements;
            $notifications['data']['pending_competitions'] = $pending_competitions;
            $notifications['total']                        = $pending_achievements + $pending_competitions;
        } elseif ($user->hasRole('MHS')) {
            $mahasiswa                                         = MahasiswaModel::where('user_id', $user->user_id)->first();
            $recommended                                       = RekomendasiModel::where('nim', $mahasiswa->nim)->with('lomba')->get();
            $rejected_comp                                     = CompetitionModel::where('user_id', $user->user_id)->where('status', 'rejected')->get();
            $rejected_ach                                      = AchievementModel::where('mahasiswa_id', $mahasiswa->nim)->where('status', 'rejected')->get();
            $notifications['data']['recommended_competitions'] = $recommended;
            $notifications['data']['rejected_competitions']    = $rejected_comp;
            $notifications['data']['rejected_achievements']    = $rejected_ach;
            $notifications['total']                            = $recommended->count() + $rejected_comp->count() + $rejected_ach->count();
        } elseif ($user->hasRole('DP')) {
            $dosen                                          = DosenModel::where('user_id', $user->user_id)->first();
            $rejected_comp                                  = CompetitionModel::where('user_id', $user->user_id)->where('status', 'rejected')->get();
            $students                                       = MahasiswaModel::where('dosen_id', $dosen->nidn)->pluck('nim');
            $pending_ach                                    = AchievementModel::whereIn('mahasiswa_id', $students)->where('status', 'pending')->count();
            $notifications['data']['rejected_competitions'] = $rejected_comp;
            $notifications['data']['pending_achievements']  = $pending_ach;
            $notifications['total']                         = $rejected_comp->count() + $pending_ach;
        }

        return response()->json($notifications);
    }
}
