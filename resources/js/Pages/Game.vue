<template>
	<Head title="App" />
	<AuthenticatedLayout>
		<div v-if="!newGame" class="flex flex-col justify-center items-center h-screen">
			<PrimaryButton @click="startNewGame">Nuevo Juego</PrimaryButton>
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
						'flex justify-center items-center border border-gray-300 p-2 rounded-lg cursor-pointer',
						selectedAnswer === option ? 'bg-amber-300' : '', 
						isCorrect === false && selectedAnswer === option ? 'bg-red-300' : '', 
						isCorrect === true && selectedAnswer === option ? 'bg-green-300' : '', 
						isCorrect === false && correctAnswer === option ? 'bg-green-300' : '']"
					>
						<p>{{ option.option }}</p>
					</div>
				</div>
			</div>
			<div v-if="isCorrect === false" class="mt-4 flex flex-col justify-center items-center">
				<p>Puntuación obtenida: {{ score }}</p>
				<p>Mejor puntuación: {{ user.best_score }}</p>
				<PrimaryButton @click="resetGame">Volver a jugar</PrimaryButton>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
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
const score = ref(0);
const selectedFlashcard = ref([]);
const selectedOptions = ref([]);
const correctAnswer = ref({});
const selectedAnswer = ref(null);
const isCorrect = ref(null);
const answeredCorrectly = ref([])

const startNewGame = () => {
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
	console.log('selectedOptions',selectedOptions.value);
	getCorrectAnswer();
};

const getCorrectAnswer = () => {
    const availableOptions = selectedOptions.value.filter(option => 
        !answeredCorrectly.value.some(answer => 
            answer.optionNumber === option.id
        )
    );
    
    if (availableOptions.length > 0) {
        correctAnswer.value = availableOptions[Math.floor(Math.random() * availableOptions.length)];
    } else {
        answeredCorrectly.value = [];
        correctAnswer.value = selectedOptions.value[Math.floor(Math.random() * selectedOptions.value.length)];
    }
};

const handleAnswer = (option) => {
  if (selectedAnswer.value === option) {
    if (selectedAnswer.value === correctAnswer.value) {
      isCorrect.value = true;
      score.value += 1;
      answeredCorrectly.value.push({
        flashcardId: selectedFlashcard.value.id,
        optionNumber: correctAnswer.value.id
      });
      setTimeout(() => {
        resetNextQuestion();
        startNewGame();
      }, 1000);
    } else {
      isCorrect.value = false;
      if (score.value >= props.user.best_score) {
      	updateBestScore();
      }
    }
  } else {
    selectedAnswer.value = option;
  }
};
const resetNextQuestion = () => {
	selectedFlashcard.value = [];
	selectedOptions.value = [];
	correctAnswer.value = {};
	selectedAnswer.value = null;
	isCorrect.value = null;
}

const resetGame = () => {
    score.value = 0;
    selectedFlashcard.value = [];
    selectedOptions.value = [];
    correctAnswer.value = {};
    selectedAnswer.value = null;
    isCorrect.value = null;
    
    startNewGame();
}

const updateBestScore = async () => {
  try {
    const response = await axios.patch(route('best-score', props.user.id), {
      score: score.value
    });
    
    if (response.status === 200) {
      props.user.best_score = score.value;
    }
  } catch (error) {
    console.error('Error updating best score:', error);
  }
}

</script>
