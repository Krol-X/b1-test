<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  import { onMount } from 'svelte'

  $layout = 'default'
  $title = 'User Infos'

  import { user_infos } from '@/State'
  import Table from '@/Components/Table.svelte'
  import { get } from 'svelte/store'
  import { user_infos_api } from '@/Api/v1/user_infos_api'
  import { gotoUrl } from '@/Utils/index.js'

  onMount(async () => {
    await user_infos.reqListUserInfos()
  })

  const actions_default = {
    'Удалить': (state) => {
      const selected = get(state).selected
      if (selected) {
        user_infos.reqDeleteUserInfo(selected.id)
      }
      state.selectItem()
    },
    'Экспортировать': (state) => {
      user_infos_api.export().then(url => gotoUrl(url))
    }
  }

  var actions = actions_default
</script>

<Table data={$user_infos} {actions} />
