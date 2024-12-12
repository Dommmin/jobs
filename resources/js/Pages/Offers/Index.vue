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
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search by title or company..."
                            class="w-full input input-bordered"
                        />
                        <div v-if="isSearching" class="absolute right-3 top-3">
                            <div class="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                        </div>
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
                        v-model="filters.sortOrder"
                        class="w-full transition-all select select-bordered hover:select-primary"
                        @change="applyFilters"
                    >
                        <option value="">⭐ Newest First</option>
                        <option value="salary_max">💰 Highest Salary</option>
                        <option value="salary_min">💰 Lowest Salary</option>
                    </select>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap gap-2 mt-4">
                    <TransitionGroup name="filter">
                        <div
                            v-for="(value, key) in activeFilters"
                            :key="key"
                            class="gap-2 badge badge-primary"
                        >
                            {{ value }}
                            <button
                                @click="removeFilter(key)"
                                class="btn btn-xs btn-circle"
                                aria-label="Remove filter"
                            >✕</button>
                        </div>
                    </TransitionGroup>
                </div>
            </div>

            <!-- Results Section -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl italic font-bold text-transparent bg-gradient-to-r from-primary to-secondary bg-clip-text">
                        {{ offers.total }} Offers Found
                    </h1>
                    <span class="text-sm text-gray-500">
                        Showing from {{ offers.from }} to {{ offers.to }} of {{ offers.total }}
                    </span>
                </div>

                <!-- Offers Grid -->
                <TransitionGroup
                    name="list"
                    tag="div"
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <JobCard
                        v-for="offer in offers.data"
                        :key="offer.id"
                        :offer="offer"
                        :format-salary="formatSalary"
                        :format-date="formatDate"
                    />
                </TransitionGroup>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <Pagination :links="offers.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import type { OffersResponse } from '@/Types/offers';
import type { FilterOption, Filters } from '@/Types/filters';
import { useDebounce } from '@/Composables/useDebounce';
import { useFilters } from '@/Composables/useFilters';
import { useFormatters } from '@/Composables/useFormatters';
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JobCard from "@/Components/JobCard.vue";

interface Props {
    offers: OffersResponse;
    locations: FilterOption[];
    experiences: FilterOption[];
    contracts: FilterOption[];
    specializations: FilterOption[];
    filters: Filters;
}

const props = defineProps<Props>();

const { filters, activeFilters, removeFilter, applyFilters } = useFilters(props.filters);
const { formatSalary, formatDate } = useFormatters();

const isSearching = ref(false);
const searchQuery = useDebounce('', 500);

watch(searchQuery, (newValue) => {
    isSearching.value = true;
    filters.value.search = newValue;
    applyFilters();
    setTimeout(() => {
        isSearching.value = false;
    }, 300);
});
</script>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}

.list-leave-active {
    position: absolute;
}

.filter-move,
.filter-enter-active,
.filter-leave-active {
    transition: all 0.3s ease;
}

.filter-enter-from,
.filter-leave-to {
    opacity: 0;
    transform: scale(0.9);
}
</style>
