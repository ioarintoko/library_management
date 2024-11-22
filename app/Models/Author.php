<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $name = 'string';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $bio = 'string';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $birthdate = 'date';

    public $timestamps = false;

    protected $fillable = ['name', 'bio', 'birthdate'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'authorid');
    }
}
