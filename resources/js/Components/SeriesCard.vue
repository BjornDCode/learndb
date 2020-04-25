<template>
    <div
        class="shadow-md rounded-md overflow-hidden h-full flex flex-col transition transition-shadow duration-100 hover:shadow-lg"
    >
        <img :src="series.image" :alt="series.title" class="block w-full" />
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <inertia-link
                    :href="route('series.show', { series: series.id })"
                >
                    <h3
                        class="font-display text-2xl font-medium text-gray-900 mb-2 hover:underline"
                    >
                        {{ series.title }}
                    </h3>
                </inertia-link>
                <p class="text-gray-600 leading-relaxed">
                    {{ series.description }}
                </p>
            </div>

            <footer class="mt-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <Icon
                            name="book-reference"
                            class="text-gray-500 w-3 h-3 mr-2"
                        />
                        <span class="text-sm text-gray-600">
                            5 lessons
                        </span>
                    </div>
                    <div class="flex items-center">
                        <Icon name="time" class="text-gray-500 w-3 h-3 mr-2" />
                        <span class="text-sm text-gray-600">
                            24 min
                        </span>
                    </div>
                </div>

                <inertia-link
                    :href="route('series.show', { series: series.id })"
                    class="block shadow text-xs font-display font-bold text-blue-100 bg-blue-800 rounded px-6 py-2 transition transition-transform duration-100 transform hover:scale-105 hover:shadow-md"
                >
                    {{ series.started ? 'Continue' : 'Start' }}
                </inertia-link>
            </footer>
        </div>
    </div>
</template>

<script>
    import Icon from '@/components/Icon'

    export default {
        components: {
            Icon,
        },

        props: {
            series: {
                type: Object,
                default: () => ({}),
            },
        },
    }
</script>
