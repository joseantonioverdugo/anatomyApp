<template>
    <Head :title="'FlashCards'" />
    <AuthenticatedLayout>
        <template #header>
            FlashCards
            <DarkButton @click="openModalForm()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </DarkButton>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">

            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Título</th>
                                <th class="px-4 py-3">Categoría</th>
                                <th class="px-4 py-3">Subcategoría</th>
                                <th class="px-4 py-3">Imagen</th>
                                <th class="px-4 py-3">Ver</th>
                                <th class="px-4 py-3">Editar</th>
                                <th class="px-4 py-3">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="flashcard in flashcards.data" :key="flashcard.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ flashcard.title }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ flashcard.category.name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ flashcard.subcategory.name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <img :src="flashcard.url" alt="Imagen" class="w-16 h-16 object-cover" v-if="flashcard.url">
                                    <span v-else>No hay imagen</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <NavLink :href="route('flashcards.show', flashcard.id)">
                                        <SecondaryButton>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </SecondaryButton>
                                    </NavLink>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <WarningButton @click="openModalForm(1, flashcard)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </WarningButton>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <DangerButton @click="openModalDelete(flashcard)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </DangerButton>
                                </td>
                            </tr>
                            <tr v-if="flashcards.data.length === 0">
                                <td colspan="7" class="px-4 py-3 text-sm text-center text-gray-500">
                                    No hay flashcards disponibles.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="flashcards.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="showModalForm" @close="closeModalForm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
            <div class="mt-6 mb-6 space-y-6 max-w-xl">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Título
                    </span>
                    <input
                        v-model="form.title"
                        type="text"
                        class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    >
                </label>
                <InputError :message="form.errors.title" />

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Categoría
                    </span>
                    <select
                        v-model="form.category_id"
                        class="block w-full mt-1 text-sm dark:text-gray-30 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    >
                        <option value="" disabled>Selecciona una categoría</option>
                        <option v-for="category in categories.data" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </label>
                <InputError :message="form.errors.category_id" />

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Subcategoría
                    </span>
                    <select
                        v-model="form.subcategory_id"
                        class="block w-full mt-1 text-sm dark:text-gray-30 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    >
                        <option value="" disabled>Selecciona una subcategoría</option>
                        <option v-for="subcategory in subcategories.data" :key="subcategory.id" :value="subcategory.id">
                            {{ subcategory.name }}
                        </option>
                    </select>
                </label>
                <InputError :message="form.errors.subcategory_id" />

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Imagen
                    </span>
                    <input
                        @change="handleFileUpload"
                        type="file"
                        accept=".jpg, .jpeg, .png"
                        class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    >
                </label>
                <InputError :message="form.errors.image" />

                <PrimaryButton @click="storeFlashcard">Guardar</PrimaryButton>
            </div>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
        </div>
    </Modal>

    <Modal :show="showModal" @close="closeModalDelete">
        <div class="p-6">
            <p class="text-2xl text-gray-500">
                ¿Estás seguro de que deseas eliminar a
                <span><b>{{ form.title }}</b></span>?
            </p>
            <PrimaryButton @click="deleteFlashcard">Eliminar</PrimaryButton>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalDelete">Cancelar</SecondaryButton>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import NavLink from '@/Components/NavLink.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    flashcards: Object,
    categories: Object,
    subcategories: Object,
});

const showModal = ref(false);
const showModalForm = ref(false);
const title = ref('');

const form = useForm({
    id: null,
    title: '',
    category_id: null,
    subcategory_id: null,
    image: null,
});

const openModalForm = (option, flashcard) => {
    showModalForm.value = true;
    if (option === 1 && flashcard) {
		console.log(flashcard); 
        title.value = 'Editar FlashCard';
        form.id = flashcard.id;
        form.title = flashcard.title;
        form.category_id = flashcard.category.id;
        form.subcategory_id = flashcard.subcategory.id;
        form.image = flashcard.image;
    } else {
        title.value = 'Crear FlashCard';
        form.reset();
        form.id = null;
    }
}

const storeFlashcard = () => {
    if (form.id) {
        form.post(route('flashcards.update', form.id), {
            forceFormData: true,
            onSuccess: () => {
                closeModalForm();
                form.reset();
            },
            onError: (errors) => {
                console.log('Errores:', errors);
            }
        });
    } else {
        form.post(route('flashcards.store'), {
            onSuccess: () => {
                closeModalForm();
                form.reset();
            },
            onError: (errors) => {
                console.log('Errores:', errors);
            }
        });
    }
}

const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
    form.errors.title = null;
    form.errors.category = null;
    form.errors.subcategory = null;
    form.errors.image = null;
}

const openModalDelete = (flashcard) => {
    form.id = flashcard.id;
    form.title = flashcard.title;
    showModal.value = true;
};

const closeModalDelete = () => {
    showModal.value = false;
    form.reset();
};

const deleteFlashcard = () => {
    form.delete(route('flashcards.destroy', form.id));
    closeModalDelete();
}

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    const allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

    if (file && allowedTypes.includes(file.type)) {
        form.image = file;
    } else {
        alert('Por favor, selecciona una imagen válida (JPG, JPEG, PNG).');
        event.target.value = null;
    }
};
</script>