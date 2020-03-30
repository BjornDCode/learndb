<template>
    <div class="shadow-md rounded-md overflow-hidden">
        <img 
            :src="series.image" 
            :alt="series.title"
            class="block w-full" 
        >
        <div class="p-6">
            <h3 class="font-display text-2xl font-medium text-gray-900 mb-2">
                {{ series.title }}
            </h3>
            <p class="text-gray-600 leading-relaxed">
                {{ series.description }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            series: {
                type: Object,
                default: () => ({})
            }
        }
    }
</script>
