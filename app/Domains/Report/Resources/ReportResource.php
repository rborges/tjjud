<?php

namespace App\Domains\Report\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ReportResource extends JsonResource
{
    /**
     * Transforma os dados do relatório para resposta JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'autor' => $this['autor'],
            'livros' => collect($this['livros'])->map(function ($livro) {
                return [
                    'título' => $livro['título'],
                    'editora' => $livro['editora'],
                    'edição' => $livro['edição'],
                    'ano_publicação' => $livro['ano_publicação'],
                    'preço' => $livro['preço'],
                    'assuntos' => $livro['assuntos'],
                ];
            })->values(),
        ];
    }
}
