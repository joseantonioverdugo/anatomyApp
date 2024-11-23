<template>
    <Head title="Flashcard" />
    <AuthenticatedLayout>
		<template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ flashcard.title }}
                <NavLink :href="route('flashcards.index')">
                    <DarkButton>
                        Atras
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Título: <span class="text-gray-900 font-semibold">{{ flashcard.data.title }}</span></p>
                <p>Categoría: <span class="text-gray-900 font-semibold">{{ flashcard.data.category.name }}</span></p>
                <p>Subcategoría: <span class="text-gray-900 font-semibold">{{ flashcard.data.subcategory.name }}</span></p>
                <p>Imagen:</p>
                <img :src="flashcard.data.url" alt="Imagen" class="mt-4 w-64 h-64 object-cover" v-if="flashcard.data.url">
                                    <span v-else>No hay imagen</span>
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
    flashcard: Object,
});
</script>