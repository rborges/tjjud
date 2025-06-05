<?php

namespace Tests\Unit\Services;

use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Services\SubjectService;
use PHPUnit\Framework\TestCase;

class SubjectServiceTest extends TestCase
{
    protected $repoMock;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var SubjectRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject */
        $this->repoMock = $this->createMock(SubjectRepositoryInterface::class);
        $this->service = new SubjectService($this->repoMock);
    }

    public function testListSubjects()
    {
        $this->repoMock
            ->expects($this->once())
            ->method('all')
            ->willReturn(collect([
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

        $subject = new Subject($data);

        $this->repoMock
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($subject);

        $result = $this->service->create($data);

        $this->assertEquals('Física', $result->description);
    }

    public function testUpdateSubject()
    {
        $data = ['description' => 'Química'];

        $subject = new Subject($data);

        $this->repoMock
            ->expects($this->once())
            ->method('update')
            ->with(1, $data)
            ->willReturn($subject);

        $result = $this->service->update(1, $data);

        $this->assertEquals('Química', $result->description);
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
