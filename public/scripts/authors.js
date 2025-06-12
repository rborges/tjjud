let autorEditandoId = null;

function carregarAutores() {
    axios.get('http://localhost:8000/authors')
        .then(response => {
            const autores = response.data.data;
            const tabela = document.getElementById('tabela-autores');
            tabela.innerHTML = '';
            autores.forEach(autor => {
                tabela.innerHTML += `
              <tr>
                <td>${autor.id}</td>
                <td>${autor.name}</td>
                <td>
                  <button class="btn btn-sm btn-primary btn-icon me-1" onclick="editarAutor(${autor.id}, '${autor.name.replace(/'/g, "\\'")}')">
                    <i class="bi bi-pencil"></i> Editar
                  </button>
                  <button class="btn btn-sm btn-danger btn-icon" onclick="excluirAutor(${autor.id})">
                    <i class="bi bi-trash"></i> Excluir
                  </button>
                </td>
              </tr>
            `;
            });
        })
        .catch(error => {
            console.error('Erro ao carregar autores:', error);
            alert('Erro ao buscar autores.');
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
            .then(response => {
                alert(response.data.message || 'Autor excluído com sucesso!');
                carregarAutores();
            })
            .catch(error => {
                console.error('Erro ao excluir autor:', error);
                alert(error.response?.data?.message || 'Erro ao excluir o autor.');
            });
    }
}

document.getElementById('form-autor').addEventListener('submit', function (e) {
    e.preventDefault();

    const nome = document.getElementById('nome').value.trim();

    if (!nome) {
        alert('O nome do autor é obrigatório.');
        return;
    }

    const novoAutor = { name: nome };

    const url = autorEditandoId
        ? `http://localhost:8000/authors/${autorEditandoId}`
        : 'http://localhost:8000/authors';

    const metodo = autorEditandoId ? 'put' : 'post';

    axios[metodo](url, novoAutor)
        .then(response => {
            alert(response.data.message || 'Autor salvo com sucesso!');
            carregarAutores();
            document.getElementById('form-autor').reset();
            autorEditandoId = null;
            document.querySelector('button[type="submit"]').innerText = 'Salvar Autor';
        })
        .catch(error => {
            console.error('Erro ao salvar autor:', error);

            const response = error.response?.data;
            const msgBase = response?.message || 'Erro ao salvar o autor.';

            if (response?.errors) {
                const mensagens = Object.values(response.errors)
                    .flat()
                    .map(msg => `- ${msg}`)
                    .join('\n');

                alert(`${msgBase}\n${mensagens}`);
            } else {
                alert(msgBase);
            }
        });
});

document.addEventListener('DOMContentLoaded', carregarAutores);
