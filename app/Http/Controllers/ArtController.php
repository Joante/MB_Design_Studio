<?php

namespace App\Http\Controllers;

use App\Models\ArtColection;
use App\Models\ArtExhibition;
use App\Models\ArtPainting;
use Illuminate\Support\Facades\DB;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colections = ArtColection::orderBy('id', 'asc')->limit(4)->get();
        foreach ($colections as $colection) {
            $colection['paintings'] = ArtPainting::where('art_colection_id', '=', $colection->id)->limit(4)->get(); 
        }
        $exhibitions = ArtExhibition::orderBy(DB::raw('ABS(DATEDIFF(exhibitions.date_start, NOW()))'))->limit(4)->get();

        return view('Web/Art/art_index', ['exhibitions' => $exhibitions, 'colections' => $colections]);
    }
}
