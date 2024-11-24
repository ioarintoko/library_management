<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use DatabaseMigrations;

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
    // Ensure that the author with ID 2 exists, or create it
    $author = Author::find(55);
    if (!$author) {
        $author = Author::create([
            'id' => 55,
            'name' => 'Sample Author',
            'bio' => 'Sample bio',
            'birthdate' => '1990-01-01',
        ]);
    }

    // Store the author's ID to delete later
    $authorId = $author->id;

    // Send the delete request to the controller's destroy method
    $response = $this->deleteJson("/api/authors/{$authorId}");

    // Assert the response indicates successful deletion
    $response->assertStatus(200);
    $response->assertJson(['message' => 'Author deleted successfully']);

    // // Assert that the author with ID 2 no longer exists in the database
    // $this->assertDatabaseMissing('authors', ['id' => $authorId]);

    // // Optionally, check that other authors are not deleted, like ID 1
    // $this->assertDatabaseHas('authors', ['id' => 34]); // Assuming author with ID 1 exists
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
