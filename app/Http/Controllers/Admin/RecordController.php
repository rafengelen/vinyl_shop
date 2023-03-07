<?php

namespace App\Http\Controllers\Admin;

use App\Models\Genre;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{

    public function index()
    {

        $maxPrice = 20;
        $perPage = 6;
        $records = Record::where('price', '<=', $maxPrice)
            ->orderBy('artist')
            ->orderBy('title')
            ->paginate($perPage);
        $genres = Genre::orderBy('name')->with('records')->has('records')->get();
        return view('admin.records.index', compact('records','genres'));
    }




    //eigen creatie: mag weg na test
    public function  playground()
    {
        $records = [
            'Queen - Greatest Hits',
            'The Rolling Stones - Sticky Fingers',
            'The Beatles - Abbey Road'
        ];
        return view('playground', ['records'=>$records]);
    }






}
