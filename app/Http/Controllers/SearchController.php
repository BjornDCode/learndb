<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    
    public function index(SearchRequest $request)
    {
        return (new Search())
            ->registerModel(Series::class, 'title')
            ->search($request->input('query'));
    }

}
