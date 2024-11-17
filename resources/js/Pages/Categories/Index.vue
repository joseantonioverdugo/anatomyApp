<template>
    <Head :title="'FlashCards'" />
    <AuthenticatedLayout>
        <template #header>
            Categorías
            <DarkButton @click="openModalForm()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </DarkButton>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
			<!-- <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
				<div class="flex justify-center items-center w-12 bg-blue-500">
					<svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
					</svg>
				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-blue-500">Info</span>
						<p class="text-sm text-gray-600">Sample table page</p>
					</div>
				</div>
			</div> -->
			
			<div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
				<div class="overflow-x-auto w-full">
					<table class="w-full whitespace-no-wrap">
						<thead>
							<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
								<th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Detalle</th>
								<th class="px-4 py-3">Editar</th>
								<th class="px-4 py-3">Eliminar</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y">
							<tr v-for="category in categories.data" :key="category.id" class="text-gray-700">
								<td class="px-4 py-3 text-sm">
									{{ category.name }}
								</td>
								<td class="px-4 py-3 text-sm">
									<NavLink :href="route('categories.show', category.id)">
										<SecondaryButton>
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
												<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
											</svg>
										</SecondaryButton>
									</NavLink>
								</td>
								<td class="px-4 py-3 text-sm">
									<WarningButton @click="openModalForm(1, category)">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
										</svg>
									</WarningButton>
                                </td>
								<td class="px-4 py-3 text-sm">
                                    <DangerButton @click="openModalDelete(category)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </DangerButton>
                                </td>
							</tr>
                            <tr v-if="categories.data.length === 0">
                                <td colspan="4" class="px-4 py-3 text-sm 
                                                          text-center text-gray-500">
                                    No hay categorías disponibles.
                                </td>
                            </tr>
						</tbody>
					</table>
				</div>
				<div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="categories.links" />
				</div>
			</div>
		</div>
    </AuthenticatedLayout>
    <Modal :show=showModalForm @close=closeModalForm>
		<div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
            <div class="mt-6 mb-6 space-y-6 max-w-xl">
                <label class="block text-sm">
                	<span class="text-gray-700 dark:text-gray-400">
						Nombre
					</span>
                	<input v-model="form.name" type="text" class="block w-full mt-1 text-smfocus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
              	</label>
				<InputError :message="form.errors.name" />
                <PrimaryButton @click="storeCategory">Save</PrimaryButton>
            </div>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
        </div>
	</Modal>
	<Modal :show="showModal" @close="closeModalDelete">
		<div class="p-6">
			<p class="text-2xtext-gray-500">
				¿Estás seguro de que deseas eliminar
				<span ><b>{{ form.name }}</b></span>?</p>
				<PrimaryButton @click="deleteCategory">Delete</PrimaryButton>
		</div>
		<div class="m-6 flex justify-end">
			<SecondaryButton @click="closeModalDelete">Cancel</SecondaryButton>
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
    categories: Object
})

const form = useForm({
    id: null,
    name: ''
})
const title = ref('')
const showModalForm = ref(false)
const showModal = ref(false)

const openModalForm = (type, category) => {
    showModalForm.value = true
    if(type === 1) {
        title.value = 'Editar Categoría'
        form.id = category.id
        form.name = category.name
    } else {
        title.value = 'Crear Categoría'
        form.id = null
        form.name = ''
    }
}

const closeModalForm = () => {
    showModalForm.value = false
    form.reset()
}

const storeCategory = () => {
    if(form.id){
        form.put(route('categories.update', form.id))
		closeModalForm()
    }else{
        form.post(route('categories.store'))
		closeModalForm()
    }
}

const openModalDelete = (category) => {
	showModal.value = true;
	title.value = 'Eliminar Categoría';
	form.id = category.id;
	form.name = category.name;
}

const closeModalDelete = () => {
	showModal.value = false;
	form.reset()
}

const deleteCategory = () => {
	form.delete(route('categories.destroy', form.id))
	closeModalDelete()
}
</script>