<?php

namespace Tests\Unit\Services;

use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\BookService;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
{
    protected $bookRepository;
    protected $bookService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do repository
        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);

        /** @var BookRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject */
        $this->bookService = new BookService($this->bookRepository);
    }

    public function testListBooks()
    {
        $expected = [
            ['id' => 1, 'title' => 'Livro A'],
            ['id' => 2, 'title' => 'Livro B'],
        ];

        $this->bookRepository->method('all')->willReturn($expected);

        $result = $this->bookService->list();

        $this->assertEquals($expected, $result);
    }

    public function testGetBook()
    {
        $expected = ['id' => 1, 'title' => 'Livro A'];

        $this->bookRepository->method('find')->with(1)->willReturn($expected);

        $result = $this->bookService->get(1);

        $this->assertEquals($expected, $result);
    }

    public function testCreateBook()
    {
        $data = ['title' => 'Novo Livro'];
        $expected = ['id' => 1, 'title' => 'Novo Livro'];

        $this->bookRepository->method('create')->with($data)->willReturn($expected);

        $result = $this->bookService->create($data);

        $this->assertEquals($expected, $result);
    }

    public function testUpdateBook()
    {
        $data = ['title' => 'Atualizado'];
        $expected = ['id' => 1, 'title' => 'Atualizado'];

        $this->bookRepository->method('update')->with(1, $data)->willReturn($expected);

        $result = $this->bookService->update(1, $data);

        $this->assertEquals($expected, $result);
    }

    public function testDeleteBook()
    {
        $this->bookRepository->expects($this->once())->method('delete')->with(1);

        $this->bookService->delete(1);

        $this->assertTrue(true); // Apenas confirma que nenhum erro foi lançado
    }
}
