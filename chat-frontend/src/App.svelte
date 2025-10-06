<script>
  import { wrap } from 'svelte-spa-router/wrap';
  import Router from 'svelte-spa-router';
  import Login from './views/Login.svelte';
  import Chat from './views/Chat.svelte';
  import PersonaList from './views/PersonaList.svelte';
  import MensajeList from './views/MensajeList.svelte';
  import ChatList from './views/ChatList.svelte';

  const routes = {
    '/': wrap({ component: Login }),
    '/chat': wrap({ component: Chat }),
    '/personas': wrap({ component: PersonaList }),
    '/chats': wrap({ component: ChatList }),
    '/mensajes': wrap({ component: MensajeList }),
  };
</script>

<main>
  <nav>
    <a href="#/">Inicio</a>
    <a href="#/personas">Personas</a>
    <a href="#/chats">Chats</a>
    <a href="#/mensajes">Mensajes</a>
  </nav>

  <Router {routes} />
</main>

<style>
  main {
    font-family: system-ui, sans-serif;
    max-width: 700px;
    margin: 30px auto;
  }

  nav {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
  }

  a {
    text-decoration: none;
    color: #171a52;
    font-weight: 600;
  }

  a:hover {
    text-decoration: underline;
  }
</style>
