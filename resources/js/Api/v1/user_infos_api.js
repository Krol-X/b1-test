import { api1Method } from './api_v1'

export const user_infos_api = {
  create: api1Method('user-info'),
  list: api1Method('user-info', 'get'),
  get: api1Method('user-info', 'get', true),
  update: api1Method('user-info', 'put', true),
  delete: api1Method('user-info', 'delete', true)
}
