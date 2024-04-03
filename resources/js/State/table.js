import { writable } from 'svelte/store'
import { departments_api } from '@/Api/v1/departments_api.js'
import { getAxiosData } from '@/Utils/api.js'

export function newTableStore() {
  const { subscribe, set, update } = writable({
    selected: null
  })

  function selectItem(item) {
    update(old_state => ({...old_state, selected: item}))
  }

  return {
    subscribe,
    selectItem
  }
}
