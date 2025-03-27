<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Vetitesek",
 *     type="object",
 *     required={"time", "available_seats", "film_id"},
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         format="date-time",
 *         description="The time when the film is scheduled to be shown"
 *     ),
 *     @OA\Property(
 *         property="available_seats",
 *         type="integer",
 *         description="The number of available seats for the screening"
 *     ),
 *     @OA\Property(
 *         property="film_id",
 *         type="integer",
 *         description="The ID of the film being screened"
 *     ),
 *     @OA\Property(
 *         property="film",
 *         type="object",
 *         ref="#/components/schemas/Film"
 *     )
 * )
 */
class Vetitesek extends Model
{
    use HasFactory;

    protected $table = 'vetitesek';
    protected $fillable = [
        'time',
        'available_seats',
        'film_id',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
