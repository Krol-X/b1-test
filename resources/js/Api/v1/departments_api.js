import { api1Method } from './api_v1'

export const departments_api = {
  list: api1Method('department', 'get'),
  delete: api1Method('department', 'delete', true),
  export: api1Method('export/departments', 'get', false, true)
}
