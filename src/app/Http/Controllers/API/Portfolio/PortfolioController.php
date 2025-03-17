<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Portrolio\PortfoloRequest;
use App\Http\Resources\Portfolio\PortfolioReource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    public function index() : AnonymousResourceCollection
    {
        $userPortfolio = Portfolio::where('user_id', Auth::id())->get();

        return PortfolioReource::collection($userPortfolio);
    }

    public function show(Portfolio $portfolio) : PortfolioReource
    {
        return new PortfolioReource($portfolio);
    }

    public function store(PortfoloRequest $portfoloRequest) : JsonResponse
    {
        $portfolioData = $portfoloRequest->validated();

        $portrolio = Portfolio::create([
            'name' => $portfolioData['name'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($portrolio, 200);
    }

    public function update(Portfolio $portfolio, PortfoloRequest $portfoloRequest) : JsonResponse
    {
        $newData = $portfoloRequest->validated();

        $portfolio->update($newData);

        return response()->json($portfolio, 200);
    }

    public function delete(Portfolio $portfolio) : JsonResponse
    {
        $portfolio->deleteOrFail();

        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
