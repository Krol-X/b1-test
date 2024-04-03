<script>
  import { get_columns } from '@/Utils'
  import Button from '@/Components/Table/Button.svelte'
  import { newTableStore } from '@/State/table'
  import { onMount } from 'svelte'

  export let data = []
  export let actions = {}

  const state = newTableStore()
  $: columns = get_columns(data)

  onMount(() => {
    if (data.length) {
      state.selectItem(data[0])
    }
  })
</script>

<div class="table-actions">
  {#each Object.keys(actions) as name}
    <Button text={name} action={(...arg) => actions[name](state, ...arg)} />
  {/each}
</div>

{#if data.length}
  <div class="table-container">
    <table>
      <thead>
      <tr>
        {#each columns as column}
          <th>{column}</th>
        {/each}
      </tr>
      </thead>
      <tbody>
      {#each data as item}
        <tr on:click={() => state.selectItem(item)}
            class:selected={item?.id === $state.selected?.id}
        >
          {#each columns as column, i}
            {#if i === 0}
              <th>{item[column] ?? ''}</th>
            {:else}
              <td>{item[column] ?? ''}</td>
            {/if}
          {/each}
        </tr>
      {/each}
      </tbody>
    </table>
  </div>
{/if}

<style lang="scss">
  .table-actions {
    @apply mb-4 flex gap-4;
  }

  .table-container {
    @apply min-w-full max-w-full overflow-auto;
  }

  table {
    @apply min-w-full relative;

    th, td {
      @apply border border-gray-300;
    }

    th {
      @apply px-6 py-3 uppercase tracking-wider;
      @apply text-left text-sm font-medium uppercase;
      @apply sticky top-0;
      @apply bg-blue-50;

      &:first-child {
        @apply left-0 z-10;
      }
    }

    tbody {
      @apply bg-white;

      tr:nth-child(even) {
        @apply bg-red-50;
      }

      tr {
        @apply hover:bg-yellow-50;
      }
      tr.selected {
        @apply outline outline-1 outline-blue-600;
      }

      td {
        @apply px-6 py-3 whitespace-nowrap;
      }
    }

    th:first-child {
      width: 1rem;
    }
  }
</style>
