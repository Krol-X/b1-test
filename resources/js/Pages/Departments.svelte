<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  import { departments_api } from '@/Api/v1/departments_api.js'

  $layout = 'default'
  $title = 'Departments'

  import { get } from 'svelte/store'
  import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'
  import { gotoUrl } from '@/Utils/index.js'

  const actions_default = {
    'Удалить': (state) => {
      const selected = get(state).selected
      if (selected) {
        departments.reqDeleteDepartment(selected['XML_ID'])
      }
      state.selectItem()
    },
    'Экспортировать': (state) => {
      departments_api.export().then(url => gotoUrl(url))
    }
  }

  var actions = actions_default

  departments.reqListDepartments()
</script>

<Table data={$departments} {actions} id_key='XML_ID' />
