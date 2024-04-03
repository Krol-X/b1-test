import * as yup from 'yup'
import { writable } from 'svelte/store'
import { departments_api } from '@/Api/v1/departments_api.js'
import { getAxiosData } from '@/Utils/api.js'

function newDepartmentsStore() {
  const { subscribe, set, update } = writable([])

  const TDepartmentNew = yup.object({
    name: yup.string().required(),
    parent_id: yup.number().required()
  })
  const TDepartment = yup.object({
    id: yup.number().required(),
    name: yup.string().required(),
    parent_id: yup.number().nullable()
  })
  const TDepartmentArray = yup.array().of(TDepartment)

  //
  // Create Department
  //

  async function reqCreateDepartment(fields) {
    const data = await TDepartmentNew.validate(fields)
    await departments_api.create(data, resCreateDepartment)
  }

  async function resCreateDepartment(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      const new_record = await TDepartment.validate(data)
      update((items) => [...items, new_record])
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // List Departments
  //

  async function reqListDepartments() {
    await departments_api.list(null, resListDepartments)
  }

  async function resListDepartments(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      const departments = await TDepartmentArray.validate(data)
      set(departments)
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // Get Department
  //

  async function getDepartment(id) {
    const record = await departments_api.get(id)
    return record
  }

  //
  // Update Department
  //

  async function reqUpdateDepartment(id, fields) {
    const data = await TDepartmentNew.validate(fields)
    await departments_api.update(id, data, resUpdateDepartment)
  }

  async function resUpdateDepartment(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      const record = await TDepartment.validate(data)
      update((items) => [...items.filter((it) => it.id !== record.id), record])
    } catch (err) {
      console.error(JSON.stringify(err))
    }
  }

  //
  // Delete Department
  //

  async function reqDeleteDepartment(id) {
    await departments_api.delete(id, null, resDeleteDepartment)
  }

  async function resDeleteDepartment(response) {
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
    reqCreateDepartment,
    reqListDepartments,
    getDepartment,
    reqUpdateDepartment,
    reqDeleteDepartment
  }
}

export const departments_store = newDepartmentsStore()
