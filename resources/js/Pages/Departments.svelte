<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'Departments'

  import { onMount } from 'svelte'
  import { departments, files } from '@/State'
  import Table from '@/Components/Table.svelte'

  onMount(async () => {
    await departments.reqListDepartments()
  })

  const actions = {
    'Создать': () => {},
    'Изменить': () => {},
    'Удалить': () => {}
  }
</script>

<Table data={$departments} {actions} />
