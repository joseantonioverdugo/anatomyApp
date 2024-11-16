<template>
    <Head title="Flashcard" />
    <AuthenticatedLayout>
		<template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ flashcard.name }}
                <NavLink :href="route('users.index')">
                    <DarkButton>
                        Atras
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Título: <span class="text-gray-900 font-semibold">{{ flashcard.title }}</span></p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    user: Object,
});
</script>