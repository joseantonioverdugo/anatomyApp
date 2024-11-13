<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
	<Head title="App" />
	
	<AuthenticatedLayout>
		<template #header>
            Home
		</template>
		
		<div class="p-4 bg-white rounded-lg shadow-xs">
            Welcome to your app
		</div>
	</AuthenticatedLayout>
</template>
