export function getAxiosData(response) {
  return (response.status < 300)? response.data: null
}
