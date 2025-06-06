function baixarRelatorio() {
    window.open('http://localhost:8000/relatorio/pdf', '_blank');
}

function carregarRelatorio() {
    axios.get('http://localhost:8000/report')
        .then(response => {
            const tabela = document.getElementById('tabela-relatorio');
            tabela.innerHTML = '';

            response.data.forEach(autor => {
                autor.livros.forEach(livro => {
                    const linha = `
                <tr>
                  <td>${autor.autor}</td>
                  <td>${livro.título}</td>
                  <td>${livro.editora}</td>
                  <td>${livro.edição}</td>
                  <td>${livro.ano_publicação}</td>
                  <td>R$ ${parseFloat(livro.preço).toFixed(2).replace('.', ',')}</td>
                  <td>${livro.assuntos.join(', ')}</td>
                </tr>
              `;
                    tabela.innerHTML += linha;
                });
            });
        })
        .catch(error => {
            console.error('Erro ao carregar relatório:', error);
        });
}

document.addEventListener('DOMContentLoaded', carregarRelatorio);