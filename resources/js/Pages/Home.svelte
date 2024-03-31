<script context="module">
  import {layout, title} from '../Layouts/Layout.svelte'
</script>
<script>
  $layout = null
  $title = 'Home'

  let user = "User";
</script>

<div>
  <h1 class="some">Hello {user}!</h1>
</div>

<style lang="scss">
  .some {
    @apply font-bold;
  }
</style>
