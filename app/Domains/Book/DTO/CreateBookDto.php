<?php

namespace App\Domains\Book\DTO;

class CreateBookDTO
{
    public string $title;
    public string $publisher;
    public int $edition;
    public string $published_year;
    public float $price;
    public array $author_ids;
    public array $subject_ids;

    /**
     * Construtor privado para forçar o uso de fromArray
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
        $dto->title = $data['title'];
        $dto->publisher = $data['publisher'];
        $dto->edition = (int) $data['edition'];
        $dto->published_year = $data['published_year'];
        $dto->price = (float) $data['price'];
        $dto->author_ids = $data['author_ids'] ?? [];
        $dto->subject_ids = $data['subject_ids'] ?? [];

        return $dto;
    }
}
