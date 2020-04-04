<template>
    <div class="border-t border-gray-300">
        <div
            class="px-4 py-12 md:px-12 flex flex-col-reverse lg:flex-row lg:max-w-6xl"
        >
            <div class="lg:w-3/4">
                <Headline :level="3">
                    Comments
                </Headline>
            </div>
            <div class="lg:w-1/4 lg:ml-8">
                <Headline :level="3">
                    Resources
                </Headline>

                <ul>
                    <li v-for="resource in resources" :key="resource.url">
                        <a
                            target="_blank"
                            :href="resource.url"
                            class="block text-lg text-gray-800 underline mb-2"
                        >
                            {{ resource.title }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Headline from '@/Components/Headline'

    export default {
        components: {
            Headline,
        },

        props: {
            resources: {
                type: Array,
                default: () => [],
            },
        },
    }
</script>
