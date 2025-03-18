<?php

namespace App\Http\Controllers\Swagger;

use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\PortfolioRequest;


/**
 * @OA\Tag(
 *     name="Portfolio",
 *     description="Operations related to user portfolios"
 * )
 */
class PortfolioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/portfolio/index",
     *     summary="Get user portfolio",
     *     description="Get the portfolio of the authenticated user",
     *     tags={"Portfolio"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of portfolio items",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PortfolioResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/portfolio/show/{id}",
     *     summary="Get portfolio by ID",
     *     description="Retrieve a specific portfolio by its ID",
     *     tags={"Portfolio"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the portfolio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The requested portfolio",
     *         @OA\JsonContent(ref="#/components/schemas/PortfolioResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Portfolio not found"
     *     )
     * )
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/portfolio/store",
     *     summary="Create a new portfolio",
     *     description="Create a new portfolio for the authenticated user",
     *     tags={"Portfolio"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Name of the portfolio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Portfolio created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PortfolioResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(PortfolioRequest $portfoloRequest)
    {
        //
    }

    /**
     * @OA\Patch(
     *     path="/api/portfolio/update/{id}",
     *     summary="Update an existing portfolio",
     *     description="Update the details of a portfolio",
     *     tags={"Portfolio"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the portfolio to be updated",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Updated name of the portfolio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Portfolio updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PortfolioResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Portfolio not found"
     *     )
     * )
     */
    public function update(Portfolio $portfolio, PortfolioRequest $portfoloRequest)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/portfolio/delete/{id}",
     *     summary="Delete a portfolio",
     *     description="Delete a specific portfolio by ID",
     *     tags={"Portfolio"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the portfolio to be deleted",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Portfolio deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Portfolio not found"
     *     )
     * )
     */
    public function delete(Portfolio $portfolio)
    {
        //
    }
}
