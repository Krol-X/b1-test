<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  import { departments_api } from '@/Api/v1/departments_api.js'

  $layout = 'default'
  $title = 'Departments'

  import { onMount } from 'svelte'
  import { get } from 'svelte/store'
  import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'
  import { gotoUrl } from '@/Utils/index.js'

  onMount(async () => {
    await departments.reqListDepartments()
  })

  const actions_default = {
    'Создать': () => {
    },
    'Изменить': (state) => {
      const selected = get(state).selected
      state.editItem(selected)
      actions = actions_edit
    },
    'Удалить': (state) => {
      const selected = get(state).selected
      if (selected) {
        departments.reqDeleteDepartment(selected.id)
      }
      state.selectItem()
    },
    'Экспортировать': (state) => {
      departments_api.export().then(url => gotoUrl(url))
    }
  }

  const actions_edit = {
    'Отменить': (state) => {
      state.editItem()
      actions = actions_default
    },
    'Сохранить': (state) => {
      const edited = get(state).edited
      if (edited && edited_fields) {
        const edited_fields = get(state).edited_fields
        departments.reqUpdateDepartment(edited.id, edited_fields)
      }
      state.editItem()
    }
  }

  var actions = actions_default
</script>

<Table data={$departments} {actions} />
