<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'another'
  $title = 'test'

  export let user = ''
</script>

<div>
  <h1>Hello#2 {user}!</h1>
</div>
