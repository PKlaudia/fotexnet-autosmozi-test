<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Vetitesek;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *     title="Movie API",
 *     version="1.0.0",
 *     description="API for managing films and screening"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local development server"
 * )
 */


class FilmController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/films",
     *     summary="Az összes filmet kilistázza",
     *     tags={"Films"},
     *     @OA\Response(response=200, description="Az összes filmet kilistázza"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(){
        return response()->json(Film::all());
    }

    /**
     * @OA\Get(
     *     path="/api/films/show/{id}",
     *     summary="Get a specific film by ID",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the film to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Film details"),
     *     @OA\Response(response=404, description="Film not found")
     * )
     */
    public function show($id){

        $response = Film::where('id',$id)->first();

        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/api/films/createNewFilm",
     *     summary="Create a new film",
     *     description="Creates a new film with the provided details.",
     *     operationId="createFilm",
     *     tags={"Films"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "age_rating", "language"},
     *             @OA\Property(property="title", type="string", example="Inception"),
     *             @OA\Property(property="description", type="string", example="A mind-bending thriller."),
     *             @OA\Property(property="age_rating", type="string", example="PG-13"),
     *             @OA\Property(property="language", type="string", example="English"),
     *             @OA\Property(property="cover_image", type="string", nullable=true, example="https://example.com/image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Film created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Inception"),
     *             @OA\Property(property="description", type="string", example="A mind-bending thriller."),
     *             @OA\Property(property="age_rating", type="string", example="PG-13"),
     *             @OA\Property(property="language", type="string", example="English"),
     *             @OA\Property(property="cover_image", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="created_at", type="string", example="2025-03-26T18:56:49.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2025-03-26T18:56:49.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'age_rating' => 'required|string|max:255',
            'language' => 'required|string',
            'cover_image' => 'nullable|string',
        ]);


        $film = Film::create($validated);

        return response()->json($film, 201);
    }
    /**
     * @OA\Put(
     *     path="/api/films/update/{id}",
     *     summary="Update a film by ID",
     *     description="Update the details of a specific film by its ID",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the film to be updated",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "age_rating", "language"},
     *             @OA\Property(property="title", type="string", example="The Matrix"),
     *             @OA\Property(property="description", type="string", example="A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers."),
     *             @OA\Property(property="age_rating", type="integer", example=18),
     *             @OA\Property(property="language", type="string", example="English"),
     *             @OA\Property(property="cover_image", type="string", example="matrix_cover.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Film successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Film")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json(['error' => 'Film not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'age_rating' => 'integer',
            'language' => 'string',
            'cover_image' => 'nullable|string',
        ]);

        $film->update($validated);
        Vetitesek::where('film_id', $id)->update(['id' => $id ]);


        return response()->json($film);
    }




    /**
     * @OA\Delete(
     *     path="/api/films/delete/{id}",
     *     summary="Delete a film by ID. Delete the Screen as well",
     *     description="This endpoint deletes a film from the database by its ID.",
     *     operationId="deleteFilm",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the film to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Film deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Film deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Film not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $film = Film::find($id);
        if (!$film) {
            return response()->json(['error' => 'Film not found'], 404);
        }

        Vetitesek::where('film_id', $id)->delete();
        $film->delete();

        return response()->json(['message' => 'Film deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/films/search",
     *     summary="Search films by title, language, and age rating",
     *     description="Returns a list of films that match the search criteria. Filters can be applied based on title, language, and age rating.",
     *     operationId="searchFilms",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Title of the film to search for",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="Matrix"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="Language of the film",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="English"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="age_rating",
     *         in="query",
     *         description="Age rating of the film",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="12"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of films that match the search criteria",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Film"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid search parameters",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No films found matching the criteria",
     *     )
     * )
     */

    public function search(Request $request)
    {
        $query = Film::query();
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('language')) {
            $query->where('language', $request->language);
        }

        if ($request->has('age_rating')) {
            $query->where('age_rating', $request->age_rating);
        }

        $films = $query->get();
        return response()->json($films);
    }
}
