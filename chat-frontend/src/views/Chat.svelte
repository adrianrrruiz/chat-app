<script>
  import { onMount } from "svelte";
  import { push } from "svelte-spa-router";

  let ws;
  let connected = false;
  let messages = [];
  let input = "";

  const personaId = localStorage.getItem("personaId");
  const telefono = localStorage.getItem("telefono");
  const chatId = 1;
  const WS_URL = "ws://localhost:8081";

  if (!personaId) {
    // Si no hay login previo, redirige
    push("/");
  }

  function connect() {
    ws = new WebSocket(WS_URL);

    ws.onopen = () => (connected = true);
    ws.onmessage = (e) => {
      try {
        const data = JSON.parse(e.data);
        messages = [...messages, data];
      } catch {
        console.warn("Mensaje no JSON recibido:", e.data);
      }
    };
    ws.onclose = () => (connected = false);
  }

  function send() {
    if (!input.trim() || !connected) return;
    const msg = {
      chatId,
      personaId: Number(personaId),
      contenido: input,
      fecha: new Date().toISOString(),
    };
    ws.send(JSON.stringify(msg));
    messages = [...messages, { ...msg, yo: true }];
    input = "";
  }

  onMount(connect);
</script>

<main>
  <h2>Chat de {telefono}</h2>

  <div class="chat">
    {#each messages as m}
      <p><b>{m.yo ? "Yo" : m.personaId}:</b> {m.contenido}</p>
    {/each}
  </div>

  <div class="input-area">
    <input
      bind:value={input}
      placeholder="Escribe un mensaje..."
      on:keyup={(e) => e.key === 'Enter' && send()}
    />
    <button on:click={send} disabled={!connected}>Enviar</button>
  </div>

  <small>Estado: {connected ? "🟢 Conectado" : "🔴 Desconectado"}</small>
</main>

<style>
  main {
    max-width: 600px;
    margin: 50px auto;
    font-family: system-ui, sans-serif;
  }
  .chat {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px;
    height: 300px;
    overflow: auto;
    margin-bottom: 10px;
  }
  .input-area {
    display: flex;
    gap: 8px;
  }
  input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  button {
    padding: 8px 12px;
    background: #171a52;
    color: white;
    border: none;
    border-radius: 4px;
  }
  small {
    display: block;
    margin-top: 8px;
    color: #666;
  }
</style>
