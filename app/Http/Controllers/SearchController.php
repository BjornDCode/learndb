<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    public $routeBuilders = [
        'series' => 'buildSeriesRoute',
        'lesson' => 'buildLessonRoute',
    ];
    
    public function index(SearchRequest $request)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM public.search_series_and_lessons(:input)"),
            [
                'input' => $request->input('query')
            ]
        );

        return collect($results)->map(function ($result) {
            $result->url = $this->buildRoute($result->type, $result);
            return $result;
        })->toArray();
    }

    private function buildRoute($type, $result)
    {
        return $this->{$this->routeBuilders[$type]}($result);
    }

    private function buildLessonRoute($result)
    {
        return route('lesson.show', [
            'series' => $result->parent_slug,
            'lesson' => $result->slug,
        ]);
    }

    private function buildSeriesRoute($result)
    {
        return route('series.show', [
            'series' => $result->slug,
        ]);;
    }

}
