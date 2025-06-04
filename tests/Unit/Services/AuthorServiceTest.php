<?php

namespace Tests\Unit\Services;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\AuthorService;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{
    protected $authorRepository;
    protected $authorService;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AuthorRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject */
        $this->authorRepository = $this->createMock(AuthorRepositoryInterface::class);
        $this->authorService = new AuthorService($this->authorRepository);
    }

    public function testListAuthors()
    {
        $expected = [
            ['id' => 1, 'name' => 'Autor A'],
            ['id' => 2, 'name' => 'Autor B'],
        ];

        $this->authorRepository->method('all')->willReturn($expected);

        $this->assertEquals($expected, $this->authorService->list());
    }

    public function testGetAuthor()
    {
        $expected = ['id' => 1, 'name' => 'Autor A'];

        $this->authorRepository->method('find')->with(1)->willReturn($expected);

        $this->assertEquals($expected, $this->authorService->get(1));
    }

    public function testCreateAuthor()
    {
        $data = ['name' => 'Novo Autor'];
        $expected = ['id' => 1, 'name' => 'Novo Autor'];

        $this->authorRepository->method('create')->with($data)->willReturn($expected);

        $this->assertEquals($expected, $this->authorService->create($data));
    }

    public function testUpdateAuthor()
    {
        $data = ['name' => 'Nome Atualizado'];
        $expected = ['id' => 1, 'name' => 'Nome Atualizado'];

        $this->authorRepository->method('update')->with(1, $data)->willReturn($expected);

        $this->assertEquals($expected, $this->authorService->update(1, $data));
    }

    public function testDeleteAuthor()
    {
        $this->authorRepository
            ->expects($this->once())
            ->method('delete')
            ->with(1);

        $this->authorService->delete(1);

        $this->assertTrue(true); // apenas confirmação de execução sem exceção
    }
}
