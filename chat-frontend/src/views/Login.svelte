<script>
  import { push } from 'svelte-spa-router';
  let telefono = "";
  let nombre = "Usuario ";

  async function handleLogin() {
    if (!telefono.trim()) return alert("Ingresa tu número de teléfono");
    nombre = nombre + telefono;

    // Llamada al backend para registrar/buscar la persona
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
  <h2>Ingresa tu número de teléfono</h2>
  <input bind:value={telefono} placeholder="Ej: 3001234567" />
  <button on:click={handleLogin}>Entrar</button>
</main>

<style>
  main {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 300px;
    margin: 100px auto;
    font-family: system-ui, sans-serif;
  }
  input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  button {
    padding: 8px;
    background: #171a52;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
</style>
