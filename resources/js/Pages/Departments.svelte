<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'Departments'

  import { onMount } from 'svelte'
  import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'

  onMount(async () => {
    await departments.reqListDepartments()
  })
</script>

<Table data={$departments} />
