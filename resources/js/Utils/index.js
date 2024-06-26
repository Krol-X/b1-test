export const getColumns = (data, for_all) => {
  const columns = new Set()
  if (data.length) {
    if (for_all) {
      data.forEach((item) => {
        Object.keys(item).forEach((column) => columns.add(column))
      })
    } else {
      Object.keys(data[0]).forEach((column) => columns.add(column))
    }
  }
  return columns
}

export const resetInput = (elem) => {
  const t = elem.type
  elem.type = ''
  elem.type = t
}

export const gotoUrl = (url) => {
  const link = document.createElement('a');
  link.href = url;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
