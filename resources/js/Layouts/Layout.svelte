<script context="module">
  import {writable} from 'svelte/store'

  export const layout = writable('');
  export const title = writable('');
</script>

<script>
  import DefaultLayout from './Default.svelte'
  import AnotherLayout from './Another.svelte'

  $: layout_component = (() => {
    switch ($layout) {
      case 'another':
        console.log('AnotherLayout')
        return AnotherLayout
      default:
        console.log('DefaultLayout')
        return DefaultLayout
    }
  })();
</script>

<svelte:head>
  <title>{$title}</title>
</svelte:head>

<svelte:component this={layout_component} title={$title}>
  <slot/>
</svelte:component>
