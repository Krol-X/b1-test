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
  import { resetInput } from '@/Utils/index.js'

  let input_elem
  let selected_file

  onMount(async () => {
    await files.reqListFiles()
  })

  async function uploadFile() {
    // const formData = new FormData();
    // formData.append('file', file);
    await files.reqUploadFile(selected_file[0])
    resetInput(input_elem)
  }

  const actions = {
    'Загрузить': () => {
      input_elem.click()
    },
    'Имортировать': () => {},
    'Удалить': () => {
      // Удалить файл на сервере
      // Удалить файл из списка
    }
  }
</script>

<input type="file" accept="text/csv" class="hidden"
       bind:this={input_elem}
       bind:files={selected_file}
       on:change={uploadFile}
/>

<Table data={$files} {actions} />
