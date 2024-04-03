export const api1Method = (name, http_method = 'post', has_param = false) => {
  const prefix = '/api/v1'

  const func = async (param, data, resHandler) => {
    console.log(`API1/${name}: ${data}`)

    const response = await axios({
      method: http_method,
      url: param ? `${prefix}/${name}/${param}` : `${prefix}/${name}`,
      data: data
    })

    if (resHandler) {
      resHandler(response)
    }

    return response
  }

  return has_param
    ? async (param, data, resHandler) => await func(param, data, resHandler)
    : async (data, resHandler) => await func(null, data, resHandler)
}
