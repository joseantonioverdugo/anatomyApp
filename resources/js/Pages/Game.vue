<template>
	<Head title="App" />
	<AuthenticatedLayout>
		<div v-if="!newGame" class="flex flex-col justify-center items-center h-screen">
			<PrimaryButton @click="starNewGame">Nuevo Juego</PrimaryButton>
			<p>Mejor puntuación: {{ user.best_score }}</p>
		</div>
		<div v-else class="flex flex-col justify-center items-center h-screen">
			<div class="flex flex-col justify-center items-center">
				<div class="flex justify-center items-center">
					<img class="h-96 w-96 rounded-lg" :src="selectedFlashcard.url" alt="flashcard">
				</div>
				<div class="mt-4">
					<p>¿Qué opción es la número {{ correctAnswer.option_number }}?</p>
				</div>
				<div class="mt-4 grid grid-cols-2 gap-6">
					<div @click="handleAnswer(option)" v-for="(option) in selectedOptions" :key="option.id" :class="[
						'flex justify-start items-center border border-gray-300 p-2 rounded-lg cursor-pointer',
						selectedAnswer === option ? 'bg-amber-300' : '', 
						isCorrect === false && selectedAnswer === option ? 'bg-red-300' : '', 
						isCorrect === true && selectedAnswer === option ? 'bg-green-300' : '', 
						isCorrect === false && correctAnswer === option ? 'bg-green-300' : '']"
					>
						<p>{{ option.option }}</p>
					</div>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps({
	user: {
		type: Object
	},
	flashcards: {
		type: Object
	}
})
const newGame = ref(false);
const selectedFlashcard = ref([]);
const selectedOptions = ref([]);
const correctAnswer = ref({});
const selectedAnswer = ref(null);
const isCorrect = ref(null);

const starNewGame = () => {
	newGame.value = true;
	selectedFlashcard.value = props.flashcards.data[Math.floor(Math.random() * props.flashcards.data.length)];
	getRandomOptions();
}

const getRandomOptions = () => {
    selectedOptions.value = [];
    const shuffled = selectedFlashcard.value.options
        .map(option => ({ option, sort: Math.random() }))
        .sort((a, b) => a.sort - b.sort)
        .map(({ option }) => option);
    selectedOptions.value = shuffled.slice(0, 4);
	console.log(selectedOptions.value);
	correctAnswer.value = selectedOptions.value[Math.floor(Math.random() * selectedOptions.value.length)];
	console.log(correctAnswer.value);
};

const handleAnswer = (option) => {
	if(selectedAnswer.value === option){
		if(selectedAnswer.value === correctAnswer.value){
			isCorrect.value = true;
		}else{
			isCorrect.value = false;
		}
	}else{
		selectedAnswer.value = option;
	}

}

</script>
