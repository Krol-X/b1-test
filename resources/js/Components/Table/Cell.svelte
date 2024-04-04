<script>
  export let is_header = false
</script>

{#if is_header}
  <th><slot /></th>
{:else}
  <td><slot /></td>
{/if}
