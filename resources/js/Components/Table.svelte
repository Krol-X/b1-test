<script>
  import { getColumns } from '@/Utils'
  import Button from '@/Components/Table/Button.svelte'
  import { newTableStore } from '@/State/table'

  export let data = []
  export let actions = {}
  export let id_key = 'id'
  export let hidden_fields = []

  const state = newTableStore()
  $: columns = getColumns(data)
  $: selected = $state?.selected
  $: selected_key = selected? selected[id_key]: null

  function select(item) {
    if ($state.selected === item) {
      state.selectItem()
    } else {
      state.selectItem(item)
    }
  }
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
          {#if !hidden_fields.includes(column)}
            <th>
              <div class="cell">{column}</div>
            </th>
          {/if}
        {/each}
      </tr>
      </thead>
      <tbody>
      {#each data as item}
        <tr on:click={() => select(item)}
            class:selected={item[id_key] === selected_key}
        >
          {#each columns as column, i}
            {#if !hidden_fields.includes(column)}
              <td>
                <div class="cell">{item[column] ?? ''}</div>
              </td>
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
    @apply min-w-full relative border-collapse;
    @apply bg-white;

    th, td {
      @apply border border-gray-300;
      @apply whitespace-nowrap;
    }

    th {
      @apply sticky top-0;
      @apply text-sm font-medium uppercase tracking-wider text-left;
      @apply bg-blue-50;
    }

    .cell {
      @apply px-6 py-3 whitespace-nowrap;
    }

    tr:nth-child(even), tr:nth-child(even) {
      @apply bg-red-50;
    }

    tr.selected td {
      @apply bg-cyan-200;
    }
    tr:hover, tr:hover td {
      @apply bg-yellow-50;
    }
    tr.selected:hover, tr.selected:hover td {
      @apply bg-blue-100;
    }

    th:first-child {
      width: 1rem;
    }
  }
</style>
