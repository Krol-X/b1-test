<script>
  import {inertia} from '@inertiajs/svelte'
</script>

<div class="menu">
  <a use:inertia href="/">Home</a>
  <a use:inertia href="/test">Test</a>
</div>

<style>
  .menu {
    display: flex;
    gap: 20px;
  }
</style>
