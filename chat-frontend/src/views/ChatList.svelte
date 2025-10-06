<script>
  import { onMount } from "svelte";
  import { ChatController } from "../controllers/chatController";
  import ChatForm from "./ChatForm.svelte";

  let mostrarForm = false;
  let chatSeleccionado = null;
  let chats = [];

  function nuevoChat() {
    chatSeleccionado = null;
    mostrarForm = true;
  }

  function editarChat(chat) {
    chatSeleccionado = chat;
    mostrarForm = true;
  }

  function cerrarForm() {
    mostrarForm = false;
    load(); // recarga la lista
  }

  async function load() {
    await ChatController.listar((data) => (chats = data));
  }

  async function eliminar(id) {
    await ChatController.eliminar(id, load);
  }

  onMount(load);
</script>

<main>
  <div class="header">
    <h2>💬 Lista de Chats</h2>
    <button class="new-chat" on:click={nuevoChat}>+ Nuevo Chat</button>
  </div>

  {#if chats.length === 0}
    <div class="empty">
      <p>No hay chats registrados aún.</p>
      <small>Empieza creando o sincronizando uno nuevo 🚀</small>
    </div>
  {:else}
    <div class="table">
      <div class="table-header">
        <span>ID</span>
        <span>Título</span>
        <span>Acciones</span>
      </div>

      {#each chats as c}
        <div class="table-row">
          <span>{c.id}</span>
          <span class="title">{c.titulo}</span>
          <div class="actions">
            <button class="edit" on:click={() => editarChat(c)}>✏️</button>
            <button class="delete" on:click={() => eliminar(c.id)}>🗑️</button>
          </div>
        </div>
      {/each}
    </div>
  {/if}

  {#if mostrarForm}
    <ChatForm {chatSeleccionado} on:saved={cerrarForm} on:cancel={cerrarForm} />
  {/if}
</main>

<style>
  main {
    max-width: 800px;
    margin: 60px auto;
    padding: 20px;
    font-family: 'Inter', system-ui, sans-serif;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  h2 {
    margin: 0;
    color: #171a52;
  }

  .new-chat {
    background: #171a52;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .new-chat:hover {
    background: #0f1140;
    transform: scale(1.05);
  }

  .empty {
    text-align: center;
    color: #777;
    padding: 40px 0;
  }

  .empty small {
    display: block;
    margin-top: 8px;
    color: #aaa;
  }

  .table {
    display: flex;
    flex-direction: column;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
  }

  .table-header,
  .table-row {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    align-items: center;
    padding: 12px 16px;
  }

  .table-header {
    background: #f3f4f6;
    font-weight: 600;
    color: #333;
  }

  .table-row {
    border-top: 1px solid #e5e7eb;
    transition: background 0.2s;
  }

  .table-row:hover {
    background: #f9fafb;
  }

  .title {
    font-weight: 500;
    color: #171a52;
  }

  .actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
  }

  .edit,
  .delete {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1rem;
    padding: 4px 6px;
    border-radius: 6px;
    transition: all 0.2s;
  }

  .edit {
    color: #2563eb;
  }

  .edit:hover {
    background: rgba(37, 99, 235, 0.1);
  }

  .delete {
    color: #d93025;
  }

  .delete:hover {
    background: rgba(217, 48, 37, 0.1);
  }
</style>
