<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Vetitesek;
use Illuminate\Http\Request;

class VetitesekController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vetitesek",
     *     summary="Get list of all screenings",
     *     tags={"Vetitesek"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all screenings",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Vetitesek")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index(){
        return response()->json(Vetitesek::all());

    }
    /**
     * @OA\Post(
     *     path="/api/vetitesek/create",
     *     summary="Create a new Vetitesek record",
     *     description="This endpoint allows you to create a new Vetitesek record with time, available seats, and film ID.",
     *     tags={"Vetitesek"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"time", "available_seats", "film_id"},
     *             @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *             @OA\Property(property="available_seats", type="integer", example=50),
     *             @OA\Property(property="film_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vetitesek successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *             @OA\Property(property="available_seats", type="integer", example=50),
     *             @OA\Property(property="film_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        // Validáció
        $validated = $request->validate([
            'time' => 'required|date',
            'available_seats' => 'required|integer|min:0',
            'film_id' => 'required|exists:films,id',  // Ellenőrzi, hogy a film_id létezik-e a films táblában
        ]);

        // Vetitesek rekord létrehozása
        $vetites = Vetitesek::create([
            'time' => $validated['time'],
            'available_seats' => $validated['available_seats'],
            'film_id' => $validated['film_id'],
        ]);

        // Válasz visszaküldése a létrehozott rekorddal
        return response()->json($vetites, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/vetitesek/show/{id}",
     *     summary="Get a single Vetitesek record by ID",
     *     description="This endpoint allows you to fetch a Vetitesek record based on the provided ID.",
     *     tags={"Vetitesek"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the Vetitesek record",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the Vetitesek record",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *             @OA\Property(property="available_seats", type="integer", example=50),
     *             @OA\Property(property="film_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vetitesek record not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Vetitesek not found")
     *         )
     *     )
     * )
     */

    public function show($id){
        $response = Vetitesek::where('id',$id)->first();

        return response()->json($response);
    }

    /**
     * @OA\Put(
     *     path="/api/vetitesek/update/{id}",
     *     summary="Update a Vetitesek (Screening) record",
     *     description="This endpoint allows you to update an existing Vetitesek (screening) record with new time, available seats, and film ID.",
     *     tags={"Vetitesek"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the Vetitesek (screening) to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"time", "available_seats", "film_id"},
     *             @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *             @OA\Property(property="available_seats", type="integer", example=50),
     *             @OA\Property(property="film_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vetitesek successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *             @OA\Property(property="available_seats", type="integer", example=50),
     *             @OA\Property(property="film_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Screening not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Screening not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $screening = Vetitesek::find($id);

        if (!$screening) {
            return response()->json(['error' => 'Screening not found'], 404);
        }

        $validated = $request->validate([
            'time' => 'required|date',
            'available_seats' => 'required|integer|min:0',
            'film_id' => 'required|exists:films,id',  // Ellenőrzi, hogy a film_id létezik-e a films táblában
        ]);

        $screening->update($validated);


        return response()->json($screening);
    }

    /**
     * @OA\Delete(
     *     path="/api/vetitesek/delete/{id}",
     *     summary="Delete a Vetitesek (Screening) record",
     *     description="This endpoint allows you to delete a Vetitesek (screening) record by its ID.",
     *     tags={"Vetitesek"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the Vetitesek (screening) to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Screening successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Screening deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Screening not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Screening not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid ID format")
     *         )
     *     )
     * )
     */

    public function destroy($id){
        $screening = Vetitesek::find($id);
        if (!$screening) {
            return response()->json(['error' => 'Screening not found'], 404);
        }

        Vetitesek::where('id', $id)->delete();

        return response()->json(['message' => 'Screening deleted successfully']);
    }


    /**
     * @OA\Get(
     *     path="/api/vetitesek/search",
     *     summary="Search for screenings (vetitesek) by multiple parameters",
     *     description="This endpoint allows you to search for screenings based on time, film ID, available seats, and film title.",
     *     tags={"Vetitesek"},
     *     @OA\Parameter(
     *         name="time",
     *         in="query",
     *         required=false,
     *         description="The time of the screening you want to search for. Use together with time_condition to filter.",
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Parameter(
     *         name="time_condition",
     *         in="query",
     *         required=false,
     *         description="Specify how to compare the time: 'before' to get screenings before the given time, 'after' to get screenings after the given time, or 'equal' to match exactly the given time. Default is 'equal'.",
     *         @OA\Schema(type="string", enum={"before", "after", "equal"}, default="equal")
     *     ),
     *     @OA\Parameter(
     *         name="film_id",
     *         in="query",
     *         required=false,
     *         description="Filter screenings by the film's ID.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="min_available_seats",
     *         in="query",
     *         required=false,
     *         description="Filter screenings by the minimum number of available seats. Only screenings with at least the specified number of available seats will be returned.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="film_title",
     *         in="query",
     *         required=false,
     *         description="Search screenings by the film's title. Use partial matching with LIKE.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved screenings matching the provided filters",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="time", type="string", format="date-time", example="2025-03-27 19:00:00"),
     *                 @OA\Property(property="available_seats", type="integer", example=50),
     *                 @OA\Property(property="film_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-27T10:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request. Invalid request parameters.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid request parameters")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No screenings found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No screenings found for given parameters")
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = Vetitesek::query();

        if ($request->has('time')) {
            $timeCondition = $request->get('time_condition', 'equal');
            switch ($timeCondition) {
                case 'before':
                    $query->where('time', '<', $request->time);
                    break;
                case 'after':
                    $query->where('time', '>', $request->time);
                    break;
                default:
                    $query->where('time', '=', $request->time);
            }
        }

        if ($request->has('film_id')) {
            $query->where('film_id', $request->film_id);
        }

        if ($request->has('min_available_seats')) {
            $query->where('available_seats', '>=', $request->min_available_seats);
        }

        if ($request->has('film_title')) {
            $query2 = Film::query();
            $query2->where('title', "LIKE", "%{$request->get('film_title')}%");
            foreach ($query2->get() as $film) {
                $query->where("film_id", "=", $film->id);
            }
        }

        $results = $query->get();

        if ($results->isEmpty()) {
            return response()->json(['error' => 'No screenings found for given parameters'], 404);
        }

        return response()->json($results);
    }



}
