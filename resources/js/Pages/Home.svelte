<script context="module">
  import {layout, title} from '../Layouts/Layout.svelte'
</script>
<script>
  $layout = null
  $title = 'Home'

  let user = "User";
</script>

<div>
  <h1>Hello {user}!</h1>
</div>
