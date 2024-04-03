import { writable } from 'svelte/store'
import { files_api } from '@/Api/v1/files_api.js'
import { getAxiosData } from '@/Utils/api.js'

function newFilesStore() {
  const { subscribe, set, update } = writable([])

  //
  // Upload File
  //

  async function reqUploadFile(file) {
    await files_api.upload(file, resUploadFile)
  }

  async function resUploadFile(response) {
    try {
      const raw_data = getAxiosData(response)
      const new_record = raw_data.data
      update((items) => [...items, new_record])
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // List Files
  //

  async function reqListFiles() {
    await files_api.list(null, resListFiles)
  }

  async function resListFiles(response) {
    try {
      const raw_data = getAxiosData(response)
      const records = raw_data.data
      set(records)
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // Get File Url
  //

  async function getFileUrl(id) {
    const url = await files_api.download(id)
    return url
  }

  //
  // Delete File
  //

  async function reqDeleteFile(id) {
    await files_api.delete(id, null, resDeleteDeleteFile)
  }

  async function resDeleteDeleteFile(response) {
    try {
      const raw_data = getAxiosData(response)
      if (raw_data) {
        const id = raw_data?.id
        update((items) => items.filter((it) => it.id !== id))
      }
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  return {
    subscribe,
    reqUploadFile,
    reqListFiles,
    getFileUrl,
    resDeleteDeleteFile
  }
}

export const files_store = newFilesStore()
