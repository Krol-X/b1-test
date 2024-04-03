<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  import Button from '@/Components/Table/Button.svelte'

  $layout = 'default'
  $title = 'Импорт'

  // import { departments } from '@/State'
  import Table from '@/Components/Table.svelte'
  import { onMount } from 'svelte'
  import { files } from '@/State/index.js'

  onMount(async () => {
    await files.reqListFiles()
  })

  const actions = {
    'Загрузить': () => {
      // Выбрать файл
      // Загрузить на сервер
    },
    'Имортировать': () => {},
    'Удалить': () => {
      // Удалить файл на сервере
      // Удалить файл из списка
    }
  }
</script>

<Table data={$files} {actions} />
