<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'Import'

  // import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'

  const test = [
    {
      id: 1,
      filename: 'test.txt'
    },
    {
      id: 2,
      filename: 'test.txt'
    },
    {
      id: 3,
      filename: 'test.txt'
    },
    {
      id: 4,
      filename: 'test.txt'
    },
    {
      id: 5,
      filename: 'test.txt'
    },
    {
      id: 6,
      filename: 'test.txt'
    }
  ]
</script>

<Table data={test} />
