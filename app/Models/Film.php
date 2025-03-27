<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Film",
 *     type="object",
 *     required={"id", "title", "description", "age_rating", "language", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="The Matrix"),
 *     @OA\Property(property="description", type="string", example="A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers."),
 *     @OA\Property(property="age_rating", type="integer", example=18),
 *     @OA\Property(property="language", type="string", example="English"),
 *     @OA\Property(property="cover_image", type="string", example="matrix_cover.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-26T18:56:49"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-26T18:56:49")
 * )
 */
class Film extends Model
{
    /** @use HasFactory<\Database\Factories\FilmFactory> */
    use HasFactory;

    protected $table = 'films';
    protected $fillable = [
        'title',
        'description',
        'age_rating',
        'language',
        'cover_image',
    ];

    public function vetitesek()
    {
        return $this->hasMany(Vetites::class);
    }
}
