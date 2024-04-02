import { api1Method } from './api_v1'

export const departments_api = {
  upload: api1Method('department'),
  list: api1Method('department', 'get'),
  download: api1Method('department', 'get', true),
  delete: api1Method('department', 'delete', true)
}
