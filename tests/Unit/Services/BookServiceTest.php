<?php

namespace Tests\Unit\Services;

use App\Domains\Book\DTO\CreateBookDTO;
use App\Domains\Book\DTO\UpdateBookDTO;
use App\Domains\Book\Services\BookService;
use App\Domains\Book\Repositories\Contracts\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
{
    /** @var BookRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject */
    protected $bookRepository;
    protected $bookService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
        $this->bookService = new BookService($this->bookRepository);
    }

    public function testListBooks()
    {
        $books = new Collection([
            new Book(['id' => 1, 'title' => 'Livro A']),
            new Book(['id' => 2, 'title' => 'Livro B']),
        ]);

        $this->bookRepository->method('all')->willReturn($books);

        $this->assertEquals($books, $this->bookService->list());
    }

    public function testGetBook()
    {
        $book = new Book(['id' => 1, 'title' => 'Livro A']);

        $this->bookRepository->method('find')->with(1)->willReturn($book);

        $this->assertEquals($book, $this->bookService->get(1));
    }

    public function testCreateBook()
    {
        $dto = CreateBookDTO::fromArray([
            'title' => 'Novo Livro',
            'publisher' => 'Editora X',
            'edition' => 1,
            'published_year' => '2023',
            'price' => 29.99,
            'author_ids' => [1],
            'subject_ids' => [2]
        ]);

        $book = $this->createPartialMock(Book::class, ['authors', 'subjects', 'load']);
        $book->method('authors')->willReturn(new class {
            public function sync() {}
        });
        $book->method('subjects')->willReturn(new class {
            public function sync() {}
        });
        $book->method('load')->willReturnSelf();

        $this->bookRepository->method('create')->willReturn($book);

        $this->assertEquals($book, $this->bookService->create($dto));
    }

    public function testUpdateBook()
    {
        $dto = UpdateBookDTO::fromArray([
            'title' => 'Atualizado',
            'publisher' => 'Editora X',
            'edition' => 1,
            'published_year' => '2023',
            'price' => 29.99,
            'author_ids' => [1],
            'subject_ids' => [2]
        ]);

        $book = $this->createPartialMock(Book::class, ['authors', 'subjects', 'load']);
        $book->method('authors')->willReturn(new class {
            public function sync() {}
        });
        $book->method('subjects')->willReturn(new class {
            public function sync() {}
        });
        $book->method('load')->willReturnSelf();

        $this->bookRepository->method('update')->with(1, $dto->toArray())->willReturn($book);

        $this->assertEquals($book, $this->bookService->update(1, $dto));
    }

    public function testDeleteBook()
    {
        $this->bookRepository->expects($this->once())->method('delete')->with(1)->willReturn(true);

        $result = $this->bookService->delete(1);

        $this->assertTrue($result);
    }
}
