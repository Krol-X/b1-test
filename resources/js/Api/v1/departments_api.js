import { api1Method } from './api_v1'

export const departments_api = {
  create: api1Method('department'),
  list: api1Method('department', 'get'),
  get: api1Method('department', 'get', true),
  update: api1Method('department', 'put', true),
  delete: api1Method('department', 'delete', true),
  export: api1Method('export/departments', 'get', false, true)
}
