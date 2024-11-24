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

    /** @test */
    public function an_author_can_be_updated()
    {
        $author = Author::factory()->create();

        $updatedAttributes = [
            'name' => 'Jane Doe',
            'bio' => 'Renowned author of detective stories.',
            'birthdate' => '1980-05-15',
        ];

        $author->update($updatedAttributes);

        $this->assertDatabaseHas('authors', $updatedAttributes);
        $this->assertEquals($updatedAttributes['name'], $author->name);
        $this->assertEquals($updatedAttributes['bio'], $author->bio);
        $this->assertEquals($updatedAttributes['birthdate'], $author->birthdate);
    }

    /** @test */
    public function an_author_can_be_deleted()
    {
        $author = Author::factory()->create();

        // Store the author's ID before deletion
        $authorId = $author->id;
    
        // Delete the author
        $author->delete();
    
        // Assert that the author no longer exists in the database
        $this->assertDatabaseMissing('authors', ['id' => $authorId]);
    }

    /** @test */
    public function an_author_can_create_a_book()
    {
        $author = Author::factory()->create();

        $bookAttributes = [
            'title' => 'The Great Adventure',
            'description' => 'A thrilling adventure story.',
            'publishdate' => '2024-06-10',
            'authorid' => $author->id,
        ];

        $book = Book::create($bookAttributes);

        $this->assertDatabaseHas('books', $bookAttributes);
        $this->assertEquals($bookAttributes['title'], $book->title);
        $this->assertEquals($bookAttributes['authorid'], $book->authorid);
    }

    /** @test */
    public function an_author_cannot_be_created_with_invalid_attributes()
    {
        // Missing required fields
        $attributes = [
            'name' => '', // Invalid name
            'bio' => 'Bio cannot be empty', 
            'birthdate' => 'not-a-valid-date', // Invalid date
        ];

        $response = $this->postJson('/api/authors', $attributes);

        // Assuming validation rules exist for required fields
        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['name', 'birthdate']);
    }
}
