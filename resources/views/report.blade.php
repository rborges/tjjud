<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Livros</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Relatório de Livros por Autor</h1>

    @foreach ($data as $autor)
    <h2>Autor: {{ $autor['autor'] }}</h2>

    @foreach ($autor['livros'] as $livro)
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Editora</th>
                <th>Edição</th>
                <th>Ano de Publicação</th>
                <th>Preço (R$)</th>
                <th>Assuntos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $livro['título'] }}</td>
                <td>{{ $livro['editora'] }}</td>
                <td>{{ $livro['edição'] }}</td>
                <td>{{ $livro['ano_publicação'] }}</td>
                <td>{{ number_format($livro['preço'], 2, ',', '.') }}</td>
                <td>{{ implode(', ', $livro['assuntos']->toArray()) }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
    @endforeach
</body>

</html>