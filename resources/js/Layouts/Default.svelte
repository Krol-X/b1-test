<script>
  import Menu from './Components/Menu.svelte'
</script>

<Menu />
<div class="layout">
  <slot />
</div>

<style>
  .layout {
    @apply w-full overflow-auto p-4;
    max-width: 100vw;
    max-height: 100vh;
  }
</style>
