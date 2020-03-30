<template>
    <App>
        <div class="bg-indigo-100 px-4 py-16 md:py-20 lg:py-32">
            <div class="text-center md:w-3/4 md:mx-auto lg:max-w-screen-sm">
                <h1 class="font-display text-gray-900 text-4xl font-bold leading-none mb-4 md:text-5xl">Start learning now.</h1>

                <p class="text-lg text-blue-900 leading-normal mb-12 lg:text-xl lg:w-3/4 lg:mx-auto">
                    Browse all our series and lessons. We have material for beginners, industry veterans and everyone in between
                </p>

                <Search />
            </div>
        </div>

        <section class="px-4 py-8">
            <h2 class="font-display text-3xl text-blue-900 font-bold">All</h2>
        </section>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Search from '@/Components/Search'

    export default {
        components: {
            App,
            Search,
        }
    }
</script>
