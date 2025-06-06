
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

function carregarAssuntos() {
    axios.get('http://localhost:8000/subjects')
        .then(response => {
            const assuntos = response.data;
            const tabela = document.getElementById('tabela-assuntos');
            tabela.innerHTML = '';
            assuntos.forEach(assunto => {
                const safeDescription = escapeHtml(assunto.description);
                tabela.innerHTML += `
              <tr>
                <td>${assunto.id}</td>
                <td>${safeDescription}</td>
                <td>
                  <button class="btn btn-sm btn-primary btn-icon me-1" oonclick="editarAssunto(${assunto.id}, \`${safeDescription}\`)">
                    <i class="bi bi-pencil"></i> Editar
                  </button>
                  <button class="btn btn-sm btn-danger btn-icon"onclick="excluirAssunto(${assunto.id})">
                    <i class="bi bi-trash"></i> Exluir
                  </button>
                </td>
              </tr>
            `;
            });
        })
        .catch(error => {
            console.error('Erro ao carregar assuntos:', error);
        });
}

function editarAssunto(id, description) {
    document.getElementById('subject-id').value = id;
    document.getElementById('subject-name').value = description;
}

function excluirAssunto(id) {
    if (!confirm('Tem certeza que deseja excluir este assunto?')) return;
    axios.delete(`http://localhost:8000/subjects/${id}`)
        .then(() => {
            alert('Assunto excluído com sucesso!');
            carregarAssuntos();
        })
        .catch(error => {
            console.error('Erro ao excluir assunto:', error);
            alert('Erro ao excluir o assunto.');
        });
}

function cancelarEdicao() {
    document.getElementById('form-subject').reset();
    document.getElementById('subject-id').value = '';
}

document.getElementById('form-subject').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('subject-id').value;
    const data = { description: document.getElementById('subject-name').value };

    const requisicao = id
        ? axios.put(`http://localhost:8000/subjects/${id}`, data)
        : axios.post('http://localhost:8000/subjects', data);

    requisicao
        .then(() => {
            alert('Assunto salvo com sucesso!');
            carregarAssuntos();
            cancelarEdicao();
        })
        .catch(error => {
            console.error('Erro ao salvar assunto:', error);
            alert('Erro ao salvar o assunto.');
        });
});

document.addEventListener('DOMContentLoaded', carregarAssuntos);