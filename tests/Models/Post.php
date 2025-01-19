<?php

namespace Kimani\LaravelAiFaker\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * Define an inverse relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
