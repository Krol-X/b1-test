<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'Departments'

  // import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'

  const test = [
    {
      id: 1,
      name: 'Test',
      parent_id: ''
    },
    {
      id: 2,
      name: 'Test',
      parent_id: ''
    },
    {
      id: 3,
      name: 'Test',
      parent_id: ''
    },
    {
      id: 4,
      name: 'Test',
      parent_id: ''
    },
    {
      id: 5,
      name: 'Test',
      parent_id: ''
    },
    {
      id: 6,
      name: 'Test',
      parent_id: ''
    }
  ]
</script>

<Table data={test} />
