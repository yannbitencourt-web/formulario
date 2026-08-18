const loginForm = document.querySelector('#loginForm');
const mensagem = document.querySelector('#mensagem');

function mostrarMensagem(texto, tipo) {
  mensagem.textContent = texto;
  mensagem.className = `mensagem ${tipo}`;
}

loginForm.addEventListener('submit', async (evento) => {
  evento.preventDefault();
  mensagem.textContent = '';
  mensagem.className = 'mensagem';

  if (!loginForm.checkValidity()) {
    loginForm.reportValidity();
    return;
  }

  const botao = loginForm.querySelector('button');
  botao.disabled = true;

  try {
    const resposta = await fetch('php/verificar_login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: loginForm.email.value.trim(),
        senha: loginForm.senha.value
      })
    });

    const dados = await resposta.json();
    mostrarMensagem(dados.mensagem, dados.sucesso ? 'sucesso' : 'erro');
  } catch (erro) {
    mostrarMensagem('Não foi possível conectar ao servidor.', 'erro');
  } finally {
    botao.disabled = false;
  }
});
