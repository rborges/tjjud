<?php

namespace Tests\Unit\Services;

use App\Domains\Subject\DTO\CreateSubjectDTO;
use App\Domains\Subject\DTO\UpdateSubjectDTO;
use App\Domains\Subject\Repositories\Contracts\SubjectRepositoryInterface;
use App\Domains\Subject\Services\SubjectService;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubjectServiceTest extends TestCase
{
    /** @var SubjectRepositoryInterface&MockObject */
    protected $repoMock;

    protected SubjectService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repoMock = $this->createMock(SubjectRepositoryInterface::class);
        $this->service = new SubjectService($this->repoMock);
    }

    public function testListSubjects()
    {
        $this->repoMock
            ->expects($this->once())
            ->method('all')
            ->willReturn(new EloquentCollection([
                new Subject(['id' => 1, 'description' => 'História']),
                new Subject(['id' => 2, 'description' => 'Tecnologia']),
            ]));

        $result = $this->service->list();

        $this->assertCount(2, $result);
        $this->assertEquals('História', $result[0]->description);
    }

    public function testGetSubject()
    {
        $subject = new Subject(['id' => 1, 'description' => 'Matemática']);

        $this->repoMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($subject);

        $result = $this->service->get(1);

        $this->assertEquals('Matemática', $result->description);
    }

    public function testCreateSubject()
    {
        $data = ['description' => 'Física'];

        $mockSubject = $this->createMock(Subject::class);
        $mockSubject->method('load')->with('books')->willReturnSelf();

        $this->repoMock
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($mockSubject);

        $result = $this->service->create(CreateSubjectDTO::fromArray($data));

        $this->assertInstanceOf(Subject::class, $result);
        $this->assertSame($mockSubject, $result);
    }

    public function testUpdateSubject()
    {
        $data = ['description' => 'Química'];

        $mockSubject = $this->createMock(Subject::class);
        $mockSubject->method('load')->with('books')->willReturnSelf();

        $this->repoMock
            ->expects($this->once())
            ->method('update')
            ->with(1, $data)
            ->willReturn($mockSubject);

        $result = $this->service->update(1, UpdateSubjectDTO::fromArray($data));

        $this->assertInstanceOf(Subject::class, $result);
        $this->assertSame($mockSubject, $result);
    }

    public function testDeleteSubject()
    {
        $this->repoMock
            ->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $result = $this->service->delete(1);

        $this->assertTrue($result);
    }
}
