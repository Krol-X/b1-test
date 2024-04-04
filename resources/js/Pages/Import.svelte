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
    'Импортировать': () => {},
    'Удалить': (state) => {
      const selected = get(state).selected
      if (selected) {
        files.reqDeleteFile(selected.id)
      }
      state.selectItem()
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
