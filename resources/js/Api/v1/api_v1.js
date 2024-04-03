export const api1Method = (name, http_method = 'post', has_param = false, url_only = false) => {
  const prefix = '/api/v1'

  const func = async (param, data, resHandler) => {
    let url = `${prefix}/${name}`
    if (param) {
      url += `/${param}`
    }
    if (url_only) {
      return url
    }

    console.log(`API1: ${url} | ${data}`)

    const response = await axios({
      method: http_method,
      url: url,
      data: data
    })
    console.log(`Response: ${response.statusText}`)

    if (resHandler) {
      resHandler(response)
    }

    return response
  }

  return has_param
    ? async (param, data, resHandler) => await func(param, data, resHandler)
    : async (data, resHandler) => await func(null, data, resHandler)
}
