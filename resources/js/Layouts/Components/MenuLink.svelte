<script>
  import { inertia, page } from '@inertiajs/svelte'

  export let text
  export let href

  console.log($page.url)
  console.log(href)

  $: is_active = $page.url.endsWith(href)
</script>

<a use:inertia class:active={is_active} href={href}>{text}</a>

<style lang="scss">
  a {
    @apply px-4 py-2;
    @apply text-xs sm:text-base;

    &:hover {
      @apply bg-slate-200;
    }
  }

  a.active::after {
    @apply bg-red-600;
    transform: scaleX(1);
    transform-origin: bottom left;
  }
</style>
