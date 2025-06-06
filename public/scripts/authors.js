let autorEditandoId = null;

function carregarAutores() {
    axios.get('http://localhost:8000/authors')
        .then(response => {
            const tabela = document.getElementById('tabela-autores');
            tabela.innerHTML = '';
            response.data.forEach(autor => {
                tabela.innerHTML += `
              <tr>
                <td>${autor.id}</td>
                <td>${autor.name}</td>
                <td>
                  <button class="btn btn-sm btn-primary btn-icon me-1" onclick="editarAutor(${autor.id}, '${autor.name.replace(/'/g, "\\'")}')">
                    <i class="bi bi-pencil"></i> Editar
                  </button>
                  <button class="btn btn-sm btn-danger btn-icon" onclick="excluirAutor(${autor.id})">
                    <i class="bi bi-trash"></i> Exluir
                  </button>
                </td>
              </tr>
            `;
            });
        })
        .catch(error => {
            console.error('Erro ao carregar autores:', error);
        });
}

function editarAutor(id, nome) {
    autorEditandoId = id;
    document.getElementById('nome').value = nome;
    document.querySelector('button[type="submit"]').innerText = 'Atualizar Autor';
}

function excluirAutor(id) {
    if (confirm('Deseja realmente excluir este autor?')) {
        axios.delete(`http://localhost:8000/authors/${id}`)
            .then(() => {
                alert('Autor excluído com sucesso!');
                carregarAutores();
            })
            .catch(error => {
                console.error('Erro ao excluir autor:', error);
                alert('Erro ao excluir o autor.');
            });
    }
}

document.getElementById('form-autor').addEventListener('submit', function (e) {
    e.preventDefault();

    const novoAutor = {
        name: document.getElementById('nome').value
    };

    const url = autorEditandoId
        ? `http://localhost:8000/authors/${autorEditandoId}`
        : 'http://localhost:8000/authors';

    const metodo = autorEditandoId ? 'put' : 'post';

    axios[metodo](url, novoAutor)
        .then(() => {
            alert(autorEditandoId ? 'Autor atualizado com sucesso!' : 'Autor cadastrado com sucesso!');
            carregarAutores();
            document.getElementById('form-autor').reset();
            autorEditandoId = null;
            document.querySelector('button[type="submit"]').innerText = 'Salvar Autor';
        })
        .catch(error => {
            console.error('Erro ao salvar autor:', error);
            alert('Erro ao salvar o autor.');
        });
});

document.addEventListener('DOMContentLoaded', carregarAutores);