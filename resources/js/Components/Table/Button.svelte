<script>
  export let text
  export let action = () => {}
  export let elem
</script>

<button bind:this={elem} on:click={() => action(elem)}>
  {text}
</button>

<style>
  button {
    @apply select-none;
    @apply px-3 py-1 border rounded border-gray-400;
    @apply hover:border-blue-600 hover:bg-slate-100;
  }
</style>
