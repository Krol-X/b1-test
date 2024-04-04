import { api1Method } from './api_v1'

export const departments_api = {
  list: api1Method('departments', 'get'),
  delete: api1Method('departments', 'delete', true),
  export: api1Method('export/departments', 'get', false, true)
}
