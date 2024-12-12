import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import type { Filters} from "../Types/filters";

export function useFilters(initialFilters: Filters) {
    const filters = ref<Filters>({
        search: initialFilters.search || '',
        location: initialFilters.location || '',
        experience: initialFilters.experience || '',
        contract: initialFilters.contract || '',
        specialization: initialFilters.specialization || '',
        workType: initialFilters.workType || '',
        sortOrder: initialFilters.sortOrder || '',
    });

    const activeFilters = computed(() => {
        const active: Record<string, string> = {};

        Object.entries(filters.value).forEach(([key, value]) => {
            if (value && key !== 'sortOrder') {
                active[key] = `${key.charAt(0).toUpperCase() + key.slice(1)}: ${value}`;
            }
        });

        return active;
    });

    const removeFilter = (key: keyof Filters) => {
        filters.value[key] = '';
        applyFilters();
    };

    const applyFilters = () => {
        const filteredFilters = Object.fromEntries(
            Object.entries(filters.value).filter(([_, value]) => value !== '')
        );

        router.get(
            route('offers.index'),
            { ...filteredFilters },
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
    };

    return {
        filters,
        activeFilters,
        removeFilter,
        applyFilters,
    };
}
