<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="CeylonByte - Employee Leave Management System" />

    <div class="relative min-h-screen bg-gray-900 text-white selection:bg-indigo-500 selection:text-white">
        <!-- Subtle Glow Gradient Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative flex min-h-screen flex-col justify-between max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Top Navigation / Authentication Header -->
            <header class="flex items-center justify-between py-6 border-b border-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold text-xl shadow-lg shadow-indigo-500/30">
                        C
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">
                        CeylonByte
                    </span>
                </div>

                <nav v-if="canLogin" class="flex items-center space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-sm font-medium text-gray-300 hover:text-white transition"
                        >
                            Log in
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </header>

            <!-- Main Hero Content -->
            <main class="flex flex-col items-center justify-center text-center my-auto py-20">
                <div class="inline-flex items-center rounded-full bg-indigo-500/10 px-4 py-1.5 text-sm font-medium text-indigo-400 ring-1 ring-inset ring-indigo-500/20 mb-6">
                    Enterprise Portal • CeylonByte Teams
                </div>

                <h1 class="max-w-4xl text-4xl font-extrabold tracking-tight text-white sm:text-6xl">
                    Employee Leave Management System
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-400">
                    A modern, streamlined leave request and approval portal built for CeylonByte. 
                    Experience instant role-based workflows, automated status tracking, and effortless collaboration.
                </p>
            </main>

            <!-- Footer -->
            <footer class="py-6 border-t border-gray-800 text-center text-xs text-gray-500">
                © {{ new Date().getFullYear() }} CeylonByte. Built with Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }}).
            </footer>
        </div>
    </div>
</template>
