<script>
  import { onMount } from "svelte";
  import { ChatController } from "../controllers/chatController";

  let chats = [];

  async function load() {
    await ChatController.listar((data) => (chats = data));
  }

  async function eliminar(id) {
    await ChatController.eliminar(id, load);
  }

  onMount(load);
</script>

<main>
  <h2>Lista de chats</h2>
  {#if chats.length === 0}
    <p>No hay chats registrados.</p>
  {:else}
    <ul>
      {#each chats as p}
        <li>
          {p.id} - {p.titulo}
          <button on:click={() => eliminar(p.id)}>🗑️</button>
        </li>
      {/each}
    </ul>
  {/if}
</main>

<style>
  main {
    max-width: 600px;
    margin: 50px auto;
    font-family: system-ui, sans-serif;
  }
  ul {
    list-style: none;
    padding: 0;
  }
  li {
    display: flex;
    justify-content: space-between;
    padding: 6px;
    border-bottom: 1px solid #ccc;
  }
</style>
