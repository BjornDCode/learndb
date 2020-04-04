<template>
    <div class="border-t border-gray-300">
        <div
            class="px-4 py-12 md:px-12 flex flex-col-reverse lg:flex-row lg:max-w-5xl"
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
