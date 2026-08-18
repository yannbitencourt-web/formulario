const cadastroForm = document.querySelector('#cadastroForm');
const mensagem = document.querySelector('#mensagem');
const telefone = document.querySelector('#telefone');

telefone.addEventListener('input', () => {
  telefone.value = telefone.value.replace(/\D/g, '').slice(0, 11);
});

function mostrarMensagem(texto, tipo) {
  mensagem.textContent = texto;
  mensagem.className = `mensagem ${tipo}`;
}

cadastroForm.addEventListener('submit', async (evento) => {
  evento.preventDefault();
  mensagem.textContent = '';
  mensagem.className = 'mensagem';

  const nome = cadastroForm.nome.value.trim();
  const telefoneValor = cadastroForm.telefone.value.trim();
  const senha = cadastroForm.senha.value;

  if (!cadastroForm.checkValidity() || nome.length < 3 || !/^\d{10,11}$/.test(telefoneValor) || senha.length < 6) {
    cadastroForm.reportValidity();
    if (!/^\d{10,11}$/.test(telefoneValor)) {
      mostrarMensagem('O telefone deve conter 10 ou 11 números.', 'erro');
    }
    return;
  }

  const botao = cadastroForm.querySelector('button');
  botao.disabled = true;

  try {
    const resposta = await fetch('php/salvar_usuario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nome,
        nascimento: cadastroForm.nascimento.value,
        sexo: cadastroForm.sexo.value,
        telefone: telefoneValor,
        email: cadastroForm.email.value.trim(),
        senha
      })
    });

    const dados = await resposta.json();
    mostrarMensagem(dados.mensagem, dados.sucesso ? 'sucesso' : 'erro');

    if (dados.sucesso) {
      cadastroForm.reset();
      setTimeout(() => { window.location.href = 'index.html'; }, 1200);
    }
  } catch (erro) {
    mostrarMensagem('Não foi possível conectar ao servidor.', 'erro');
  } finally {
    botao.disabled = false;
  }
});
