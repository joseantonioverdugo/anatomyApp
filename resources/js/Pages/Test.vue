<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();

const user = props.auth.user;

</script>

<template>
	<Head title="App" />
	<AuthenticatedLayout>
		<div>
			<p>Nombre del Usuario: {{ user.name }}</p>
			<p>Mejor puntuación: {{ user.best_score }}</p>
		</div>
	</AuthenticatedLayout>
</template>
