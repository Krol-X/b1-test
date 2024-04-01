<script>
  import { get_columns } from '@/Utils'

  export let data = []

  $: columns = get_columns(data)
</script>

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
      <tr>
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

<style lang="scss">
  .table-container {
    @apply min-w-full max-w-full overflow-auto;
  }

  table {
    @apply min-w-full divide-y divide-gray-200 relative;

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
      @apply bg-white divide-y divide-gray-200;

      tr:nth-child(even) {
        @apply bg-red-50;
      }

      td {
        @apply px-6 py-3 whitespace-nowrap border-l;
      }
    }

    th:first-child {
      width: 1rem;
    }
  }
</style>
