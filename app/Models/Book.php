<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'publishdate', 'authorid'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'authorid');
    }
}
