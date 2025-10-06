<script>
  import { onMount } from "svelte";
  import { PersonaController } from "../controllers/personaController";


  let personas = [];

  async function load() {
    await PersonaController.listar((data) => (personas = data));
  }

  async function eliminar(id) {
    await PersonaController.eliminar(id, load);
  }

  onMount(load);
</script>

<main>
  <h2>Lista de Personas</h2>
  {#if personas.length === 0}
    <p>No hay personas registradas.</p>
  {:else}
    <ul>
      {#each personas as p}
        <li>
          {p.nombre} - {p.telefono}
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
