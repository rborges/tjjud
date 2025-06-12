<?php

namespace App\Domains\Subject\DTO;

/**
 * DTO para atualização de um assunto (Subject).
 */
class UpdateSubjectDTO
{
    public string $description;
    public array $book_ids;

    /**
     * Construtor privado para forçar o uso de fromArray.
     */
    private function __construct() {}

    /**
     * Cria uma instância do DTO a partir de dados validados.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->description = $data['description'];
        $dto->book_ids = $data['book_ids'] ?? [];

        return $dto;
    }

    /**
     * Retorna os dados a serem persistidos no modelo.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
        ];
    }
}
