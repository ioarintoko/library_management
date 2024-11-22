<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

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
    protected $title = 'string';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $description = 'string';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $publishdate = 'date';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $authorid = 'string';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'publishdate', 'authorid'];
}
