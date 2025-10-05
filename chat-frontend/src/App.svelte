<script>
  import { onMount } from "svelte";

  let ws;
  let connected = false;
  let messages = [];
  let input = "";
  let personaId = 1;
  let chatId = 1;

  const WS_URL = import.meta.env.VITE_WS_URL ?? "ws://localhost:8080";

  function connect() {
    ws = new WebSocket(WS_URL);

    ws.onopen = () => {
      connected = true;
    };

    ws.onmessage = (e) => {
      const data = safeParse(e.data);
      messages = [...messages, data];
    };

    ws.onclose = () => {
      connected = false;
      // reconexión simple
      setTimeout(connect, 1000);
    };

    ws.onerror = () => ws.close();
  }

  function safeParse(x) {
    try {
      return JSON.parse(x);
    } catch {
      return { system: true, contenido: String(x) };
    }
  }

  function send() {
    if (!input.trim() || !ws || ws.readyState !== 1) return;
    const msg = {
      chatId,
      personaId,
      contenido: input,
      fecha: new Date().toISOString(),
    };
    ws.send(JSON.stringify(msg));
    // añadir optimista
    messages = [...messages, { ...msg, yo: true }];
    input = "";
  }

  onMount(connect);
</script>

<main>
  <h1>Chat Svelte</h1>
  <div
    style="border:1px solid #ddd; padding:8px; height:300px; overflow:auto; border-radius:8px;"
  >
    {#each messages as m}
      <div style="margin-bottom:6px;">
        {#if m.system}
          <em>{m.contenido}</em>
        {:else}
          <strong>{m.yo ? "Yo" : (m.personaId ?? "Otro")}:</strong>
          <span> {m.contenido}</span>
        {/if}
      </div>
    {/each}
  </div>

  <div style="display:flex; gap:8px; margin-top:8px;">
    <input
      placeholder="Escribe un mensaje…"
      bind:value={input}
      on:keyup={(e) => e.key === "Enter" && send()}
      style="flex:1; padding:8px; border:1px solid #ccc; border-radius:6px;"
    />
    <button on:click={send} disabled={!connected} style="padding:8px 12px;">
      Enviar
    </button>
  </div>

  <small>Estado: {connected ? "Conectado" : "Desconectado"}</small>
</main>

<style>
  main {
    max-width: 640px;
    margin: 24px auto;
    font-family: system-ui, sans-serif;
  }
  h1 {
    margin-bottom: 12px;
  }
</style>
