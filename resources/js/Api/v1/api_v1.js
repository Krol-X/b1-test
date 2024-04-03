export const api1Method = (name, http_method = 'post', has_param = false, url_only = false) => {
  const prefix = '/api/v1'

  const func = async (param, data_body, resHandler) => {
    let url = `${prefix}/${name}`
    if (param) {
      url += `/${param}`
    }
    if (url_only) {
      return url
    }

    const params = {}
    if (data_body?.data) params.data = data_body.data
    if (data_body?.body) params.body = data_body.body

    console.log(`API1: ${url} | ${params}`)

    const response = await axios({
      method: http_method,
      url: url,
      ...data_body
    })
    console.log(`Response: ${response.statusText}`)

    if (resHandler) {
      resHandler(response)
    }

    return response
  }

  return has_param
    ? async (param, data_body, resHandler) => await func(param, data_body, resHandler)
    : async (data_body, resHandler) => await func(null, data_body, resHandler)
}
