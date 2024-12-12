import { customRef } from 'vue';

export function useDebounce<T>(value: T, delay = 300) {
    return customRef((track, trigger) => {
        let timeout;
        return {
            get() {
                track();
                return value;
            },
            set(newValue: T) {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    value = newValue;
                    trigger();
                }, delay);
            },
        };
    });
}
