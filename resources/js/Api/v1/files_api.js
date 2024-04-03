import { api1Method } from './api_v1'

export const files_api = {
  upload: api1Method('files'),
  list: api1Method('files', 'get'),
  download: api1Method('files', 'get', true, true),
  delete: api1Method('files', 'delete', true)
}
