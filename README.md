# Sistema de Cadastro de Livros 📚

Este projeto é um sistema completo para gerenciamento de livros, autores e assuntos com funcionalidades de CRUD, listagem com relacionamentos e geração de relatórios em PDF. A interface é desenvolvida em HTML + Bootstrap + Axios, e o backend com Lumen (Laravel).

---

## 🚀 Tecnologias Utilizadas

* PHP 7.3+
* [Lumen 5.6](https://lumen.laravel.com/)
* Axios
* Bootstrap 5 / Bootstrap Icons
* DomPDF (para geração de PDFs)
* MariaDB ou MySQL
* Docker (para facilitar o setup)

---

## ⚙️ Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

* Git
* Docker e Docker Compose

---

## 🐳 Rodando com Docker (Recomendado)

O projeto possui um `Dockerfile` que instala dependências, roda as migrations e os seeders automaticamente ao subir o container. Isso permite iniciar a aplicação com um ambiente completo e funcional.

> ⬆️ Após clonar o repositório `https://github.com/rborges/tjjud`:

```bash
cd tjjud

# Constrói e sobe o container
docker-compose up --build
```

O projeto estará disponível em:

* Backend: [http://localhost:8000](http://localhost:8000)
* Frontend: abrir arquivos HTML diretamente no navegador ou via Live Server

---

## 💻 Rodando Manualmente (sem Docker)

```bash
# Entre na pasta do backend
cd backend

# Instale as dependências
composer install

# Copie o .env
cp .env.example .env

# Ajuste as variáveis de ambiente (DB etc.)

# Rode as migrations e seeders
php artisan migrate --seed

# Suba o servidor
php -S localhost:8000 -t public
```

Em seguida, abra os arquivos da pasta `frontend/` em um navegador moderno.

---

## 🔌 API - Principais Rotas

| Recurso   | Método | Rota             | Descrição               |
| --------- | ------ | ---------------- | ----------------------- |
| Livros    | GET    | `/books`         | Listar todos os livros  |
|           | POST   | `/books`         | Criar novo livro        |
|           | GET    | `/books/{id}`    | Detalhar livro          |
|           | PUT    | `/books/{id}`    | Atualizar livro         |
|           | DELETE | `/books/{id}`    | Remover livro           |
| Autores   | GET    | `/authors`       | Listar autores          |
| Assuntos  | GET    | `/subjects`      | Listar assuntos         |
| Relatório | GET    | `/report`        | JSON agrupado por autor |
|           | GET    | `/relatorio/pdf` | Download do PDF         |

---

## 📄 Relatório de Livros

A página `report.html` exibe um relatório geral com todos os livros agrupados por autor. Também há um botão que gera o PDF desse relatório (`relatorio-livros.pdf`) usando DomPDF.

---

## 📦 Estrutura de Pastas

```
.
├── backend/                # Backend Lumen
│   ├── app/
│   ├── public/
│   ├── routes/
│   └── ...
├── frontend/              # Páginas HTML + JS
│   ├── books.html
│   ├── authors.html
│   ├── subjects.html
│   └── report.html
├── docker-compose.yml     # Docker setup
└── Dockerfile             # Backend container
```

---

## 🔗 Links Rápidos

* Backend (API): [http://localhost:8000](http://localhost:8000)
* Livros: `frontend/books.html`
* Autores: `frontend/authors.html`
* Assuntos: `frontend/subjects.html`
* Relatório: `frontend/report.html`

---

Para dúvidas ou melhorias, sinta-se à vontade para abrir issues ou PRs no repositório.
