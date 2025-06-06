let converterPreco;

function aplicarMascaraPreco(inputElemento) {
    inputElemento.addEventListener('input', () => {
        let valor = inputElemento.value.replace(/\D/g, '');
        if (!valor.length) {
            inputElemento.value = '';
            return;
        }

        valor = (parseInt(valor, 10) / 100).toFixed(2);
        inputElemento.value = 'R$ ' + valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    });

    return function () {
        return parseFloat(inputElemento.value.replace(/\s|[R$\.]/g, '').replace(',', '.')) || 0;
    };
}

function carregarLivros() {
    axios.get('http://localhost:8000/books')
        .then(response => {
            const tabela = document.getElementById('tabela-livros');
            tabela.innerHTML = '';
            response.data.forEach(livro => {
                tabela.innerHTML += `
              <tr>
                <td>${livro.id}</td>
                <td>${livro.title}</td>
                <td>${livro.publisher}</td>
                <td>${livro.edition}</td>
                <td>${livro.published_year}</td>
                <td>${parseFloat(livro.price).toFixed(2).replace('.', ',')}</td>
                <td>
                  <button class="btn btn-sm btn-primary" onclick="editarLivro(${livro.id})">Editar</button>
                  <button class="btn btn-sm btn-danger" onclick="excluirLivro(${livro.id})">Excluir</button>
                </td>
              </tr>
            `;
            });
        })
        .catch(error => console.error('Erro ao carregar livros:', error));
}

function carregarAutores() {
    return axios.get('http://localhost:8000/authors')
        .then(response => {
            const select = document.getElementById('autores');
            select.innerHTML = '';
            response.data.forEach(autor => {
                const option = document.createElement('option');
                option.value = autor.id;
                option.textContent = autor.name;
                select.appendChild(option);
            });
        });
}

function carregarAssuntos() {
    return axios.get('http://localhost:8000/subjects')
        .then(response => {
            const select = document.getElementById('assuntos');
            select.innerHTML = '';
            response.data.forEach(assunto => {
                const option = document.createElement('option');
                option.value = assunto.id;
                option.textContent = assunto.description;
                select.appendChild(option);
            });
        });
}

function editarLivro(id) {
    axios.get(`http://localhost:8000/books/${id}`)
        .then(response => {
            const livro = response.data;
            document.getElementById('livro-id').value = livro.id;
            document.getElementById('titulo').value = livro.title;
            document.getElementById('editora').value = livro.publisher;
            document.getElementById('edicao').value = livro.edition;
            document.getElementById('ano').value = livro.published_year;

            // Espera os selects serem carregados antes de marcar selecionados
            Promise.all([carregarAutores(), carregarAssuntos()]).then(() => {
                const autoresSelect = document.getElementById('autores');
                const assuntosSelect = document.getElementById('assuntos');

                Array.from(autoresSelect.options).forEach(opt => {
                    opt.selected = livro.authors.some(a => a.id == opt.value);
                });

                Array.from(assuntosSelect.options).forEach(opt => {
                    opt.selected = livro.subjects.some(s => s.id == opt.value);
                });
            });

            // Formata preço com máscara
            document.getElementById('preco').value = 'R$ ' +
                parseFloat(livro.price).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            document.getElementById('cancelar-edicao').classList.remove('d-none');
        })
        .catch(error => {
            console.error('Erro ao carregar livro para edição:', error);
            alert('Erro ao carregar dados do livro.');
        });
}

function excluirLivro(id) {
    if (confirm('Deseja realmente excluir este livro?')) {
        axios.delete(`http://localhost:8000/books/${id}`)
            .then(() => carregarLivros());
    }
}

document.getElementById('form-livro').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('livro-id').value;
    const selectedAuthors = Array.from(document.getElementById('autores').selectedOptions).map(opt => parseInt(opt.value));
    const selectedSubjects = Array.from(document.getElementById('assuntos').selectedOptions).map(opt => parseInt(opt.value));

    const livroPayload = {
        title: document.getElementById('titulo').value,
        publisher: document.getElementById('editora').value,
        edition: parseInt(document.getElementById('edicao').value),
        published_year: document.getElementById('ano').value,
        price: converterPreco(),
        author_ids: selectedAuthors,
        subject_ids: selectedSubjects
    };

    const axiosRequest = id
        ? axios.put(`http://localhost:8000/books/${id}`, livroPayload)
        : axios.post('http://localhost:8000/books', livroPayload);

    axiosRequest.then(() => {
        alert('Livro salvo com sucesso!');
        carregarLivros();
        document.getElementById('form-livro').reset();
        document.getElementById('livro-id').value = '';
        document.getElementById('cancelar-edicao').classList.add('d-none');
    }).catch(error => {
        console.error('Erro ao salvar livro:', error);
        alert('Erro ao salvar o livro.');
    });
});

document.getElementById('cancelar-edicao').addEventListener('click', () => {
    document.getElementById('form-livro').reset();
    document.getElementById('livro-id').value = '';
    document.getElementById('cancelar-edicao').classList.add('d-none');
});

document.addEventListener('DOMContentLoaded', () => {
    carregarLivros();
    carregarAutores();
    carregarAssuntos();
    converterPreco = aplicarMascaraPreco(document.getElementById('preco'));
});