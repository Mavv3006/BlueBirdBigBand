export function useFormatDate(date: string): string {
    return new Date(date).toLocaleDateString(
        'de-DE',
        {
            weekday: 'long',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        }
    )
}
