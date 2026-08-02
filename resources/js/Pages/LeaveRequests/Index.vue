<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    leaveRequests: Array,
});

const page = usePage();
const isManager = computed(() =>page.props.auth.user.is_manager);

const updateStatus = (id, newStatus) => {
    router.patch(route('leave-requests.update-status', id),{
        status: newStatus,
    });
};
</script>

<template>
    <Head title="Leave Requests" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ isManager ? 'Company Leave Requests (Manager View)' : 'My Leave Requests' }}
                </h2>
                <Link 
                    :href="route('leave-requests.create')"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
                    + Requests Leave 
                </Link>   
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-8">
                <!--Success Flash Message-->
                <div 
                    v-if="$page.props.flash?.success"
                    class="mb-6 rounded-md bg-green-500/10 p-4 text-green-400 border border-green-500/20"
                >
                {{  $page.props.flash.success }}
                </div>
                
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100 dark:border-gray-700">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-gray-200 uppercase text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                <tr>
                                    <th v-if="isManager" class="pb-3 font-semibold">Employee</th>
                                    <th class="pb-3 font-semibold">Start Date</th>
                                    <th class="pb-3 font-semibold">End Date</th>
                                    <th class="pb-3 font-semibold">Reason</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th v-if="isManager" class="pb-3 text-right font-semibold">Actions</th>
                                </tr> 
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="request in leaveRequests" :key="request.id" class="align-middle">
                                    <td v-if="isManager" class="py-4 align-middle text-gray-500 dark:text-gray-400">
                                        {{ request.user?.name }}
                                    </td>
                                    <td class="py-4 align-middle text-gray-500 dark:text-gray-400">
                                        {{ new Date(request.start_date).toLocaleDateString() }}
                                    </td>
                                    <td class="py-4 align-middle text-gray-500 dark:text-gray-400">
                                        {{ new Date(request.end_date).toLocaleDateString() }}
                                    </td>
                                    <td class="py-4 align-middle max-w-xs truncate text-gray-500 dark:text-gray-400">
                                        {{ request.reason }}
                                    </td>
                                    <td class="py-4 align-middle">
                                        <span
                                            class="rounded-full px-2.5 py-1 text-xs font-semibold"
                                            :class="{
                                                'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20': request.status === 'pending',
                                                'bg-green-500/10 text-green-400 border border-green-500/20': request.status === 'approved',
                                                'bg-red-500/10 text-red-400 border border-red-500/20': request.status === 'denied',
                                            }"
                                        >
                                            {{ request.status.toUpperCase() }}
                                        </span>
                                    </td> 
                                    <td v-if="isManager" class="py-4 align-middle text-right space-x-2">
                                        <button 
                                            v-if="request.status === 'pending'"
                                            @click="updateStatus(request.id, 'approved')"
                                            class="rounded bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700 transition"
                                        >
                                            Approve
                                        </button>
                                        <button
                                            v-if="request.status === 'pending'"
                                            @click="updateStatus(request.id, 'denied')"
                                            class="rounded bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700 transition"
                                        >
                                            Deny
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="leaveRequests.length === 0">
                                    <td :colspan="isManager ? 6 : 5" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                        No leave requests found.    
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </AuthenticatedLayout>
</template>