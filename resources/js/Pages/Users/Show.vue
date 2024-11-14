<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
	users: {
		type: Object
	}
})
</script>

<template>
	<Head title="Users" />
	
	<AuthenticatedLayout>
		<template #header>
			User
		</template>
		
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
				<h1>User Show</h1>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
