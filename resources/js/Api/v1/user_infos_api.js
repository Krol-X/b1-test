import { api1Method } from './api_v1'

export const user_infos_api = {
  list: api1Method('users', 'get'),
  delete: api1Method('users', 'delete', true),
  deleteAll: api1Method('users', 'delete', false),
  export: api1Method('export/users', 'get', false, true)
}
