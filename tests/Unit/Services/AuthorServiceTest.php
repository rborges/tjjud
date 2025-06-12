<?php

namespace Tests\Unit\Services;

use App\Domains\Author\DTO\CreateAuthorDTO;
use App\Domains\Author\DTO\UpdateAuthorDTO;
use App\Domains\Author\Repositories\Contracts\AuthorRepositoryInterface;
use App\Domains\Author\Services\AuthorService;
use App\Models\Author;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;

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
        $authors = new Collection([
            new Author(['id' => 1, 'name' => 'Autor A']),
            new Author(['id' => 2, 'name' => 'Autor B']),
        ]);

        $this->authorRepository->method('all')->willReturn($authors);

        $this->assertEquals($authors, $this->authorService->list());
    }

    public function testGetAuthor()
    {
        $author = new Author(['id' => 1, 'name' => 'Autor A']);

        $this->authorRepository->method('find')->with(1)->willReturn($author);

        $this->assertEquals($author, $this->authorService->get(1));
    }

    public function testCreateAuthor()
    {
        $dto = CreateAuthorDTO::fromArray(['name' => 'Novo Autor', 'book_ids' => []]);

        $author = $this->createPartialMock(Author::class, ['books', 'load']);
        $author->method('books')->willReturn(new class {
            public function sync() {}
        });
        $author->method('load')->willReturnSelf();

        $this->authorRepository->method('create')->with($dto->toArray())->willReturn($author);

        $this->assertEquals($author, $this->authorService->create($dto));
    }

    public function testUpdateAuthor()
    {
        $dto = UpdateAuthorDTO::fromArray(['name' => 'Nome Atualizado']);

        $author = new Author(['id' => 1, 'name' => 'Nome Atualizado']);

        $this->authorRepository->method('find')->with(1)->willReturn($author);

        $this->assertEquals($author, $this->authorService->update(1, $dto));
    }

    public function testDeleteAuthor()
    {
        $this->authorRepository
            ->expects($this->once())
            ->method('delete')
            ->with(1);

        $this->authorService->delete(1);

        $this->assertTrue(true); // Apenas para garantir que não houve exceção
    }
}
