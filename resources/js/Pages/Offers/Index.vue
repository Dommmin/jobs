<template>
    <AppLayout title="Home">
        <div class="p-6 mx-auto space-y-8 max-w-7xl">
            <!-- Search and Filters Section -->
            <div class="p-6 shadow-lg bg-base-200 rounded-xl animate-fadeIn">
                <h2 class="mb-4 text-2xl font-bold text-primary">Find Your Perfect Job</h2>

                <!-- Search Input -->
                <div class="mb-4 form-control">
                    <div class="input-group">
                        <input
                            type="text"
                            placeholder="Search by title or company..."
                            class="w-full input input-bordered"
                        />
                    </div>
                </div>

                <!-- Filters Grid -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-6">
                    <select
                        v-model="filters.location"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">📍 Location</option>
                        <option v-for="loc in locations" :key="loc.slug" :value="loc.slug">
                            {{ loc.name }}
                        </option>
                    </select>

                    <select
                        v-model="filters.experience"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">👨‍💼 Experience</option>
                        <option v-for="exp in experiences" :key="exp.slug" :value="exp.slug">
                            {{ exp.name }}
                        </option>
                    </select>

                    <select
                        v-model="filters.contract"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">📄 Contract</option>
                        <option v-for="contract in contracts" :key="contract.slug" :value="contract.slug">
                            {{ contract.name }}
                        </option>
                    </select>

                    <select
                        v-model="filters.specialization"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">🎯 Specialization</option>
                        <option v-for="spec in specializations" :key="spec.slug" :value="spec.slug">
                            {{ spec.name }}
                        </option>
                    </select>

                    <select
                        v-model="filters.workType"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">🏢 Work Type</option>
                        <option value="remote">Remote</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="office">Office</option>
                    </select>

                    <select
                        v-model="sortOrder"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="latest">⭐ Newest First</option>
                        <option value="salary_max">💰 Highest Salary</option>
                        <option value="salary_min">💰 Lowest Salary</option>
                    </select>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap gap-2 mt-4">
                    <div
                        v-for="(value, key) in activeFilters"
                        :key="key"
                        class="gap-2 badge badge-primary animate-scaleIn"
                    >
                        {{ value }}
                        <button @click="removeFilter(key)" class="btn btn-xs btn-circle">✕</button>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl italic font-bold text-transparent bg-gradient-to-r from-primary to-secondary bg-clip-text">
                        {{ total }} Offers Found
                    </h1>
                    <span class="text-sm text-gray-500">
                        Showing {{ offers.data.length }} of {{ total }} results
                    </span>
                </div>

                <!-- Offers Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="offer in offers.data"
                        :key="offer.id"
                        :href="route('offers.show', offer.slug)"
                        class="relative overflow-hidden transition-all duration-300 transform shadow-lg group bg-base-100 rounded-xl hover:shadow-2xl hover:-translate-y-1"
                        prefetch="hover"
                    >
                        <div class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-primary group-hover:opacity-5"></div>
                        <div class="p-6 space-y-4">
                            <!-- Header -->
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold transition-colors text-primary group-hover:text-secondary">
                                    {{ offer.title }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ offer.company_name }}</p>
                            </div>

                            <!-- Salary -->
                            <div>
                                <p v-if="!offer.salary_min || !offer.salary_max"
                                   class="text-sm text-error">
                                    Unspecified Salary
                                </p>
                                <p v-else
                                   class="text-sm font-semibold text-success">
                                    {{ formatSalary(offer.salary_min) }} - {{ formatSalary(offer.salary_max) }} PLN
                                </p>
                            </div>

                            <!-- Tags Section -->
                            <div class="space-y-2">
                                <!-- Work Types -->
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="work_type in offer.work_type_names"
                                        :key="work_type"
                                        class="badge badge-primary badge-sm"
                                    >
                                        {{ work_type }}
                                    </span>
                                </div>

                                <!-- Locations -->
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="location in offer.location_names"
                                        :key="location"
                                        class="badge badge-ghost badge-sm"
                                    >
                                        📍 {{ location }}
                                    </span>
                                </div>

                                <!-- Experience & Contract -->
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="exp in offer.experience_names"
                                        :key="exp"
                                        class="badge badge-secondary badge-sm"
                                    >
                                        {{ exp }}
                                    </span>
                                    <span
                                        v-for="contract in offer.contract_names"
                                        :key="contract"
                                        class="badge badge-accent badge-sm"
                                    >
                                        {{ contract }}
                                    </span>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ formatDate(offer.created_at) }}</span>
                                <span class="text-primary">View Details →</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <Pagination :links="offers.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import {ref, computed} from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

interface Offer {
    id: number;
    slug: string;
    title: string;
    company_name: string;
    salary_min: number | null;
    salary_max: number | null;
    location_names: string[];
    work_type_names: string[];
    experience_names: string[];
    contract_names: string[];
    specialization_names: string[];
    created_at: string;
}

interface Offers {
    data: Offer[],
    links: object,
}

interface Location {
    slug: string,
    name: string,
}

interface Filters {
    search: string,
    location: string,
    experience: string,
    contract: string,
    specialization: string,
    workType: string,
}

const props = defineProps<{
    offers: Offers;
    locations: Location[],
    experiences: Array<{ slug: string; name: string }>;
    contracts: Array<{ slug: string; name: string }>;
    specializations: Array<{ slug: string; name: string }>;
    total: number;
    filters: Filters;
}>();

const filters = ref({
    search: props.filters.search || '',
    location: props.filters.location || '',
    experience: props.filters.experience || '',
    contract: props.filters.contract || '',
    specialization: props.filters.specialization || '',
    workType: props.filters.workType || '',
});

const sortOrder = ref('latest');

const activeFilters = computed(() => {
    const active: Record<string, string> = {};
    Object.entries(filters.value).forEach(([key, value]) => {
        if (value) {
            active[key] = `${key.charAt(0).toUpperCase() + key.slice(1)}: ${value}`;
        }
    });
    return active;
});

// Helper functions
const formatSalary = (amount: number): string => {
    return new Intl.NumberFormat('pl-PL').format(amount);
};

const formatDate = (date: string): string => {
    return new Date(date).toLocaleDateString('pl-PL', {
        day: 'numeric',
        month: 'short'
    });
};

const removeFilter = (key: string) => {
    filters.value[key as keyof typeof filters.value] = '';
};

const applyFilters = () => {
    router.get(route('offers.index'), filters.value);
};
</script>

<style scoped>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleIn {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

.animate-scaleIn {
    animation: scaleIn 0.3s ease-out;
}
</style>
