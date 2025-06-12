<?php

namespace App\Domains\Subject\DTO;

/**
 * DTO para criação de um novo assunto (Subject).
 */
class CreateSubjectDTO
{
    public string $description;
    public array $book_ids;

    /**
     * Construtor privado para forçar o uso de fromArray.
     */
    private function __construct() {}

    /**
     * Cria um DTO a partir de um array validado.
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
     * Retorna os dados persistentes da entidade.
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
