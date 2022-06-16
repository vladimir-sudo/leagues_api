<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LeaguesApi\LeaguesApi;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    /**
     * @var LeaguesApi
     */
    private $leaguesApi;

    public function __construct()
    {
        $this->leaguesApi = app('leagues_api');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagues(Request $request)
    {
        if ($request->has('start_timestamp')) {
            $leaguesIds = $this->leaguesApi->getLeaguesIdsByDate($request->start_timestamp);
        } else {
            $leaguesIds = $this->leaguesApi->getLeaguesIds();
        }

        return response()->json([
            'leagues' => $leaguesIds,
            'success' => true
        ]);
    }

    /**
     * @param int $leagueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function leaguesById(int $leagueId)
    {
        $league = $this->leaguesApi->getLeagueById($leagueId);

        if (empty($league)) {
            return response()->json([
                'message' => _('Record not found'),
                'success' => false
            ]);
        }

        return response()->json([
            'league_name' => $league->name,
            'success' => true
        ]);
    }
}
