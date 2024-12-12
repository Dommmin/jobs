<template>
    <AppLayout :title="offer.title">
        <div class="max-w-7xl mx-auto p-6 space-y-8">
            <!-- Back Button -->
            <Link
                :href="route('offers.index')"
                class="btn btn-ghost gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Offers
            </Link>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Header Section -->
                    <div class="bg-base-100 rounded-xl p-8 shadow-lg space-y-4">
                        <h1 class="text-3xl font-bold text-primary">{{ offer.title }}</h1>

                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="w-16 h-16 rounded-full bg-base-300 flex items-center justify-center">
                                    <span class="text-2xl">{{ offer.company.name }}</span>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold">{{ offer.company.name }}</h2>
                                <p class="text-sm text-gray-500">Posted {{ formatDate(offer.created_at) }}</p>
                            </div>
                        </div>

                        <!-- Tags Section -->
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="type in offer.work_type_array"
                                :key="type"
                                class="badge badge-primary"
                            >
                                {{ type }}
                            </span>
                            <span
                                v-for="location in offer.location_array"
                                :key="location"
                                class="badge badge-ghost"
                            >
                                📍 {{ location }}
                            </span>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="bg-base-100 rounded-xl p-8 shadow-lg prose max-w-none">
                        <h2 class="text-2xl font-semibold mb-4">Job Description</h2>
                        <div v-html="offer.description"></div>
                    </div>

                    <!-- Tech Stack Section -->
                    <div v-if="offer.tech_stack && offer.tech_stack.length" class="bg-base-100 rounded-xl p-8 shadow-lg">
                        <h2 class="text-2xl font-semibold mb-4">Tech Stack</h2>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tech in offer.tech_stack"
                                :key="tech"
                                class="badge badge-secondary badge-lg"
                            >
                                {{ tech }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Apply Card -->
                    <div class="bg-base-100 rounded-xl p-6 shadow-lg sticky top-6">
                        <div class="space-y-4">
                            <div class="p-4 bg-base-200 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Salary Range</h3>
                                <p v-if="offer.salary_min && offer.salary_max" class="text-2xl font-bold text-success">
                                    {{ formatSalary(offer.salary_min) }} - {{ formatSalary(offer.salary_max) }} PLN
                                </p>
                                <p v-else class="text-lg text-error">
                                    Salary not specified
                                </p>
                            </div>

                            <button v-if="!application" @click="handleApply" class="btn btn-primary w-full">
                                {{ !$page.props.auth.user ? 'Login First' : 'Apply Now' }}
                            </button>
                            <div v-else>
                                You applied for this offer {{ application.created_at }}
                            </div>
                        </div>

                        <!-- Job Details -->
                        <div class="divider"></div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">Job Details</h3>

                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Experience</span>
                                    <span class="font-medium">
                                        {{ offer.experience_names.join(', ') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Contract Type</span>
                                    <span class="font-medium">
                                        {{ offer.contract_names.join(', ') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Specialization</span>
                                    <span class="font-medium">
                                        {{ offer.specialization_names.join(', ') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Work Type</span>
                                    <span class="font-medium">
                                        {{ offer.work_type_names.join(', ') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Share Section -->
                        <div class="divider"></div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">Share this offer</h3>
                            <div class="flex gap-2">
                                <button class="btn btn-circle btn-outline" @click="copyLink">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <a
                                    target="_blank"
                                    class="btn btn-circle btn-outline"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a
                                    target="_blank"
                                    class="btn btn-circle btn-outline"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Offers -->
                    <div v-if="similarOffers && similarOffers.length" class="bg-base-100 rounded-xl p-6 shadow-lg">
                        <h3 class="text-lg font-semibold mb-4">Similar Offers</h3>
                        <div class="space-y-4">
                            <Link
                                v-for="offer in similarOffers"
                                :key="offer.id"
                                :href="route('offers.show', offer.slug)"
                                class="block p-4 rounded-lg hover:bg-base-200 transition-colors"
                            >
                                <h4 class="font-medium">{{ offer.title }}</h4>
                                <p class="text-sm text-gray-500">{{ offer.company_name }}</p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <DialogModal :show="showModal">
                <template #title>
                    Apply for this Offer?
                </template>

                <template #content>
                    <label for="description">Description</label>
                    <textarea id="description" v-model="form.description" cols="40" rows="3" class="textarea w-full max-w-md"></textarea>
                    <div v-if="!$page.props.auth.user.cv">You need to add CV to your profile first</div>
                    <div v-else>
                        <a :href="'/storage/' + $page.props.auth.user.cv" target="_blank">
                            <label for="cv">Curriculum Vitae</label>
                            <input type="text" :value="$page.props.auth.user.cv" class="cursor-pointer input w-full max-w-md" readonly/>
                        </a>
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="showModal = false">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton class="ml-2" :disabled="!$page.props.auth.user.cv" @click="submit">
                        Apply
                    </PrimaryButton>
                </template>
            </DialogModal>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import {Link, router, useForm} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {useFormatters} from "@/Composables/useFormatters";
import {Offer} from "@/Types/offers";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";

const { formatSalary, formatDate } = useFormatters();

interface Props {
    offer: Offer;
    application: {
        type: [Object, null],
        required: true,
    },
    similarOffers?: Offer[];
}

const props = defineProps<Props>();

const copyLink = () => {
    navigator.clipboard.writeText(window.location.href);
};

const showModal = ref(false);
const form = useForm({
    description: '',
})

const handleApply = () => {
    showModal.value = true;
}

const submit = () => {
    form.post(route('offers.apply', props.offer.slug), {
        preserveState: false,
        onSuccess: () => showModal.value = false,
    })
}
</script>
