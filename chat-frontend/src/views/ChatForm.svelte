<script>
  import { createEventDispatcher, onMount } from "svelte";
  import { ChatController } from "../controllers/chatController";

  export let chat = null; // Si viene un chat, se edita; si no, se crea uno nuevo
  const dispatch = createEventDispatcher();

  let titulo = "";

  onMount(() => {
    if (chat) {
      titulo = chat.titulo;
    }
  });

  async function handleSubmit(e) {
    e.preventDefault();
    if (!titulo.trim()) return alert("El título es obligatorio");

    try {
      if (chat) {
        await ChatController.actualizar(chat.id, { titulo });
        alert("Chat actualizado correctamente");
      } else {
        await ChatController.crear({ titulo });
        alert("Chat creado correctamente");
      }

      dispatch("saved"); // notifica al padre que se guardó el chat
    } catch (err) {
      console.error(err);
      alert("Error al guardar el chat");
    }
  }
</script>

<div class="overlay">
  <div class="form-container">
    <h2>{chat ? "✏️ Editar Chat" : "➕ Nuevo Chat"}</h2>

    <form on:submit={handleSubmit}>
      <label for="titulo">Título</label>
      <input
        id="titulo"
        bind:value={titulo}
        placeholder="Ej: Chat General o Soporte"
      />

      <div class="actions">
        <button type="submit" class="primary">
          {chat ? "Guardar cambios" : "Crear chat"}
        </button>
        <button type="button" class="cancel" on:click={() => dispatch("cancel")}>
          Cancelar
        </button>
      </div>
    </form>
  </div>
</div>

<style>
  .overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
  }

  .form-container {
    background: #fff;
    padding: 28px 32px;
    border-radius: 12px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.2s ease-out;
  }

  h2 {
    text-align: center;
    color: #171a52;
    margin-bottom: 20px;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  label {
    font-weight: 600;
    color: #333;
    font-size: 0.95rem;
  }

  input {
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

  .actions {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
  }

  button {
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
  }

  .primary {
    background: #171a52;
    color: #fff;
  }

  .primary:hover {
    background: #0f1140;
    transform: scale(1.03);
  }

  .cancel {
    background: #e5e7eb;
    color: #333;
  }

  .cancel:hover {
    background: #d1d5db;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
