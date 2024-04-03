import { writable } from 'svelte/store'
import { departments_api } from '@/Api/v1/departments_api.js'
import { getAxiosData } from '@/Utils/api.js'

function newDepartmentsStore() {
  const { subscribe, set, update } = writable([])

  //
  // Create Department
  //

  async function reqCreateDepartment(fields) {
    await departments_api.create(fields, resCreateDepartment)
  }

  async function resCreateDepartment(response) {
    try {
      const raw_data = getAxiosData(response)
      const new_record = JSON.parse(raw_data.data)
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
      const departments = JSON.parse(raw_data.data)
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
    await departments_api.update(id, fields, resUpdateDepartment)
  }

  async function resUpdateDepartment(response) {
    try {
      const raw_data = getAxiosData(response)
      const data = JSON.parse(raw_data.data)
      update((items) => [...items.filter((it) => it.id !== data.id), data])
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
