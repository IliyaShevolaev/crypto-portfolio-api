<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\PortfolioRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Portfolio\PortfolioReource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    use AuthorizesRequests;

    public function index() : AnonymousResourceCollection
    {
        $userPortfolio = Portfolio::where('user_id', Auth::id())->get();

        return PortfolioReource::collection($userPortfolio);
    }

    public function show(Portfolio $portfolio) : PortfolioReource
    {
        $this->authorize('isOwner', $portfolio);
        
        return new PortfolioReource($portfolio);
    }

    public function store(PortfolioRequest $portfolioRequest) : JsonResponse
    {
        $portfolioData = $portfolioRequest->validated();

        $portrolio = Portfolio::create([
            'name' => $portfolioData['name'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($portrolio, 200);
    }

    public function update(Portfolio $portfolio, PortfolioRequest $portfolioRequest) : JsonResponse
    {
        $this->authorize('isOwner', $portfolio);

        $newData = $portfolioRequest->validated();

        $portfolio->update($newData);

        return response()->json($portfolio, 200);
    }

    public function delete(Portfolio $portfolio) : JsonResponse
    {
        $this->authorize('isOwner', $portfolio);

        $portfolio->deleteOrFail();

        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
