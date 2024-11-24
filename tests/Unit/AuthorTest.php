<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created_with_valid_attributes()
    {
        $attributes = [
            'name' => 'John Doe',
            'bio' => 'Famous author of thrillers.',
            'birthdate' => '1970-01-01',
        ];

        $author = Author::create($attributes);

        $this->assertDatabaseHas('authors', $attributes);
        $this->assertEquals($attributes['name'], $author->name);
        $this->assertEquals($attributes['bio'], $author->bio);
        $this->assertEquals($attributes['birthdate'], $author->birthdate);
    }

    /** @test */
    public function an_author_can_have_many_books()
    {
        $author = Author::factory()->create();
        $books = Book::factory()->count(3)->create(['authorid' => $author->id]);

        $this->assertCount(3, $author->books);
        $this->assertEquals($books->pluck('id')->toArray(), $author->books->pluck('id')->toArray());
    }
}
