<template>
    <Link
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
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Offer } from '@/Types/offers';

interface Props {
    offer: Offer;
    formatSalary: (amount: number) => string;
    formatDate: (date: string) => string;
}

defineProps<Props>();
</script>
