import { format as dateFnsFormat } from 'date-fns'

export const format = (date, formatStr = null) =>
  dateFnsFormat(new Date(date), formatStr || 'MM/dd/yyyy')
