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
  <header>
    <div class="logo">💬 ChatApp</div>
    <nav>
      <a href="#/">Inicio</a>
      <a href="#/personas">Personas</a>
      <a href="#/chats">Chats</a>
      <a href="#/mensajes">Mensajes</a>
    </nav>
  </header>

  <section class="content">
    <Router {routes} />
  </section>
</main>

<style>

  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #171a52;
    color: white;
    padding: 15px 40px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  }

  .logo {
    font-weight: 700;
    font-size: 1.2rem;
    letter-spacing: 0.5px;
  }

  nav {
    display: flex;
    gap: 24px;
  }

  nav a {
    position: relative;
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: color 0.3s;
  }

  nav a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 0%;
    height: 2px;
    background: #fbcf32;
    transition: width 0.3s ease;
  }

  nav a:hover {
    color: #fbcf32;
  }

  nav a:hover::after {
    width: 100%;
  }
</style>

