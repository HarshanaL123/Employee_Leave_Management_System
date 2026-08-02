<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    start_date: '',
    end_date: '',
    reason: '',
});

const submit = () => {
    form.post(route('leave-requests.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Request Leave" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Request Employee Leave 
                </h2> 
                <Link 
                    :href="route('leave-requests.index')"
                    class="rounded-md bg-gray-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                    Back to List
                </Link>  
            </div>
        </template> 

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Start Date -->
                         <div>
                            <InputLabel for="start_date" value="Start Date" />
                            <input 
                                id="start_date"
                                type="date"
                                v-model="form.start_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" />
                                <InputError :message="form.errors.start_date" class="mt-2" />
                         </div> 
                        <!--End Date--> 
                        <div>
                            <InputLabel for="end_date" value="End Date" />
                            <input
                                id="end_date"
                                type="date"
                                v-model="form.end_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus-ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" />
                                <InputError :message="form.errors.end_date" class="mt-2" />
                        </div> 
                        <!--Reason-->
                        <div>
                            <InputLabel for="reason" value="Reason for Leave" />
                            <textarea
                                id="reason"
                                rows="4"
                                v-model="form.reason"
                                placeholder="Please describe the reason for your leave request..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" >
                            </textarea> 
                            <InputError :message="form.errors.reason" class="mt-2" />
                        </div>
                        <!--Submit Button-->
                        <div class="flex items-center justify-end">
                            <PrimaryButton :disabled="form.processing">
                                Submit Request 
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>