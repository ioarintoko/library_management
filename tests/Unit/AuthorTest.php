<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created_with_valid_attributes()
    {
        // Arrange
        $attributes = [
            'name' => 'John Doe',
            'bio' => 'Famous author of thrillers.',
            'birthdate' => '1970-01-01',
        ];

        // Act
        $author = Author::create($attributes);

        // Assert
        $this->assertDatabaseHas('authors', $attributes);
        $this->assertEquals($attributes['name'], $author->name);
        $this->assertEquals($attributes['bio'], $author->bio);
        $this->assertEquals($attributes['birthdate'], $author->birthdate);
    }

    /** @test */
    public function an_author_can_have_many_books()
    {
        // Arrange
        $author = Author::factory()->create();
        $books = \App\Models\Book::factory()->count(3)->create(['authorid' => $author->id]);

        // Act
        $authorBooks = $author->books;

        // Assert
        $this->assertCount(3, $authorBooks);
        $this->assertEquals($books->pluck('id')->toArray(), $authorBooks->pluck('id')->toArray());
    }
}
