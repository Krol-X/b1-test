import { api1Method } from './api_v1'

export const user_infos_api = {
  create: api1Method('users'),
  list: api1Method('users', 'get'),
  get: api1Method('users', 'get', true),
  update: api1Method('users', 'put', true),
  delete: api1Method('users', 'delete', true),
  export: api1Method('export/users', 'get', false, true)
}
