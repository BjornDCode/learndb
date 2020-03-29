<template>
    <div class="relative">
        <form class="relative">
            <input 
                type="text" 
                placeholder="Find topic" 
                v-model="form.query"
                class="block w-full text-sm text-gray-700 rounded-md shadow-md p-4 focus:outline-none focus:shadow-outline"
            >
            <div 
                class="absolute right-0 mr-4 transform -translate-y-1/2"
                style="top: 50%;" 
            >
                <Icon name="search" class="w-4 h-4 text-blue-800" />
            </div>
        </form>

        <ul class="absolute bg-white w-full rounded-md shadow-md mt-2" style="top: 100%;">
            <li 
                v-for="result in results" 
                :key="result.title"
                class="text-left" 
            >
                <inertia-link 
                    :href="result.url"
                    class="flex items-center w-full px-4 py-3 hover:bg-gray-100 focus:outline-none focus:shadow-outline"
                >
                    <Icon :name="getResultIcon(result.type)" class="w-4 h-4 mr-4 text-gray-600" />
                    <span class="text-gray-900">
                        {{ result.title }}
                    </span>
                </inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import Icon from '@/Components/Icon'
    
    export default {
        components: {
            Icon,
        },

        data() {
            return {
                form: {
                    query: ''
                },
                results: [
                    { title: 'My first series', url: 'https://google.com', 'type': 'series' },
                    { title: 'My second series', url: 'https://google.com', 'type': 'series' },
                ]
            }
        },

        methods: {
            getResultIcon(type) {
                return 'queue'
            }
        }
    }
</script>

