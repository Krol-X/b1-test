<script>
  import Menu from './Components/Menu.svelte'

  export let title
</script>

<h1>Another layout with title: <b>{title}</b></h1>
<Menu />
<div>
  <slot />
</div>
