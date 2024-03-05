import { format, formatDistance, intervalToDuration, differenceInDays } from 'date-fns'

export const formatDate = (date, formatStr) => {
  let formatString = formatStr  ? formatStr : 'yyyy-MM-dd'

  return format(new Date(date), formatString);
}

export const formatDateFromNow = (date) => {
  return formatDistance(new Date(date), new Date(), { addSuffix: true })
}

export const countdownToDate = (endDate) => {
  return intervalToDuration({
      start: new Date(), 
      end: new Date(endDate),
  })
}

export const daysToDate = (endDate) => {
  return differenceInDays(
    new Date(endDate),
    new Date(), 
  )
}