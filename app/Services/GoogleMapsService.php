<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class GoogleMapsService
{
    public function getDistanceDuration(array $data): JsonResponse
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($data['address_from']) . "&destination=" . urlencode($data['address_to']) . "&key=" . env('GOOGLE_MAPS_API_KEY');

        $response = file_get_contents($url);
        $result = json_decode($response, true);

        if (!empty($result['routes'])) {
            $route = $result['routes'][0];
            $leg = $route['legs'][0];

            // Extract duration and distance
            $distance = $leg['duration']['text'];  // e.g., "1 hour 15 mins"
            //$durationValue = $leg['duration']['value']; // in seconds
            $duration = $leg['distance']['text'];    // e.g., "80 km"
            //$distanceValue = $leg['distance']['value'];  // in meters

            // Also get the overview_polyline if needed:
            $polyline = $route['overview_polyline']['points'];

            $url2 = 'https://maps.googleapis.com/maps/api/staticmap?size=640x300&markers=place:Valencia, Valencian Community, Spain&markers=place:Munich, Bavaria, Germany&path=enc:qv|oFphhApC}qBkyFayEkaT{gDieIpd@obEkdImlIw_GwhUuvOg|JjlA{dHabEo`LsqY{vBerI_bDkaFyuLqpEc~K{rHeaFi}DmiFeC{aFaiE_wGwmM_wIuaHurDe{CqfLkVo{Ts~OqhPikO{jOkkXwdT_oV{mJefJ{sHqhDutKsfc@aqFkyMcd@amR{ImwLkyD{cM_yAe}JocGwlF_mH{vGksEqnKuaCwoN}rGmiCc`KouTkoCatKrMg|KhbBwpBkyA_gCulDapG{kB}uKgdFk`KqkG}yTslZydz@u{BmrPsjGsyH{b[_`GenHda@ogEedEstDyrEkxD}|FkxDwpB}rJcsAq}HgcCa}LmGomJvnCc}HvuF{wNh`Ce|BbrDgqEfm@onD_~C_nIc^ejVwhDoeUayEg}CaoLa_HqPogRdvEcbIj_BquG_uAe`GimE_lF_wNmzK}{Qs}IcrPu`Ik{TiiRckq@otTmup@i~KyxQ}vJiyY{}HqwVk`Iw_OmcSqqm@mrQox[osGa}KuoOahD{tOboL}_IpGkpIewBq~Jxw@shIesAsfQ_dImlI}p@{bHvmAapSzUkzGw|BqtFkkH_`Jan@wzDu|CqdAotHqrGfNq}FsiKkbEceUcvFgnQ{pIwoMcrHadSoqFqgOkfKqeIcwCazHhU}jHw`ExfCqrFplPgmJppKixBdwFa}Djb@}jI{bAsuCdwGsrApYc@k~]ek@w`[lhAyxQcsBk_Fc`BoyJupFmdJglK_gBsmFxg@}cDaxDgoFucCeeDiaJs_KmbIchKa`EkvDciBegEji@a_G`oGkvKyi@enEex@wvC~q@ukFvEehHa|G}fIcfAewJovI{lH}cIwgGmjNylGws]a`Fm{Ny{IzxAuuIklBwwMl@wjDswSspMkva@nPguIuhHgjOwdGsaYkqDqsE{`B_iJtiA{zTsHsrNcyCejJcxHqdIixI{dIgsHscAiuJg{AqlFevCclJ}`Tc~Ckl^gaAkfXoeLcrSivDqmRm}D}rEsReuHzcEg_OsWqr_@|_B_rB{j@ejI{tBgdIq~Dq}CmfElyA_rCoj@yk@q`Mz{Bid]||Im|UiQwoNhnCwpLt}CetTgzC{yOiiEutMk}@otVpoCmzJpg@yqCkfBakJe`Le_GmkEnfEqsKqO_mLekI{`Ugie@_dGyWo`DszFwjJshK}lFmhC{dDagJuzCiaUyFenc@qpAa`N`kAibYaaBwkSc_CofPidBwfo@ysAsyX{`DcwXia@_aXl`Am{E}iCymD&key=AIzaSyCN3ZNzt5TGTcaXTHM81y8VCH3KaZZ4JkY';

            $response2 = Http::get($url);

            //dd($response2);

            return response()->json([
                'distance' => $distance,
                'duration' => $duration,
                'polyline' => $polyline,
                'response_url' => $response2
            ]);
        }

        /*$response = Http::get($url);
        $data = $response->json();
        if ($response->successful()) {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            $duration = $data['rows'][0]['elements'][0]['duration']['text'];
            $polyline = $data['rows'][0]['elements'][0]['polyline']['text'];
            return response()->json([
                'distance' => $distance,
                'duration' => $duration,
                'polyline' => $polyline
            ]);
        }*/ else {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }

}
