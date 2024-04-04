import { writable } from 'svelte/store'
import { user_infos_api } from '@/Api/v1/user_infos_api.js'
import { getAxiosData } from '@/Utils/api.js'

export function newUserInfosStore() {
  const { subscribe, set, update } = writable([])

  //
  // Create UserInfo
  //

  async function reqCreateUserInfo(fields) {
    await user_infos_api.create(fields, resCreateUserInfo)
  }

  async function resCreateUserInfo(response) {
    try {
      const raw_data = getAxiosData(response)
      const new_record = raw_data.data
      update((items) => [...items, new_record])
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // List UserInfos
  //

  async function reqListUserInfos() {
    await user_infos_api.list(null, resListUserInfos)
  }

  async function resListUserInfos(response) {
    try {
      const raw_data = getAxiosData(response)
      const records = raw_data.data
      set(records)
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // Get UserInfo
  //

  async function getUserInfo(id) {
    const record = await user_infos_api.get(id)
    return record
  }

  //
  // Update UserInfo
  //

  async function reqUpdateUserInfo(id, fields) {
    await user_infos_api.update(id, fields, resUpdateUserInfo)
  }

  async function resUpdateUserInfo(response) {
    try {
      const raw_data = getAxiosData(response)
      const record = raw_data.data
      update((items) => [...items.filter((it) => it['XML_ID'] !== record['XML_ID']), record])
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // Delete UserInfo
  //

  async function reqDeleteUserInfo(id) {
    await user_infos_api.delete(id, null, resDeleteUserInfo)
  }

  async function resDeleteUserInfo(response) {
    try {
      const raw_data = getAxiosData(response)
      if (raw_data) {
        const id = Number(raw_data?.id)
        update((items) => items.filter((it) => it['XML_ID'] !== id))
      }
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  return {
    subscribe,
    reqCreateUserInfo,
    reqListUserInfos,
    getUserInfo,
    reqUpdateUserInfo,
    reqDeleteUserInfo
  }
}

export const user_infos_store = newUserInfosStore()
