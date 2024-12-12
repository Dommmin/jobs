export function useFormatters() {
    const formatSalary = (amount: number): string => {
        return new Intl.NumberFormat('pl-PL').format(amount);
    };

    const formatDate = (date: string): string => {
        return new Date(date).toLocaleDateString('pl-PL', {
            day: 'numeric',
            month: 'short'
        });
    };

    return {
        formatSalary,
        formatDate,
    };
}
