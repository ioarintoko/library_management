<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_created_with_valid_attributes()
    {
        // Arrange
        $author = Author::factory()->create();

        $attributes = [
            'title' => 'Sample Book Title',
            'description' => 'This is a test book description.',
            'publishdate' => '2024-01-01',
            'authorid' => $author->id,
        ];

        // Act
        $book = Book::create($attributes);

        // Assert
        $this->assertDatabaseHas('books', $attributes);
        $this->assertEquals($attributes['title'], $book->title);
        $this->assertEquals($attributes['description'], $book->description);
        $this->assertEquals($attributes['publishdate'], $book->publishdate);
        $this->assertEquals($attributes['authorid'], $book->authorid);
    }

    /** @test */
    public function a_book_belongs_to_an_author()
    {
        // Arrange
        $author = Author::factory()->create();
        $book = Book::factory()->create(['authorid' => $author->id]);

        // Act
        $bookAuthor = $book->author;

        // Assert
        $this->assertNotNull($bookAuthor);
        $this->assertEquals($author->id, $bookAuthor->id);
        $this->assertEquals($author->name, $bookAuthor->name);
    }
}
