<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  import { get } from 'svelte/store'

  $layout = 'default'
  $title = 'Импорт'

  import Table from '@/Components/Table.svelte'
  import { files } from '@/State/index.js'
  import { resetInput } from '@/Utils/index.js'
  import { import_api } from '@/Api/v1/import_api.js'

  let input_elem
  let selected_file

  async function uploadFile() {
    await files.reqUploadFile(selected_file[0])
    resetInput(input_elem)
  }

  const actions = {
    'Загрузить': () => {
      input_elem.click()
    },
    'Удалить файл': (state) => {
      const selected = get(state).selected
      if (selected) {
        files.reqDeleteFile(selected.id)
      }
      state.selectItem()
    },
    'Импортировать': async() => {
      await import_api.import()
      await files.reqListFiles()
    }
  }

  files.reqListFiles()
</script>

<input type="file" accept="text/csv" class="hidden"
       bind:this={input_elem}
       bind:files={selected_file}
       on:change={uploadFile}
/>

<Table data={$files} {actions} hidden_fields={['id']} />
