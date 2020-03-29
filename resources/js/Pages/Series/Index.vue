<template>
    <App>
        <div class="bg-indigo-100 px-4 py-16 md:py-20 lg:py-32">
            <div class="text-center md:w-3/4 md:mx-auto lg:max-w-screen-sm">
                <h1 class="font-display text-gray-900 text-4xl font-bold leading-none mb-4 md:text-5xl">Start learning now.</h1>
                <p class="text-lg text-blue-900 leading-normal mb-12 lg:text-xl lg:w-3/4 lg:mx-auto">
                    Browse all our series and lessons. We have material for beginners, industry veterans and everyone in between
                </p>
                <form class="relative">
                    <input 
                        type="text" 
                        placeholder="Find topic" 
                        class="block w-full text-sm text-gray-700 rounded-md shadow-md p-4 focus:outline-none focus:shadow-outline"
                    >
                    <button 
                        type="submit"
                        class="absolute right-0 mr-4 transform -translate-y-1/2" 
                        style="top: 50%;" 
                    >
                        <Icon name="search" class="w-4 h-4 text-blue-800" />
                    </button>
                </form>
            </div>
        </div>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Icon from '@/Components/Icon'

    export default {
        components: {
            App,
            Icon,
        }
    }
</script>
