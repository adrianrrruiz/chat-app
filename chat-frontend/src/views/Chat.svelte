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

  if (!personaId) push("/");

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
  <div class="chat-container">
    <header>
      <div>
        <h2>💬 Chat de {telefono}</h2>
        <span class="status">{connected ? "🟢 Conectado" : "🔴 Desconectado"}</span>
      </div>
    </header>

    <div class="chat-window">
      {#if messages.length === 0}
        <p class="empty">Aún no hay mensajes. ¡Envía el primero! 🚀</p>
      {:else}
        {#each messages as m}
          <div class="msg {m.yo ? 'mine' : 'other'}">
            <div class="bubble">
              <p>{m.contenido}</p>
              <span class="time">{new Date(m.fecha).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</span>
            </div>
          </div>
        {/each}
      {/if}
    </div>

    <footer>
      <input
        bind:value={input}
        placeholder="Escribe un mensaje..."
        on:keyup={(e) => e.key === 'Enter' && send()}
      />
      <button on:click={send} disabled={!connected}>Enviar</button>
    </footer>
  </div>
</main>

<style>
  main {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f6f7fb;
    height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
  }

  .chat-container {
    width: 420px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  header {
    background: #171a52;
    color: white;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  header h2 {
    font-size: 1rem;
    margin: 0;
  }

  .status {
    font-size: 0.85rem;
    opacity: 0.9;
  }

  .chat-window {
    flex: 1;
    padding: 16px;
    overflow-y: auto;
    background: #eef1f7;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .empty {
    text-align: center;
    color: #888;
    margin-top: 40px;
  }

  .msg {
    display: flex;
  }

  .msg.mine {
    justify-content: flex-end;
  }

  .msg.other {
    justify-content: flex-start;
  }

  .bubble {
    max-width: 75%;
    padding: 10px 14px;
    border-radius: 14px;
    background: #e0e0e0;
    color: #333;
    font-size: 0.95rem;
    position: relative;
  }

  .mine .bubble {
    background: #171a52;
    color: #fff;
    border-bottom-right-radius: 4px;
  }

  .other .bubble {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 4px;
  }

  .bubble .time {
    display: block;
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.7);
    text-align: right;
    margin-top: 4px;
  }

  .other .bubble .time {
    color: #777;
  }

  footer {
    display: flex;
    border-top: 1px solid #ddd;
    padding: 10px;
    background: white;
  }

  input {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s;
  }

  input:focus {
    border-color: #171a52;
  }

  button {
    margin-left: 8px;
    background: #171a52;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  button:hover {
    background: #0f1140;
    transform: scale(1.03);
  }

  button:disabled {
    background: #999;
    cursor: not-allowed;
  }
</style>
