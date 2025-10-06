<script>
  import { push } from 'svelte-spa-router';
  let telefono = "";
  let nombre = "Usuario ";

  async function handleLogin() {
    if (!telefono.trim()) {
      alert("Por favor, ingresa tu número de teléfono 📱");
      return;
    }

    nombre = nombre + telefono;

    const res = await fetch("http://localhost:8080/api/persona", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nombre, telefono }),
    });

    const data = await res.json();
    localStorage.setItem("personaId", data.id);
    localStorage.setItem("telefono", data.telefono);

    push("/chat");
  }
</script>

<main>
  <div class="login-container">
    <h1>💬 Bienvenido al Chat</h1>
    <p class="subtitle">Ingresa tu número de teléfono para continuar</p>

    <div class="form">
      <input 
        bind:value={telefono}
        placeholder="Ej: 3001234567"
        maxlength="10"
        on:keypress={(e) => e.key === 'Enter' && handleLogin()}
      />
      <button on:click={handleLogin}>Entrar 🚀</button>
    </div>
  </div>
</main>

<style>
  main {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
    background: linear-gradient(135deg, #171a52, #2a2a72);
    color: white;
  }

  .login-container {
    background: white;
    color: #171a52;
    border-radius: 16px;
    padding: 40px 50px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    text-align: center;
    width: 320px;
    transition: transform 0.3s ease;
  }

  .login-container:hover {
    transform: translateY(-4px);
  }

  h1 {
    margin-bottom: 10px;
    font-size: 1.8rem;
  }

  .subtitle {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 25px;
  }

  .form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    text-align: center;
    transition: 0.2s;
  }

  input:focus {
    border-color: #171a52;
    box-shadow: 0 0 4px rgba(23, 26, 82, 0.5);
  }

  button {
    background: #171a52;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
  }

  button:hover {
    background: #0f1140;
    transform: scale(1.03);
  }

  button:active {
    transform: scale(0.98);
  }
</style>
