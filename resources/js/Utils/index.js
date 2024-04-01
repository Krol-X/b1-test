export const get_columns = (data, for_all) => {
  const columns = new Set()
  if (data.length) {
    if (for_all) {
      data.forEach(item => {
        Object.keys(item).forEach(column => columns.add(column))
      })
    } else {
      Object.keys(data[0]).forEach(column => columns.add(column))
    }
  }
  return columns
}
