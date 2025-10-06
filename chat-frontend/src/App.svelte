<script>
  import { wrap } from 'svelte-spa-router/wrap';
  import Router from 'svelte-spa-router';
  import Login from './views/Login.svelte';
  import Chat from './views/Chat.svelte';

  const routes = {
    '/': wrap({ component: Login }),
    '/chat': wrap({ component: Chat }),
  };
</script>

<Router {routes} />
