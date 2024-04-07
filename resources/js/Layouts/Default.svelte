<script>
  import Menu from './Components/Menu.svelte'
</script>

<div class="layout">
  <header>
    <Menu />
  </header>

  <main>
    <slot />
  </main>
</div>

<style>
  .layout {
    @apply flex flex-col w-screen h-screen;
  }
  main {
    @apply flex-1 overflow-auto p-4;
  }
</style>
