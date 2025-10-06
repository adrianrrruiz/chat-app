<script>
  import { onMount } from "svelte";
  import { MensajeController } from "../controllers/mensajeController.js";

  let mensajes = [];

  async function load() {
    await MensajeController.listar((data) => (mensajes = data));
  }

  async function eliminar(id) {
    await MensajeController.eliminar(id, load);
  }

  onMount(load);
</script>

<main>
  <h2>Lista de mensajes</h2>
  {#if mensajes.length === 0}
    <p>No hay mensajes registradas.</p>
  {:else}
    <ul>
      {#each mensajes as p}
        <li>
          {p.contenido} - {p.fecha.date}
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
