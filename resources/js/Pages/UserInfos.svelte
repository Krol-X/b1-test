<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'Данные пользователей'

  import { user_infos } from '@/State'
  import Table from '@/Components/Table.svelte'
  import { get } from 'svelte/store'
  import { user_infos_api } from '@/Api/v1/user_infos_api'
  import { gotoUrl } from '@/Utils/index.js'

  const actions_default = {
    'Удалить запись': (state) => {
      const selected = get(state).selected
      if (selected) {
        user_infos.reqDeleteUserInfo(selected['XML_ID'])
      }
      state.selectItem()
    },
    'Удалить все записи': (state) => {
      user_infos.reqDeleteAllUserInfos()
      state.selectItem()
    },
    'Экспортировать': (state) => {
      user_infos_api.export().then(url => gotoUrl(url))
    }
  }

  var actions = actions_default

  user_infos.reqListUserInfos()
</script>

<Table data={$user_infos} {actions} id_key='XML_ID' />
