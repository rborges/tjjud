<?php

namespace App\Domains\Author\DTO;

/**
 * DTO para atualização da entidade Author.
 */
class UpdateAuthorDTO
{
    /** @var string */
    public string $name;

    /** @var int[] */
    public array $book_ids;

    /**
     * Construtor privado para forçar o uso do método estático `fromArray`.
     */
    private function __construct() {}

    /**
     * Cria uma instância do DTO a partir de um array validado.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->name = $data['name'];
        $dto->book_ids = $data['book_ids'] ?? [];

        return $dto;
    }

    /**
     * Retorna apenas os dados persistentes no modelo Author.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
