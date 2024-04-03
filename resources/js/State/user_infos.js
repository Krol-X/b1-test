import * as yup from 'yup'
import { writable } from 'svelte/store'
import { user_infos_api } from '@/Api/v1/user_infos_api.js'
import { getAxiosData } from '@/Utils/api.js'

function newUserInfosStore() {
  const { subscribe, set, update } = writable([])

  const TUserInfoNew = yup.object({
    department_id: yup.string(),
    last_name: yup.string().required(),
    name: yup.string().required(),
    second_name: yup.string().required(),
    work_position: yup.string().required(),
    mobile_phone: yup.string().required(),
    phone: yup.string().required(),
    login: yup.string().required(),
    password: yup.string().required()
  })
  const TUserInfo = yup.object({
    id: yup.number().required(),
    department_id: yup.string(),
    last_name: yup.string().required(),
    name: yup.string().required(),
    second_name: yup.string().required(),
    work_position: yup.string().required(),
    mobile_phone: yup.string().required(),
    phone: yup.string().required(),
    login: yup.string().required(),
    password: yup.string().required()
  })
  const TUserInfoArray = yup.array().of(TUserInfo)

  //
  // Create UserInfo
  //

  async function reqCreateUserInfo(fields) {
    const data = await TUserInfoNew.validate(fields)
    await user_infos_api.create(data, resCreateUserInfo)
  }

  async function resCreateUserInfo(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      const new_record = await TUserInfo.validate(data)
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
      const data = JSON.parse(raw_data.data)
      const user_infos = await TUserInfoArray.validate(data)
      set(user_infos)
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
    const data = await TUserInfoNew.validate(fields)
    await user_infos_api.update(id, data, resUpdateUserInfo)
  }

  async function resUpdateUserInfo(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      const record = await TUserInfo.validate(data)
      update((items) => [...items.filter((it) => it.id !== record.id), record])
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
        const id = raw_data?.id
        update((items) => items.filter((it) => it.id !== id))
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
