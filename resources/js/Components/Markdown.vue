<template>
    <div v-html="output" />
</template>

<script>
    import marked from 'marked'

    export default {
        props: {
            content: {
                type: String,
                required: true,
            },
        },

        computed: {
            output() {
                return marked(this.content)
            },
        },
    }
</script>

<style scoped>
    div >>> h1,
    div >>> h2,
    div >>> h3,
    div >>> h4,
    div >>> h5,
    div >>> h6 {
        @apply font-display font-medium text-gray-900 leading-tight mb-4;
    }

    div >>> p ~ h1,
    div >>> p ~ h2,
    div >>> p ~ h3,
    div >>> p ~ h4,
    div >>> p ~ h5,
    div >>> p ~ h6 {
        @apply mt-8;
    }

    div >>> h1 {
        @apply text-4xl;
    }

    div >>> h2 {
        @apply text-3xl;
    }

    div >>> h3 {
        @apply text-2xl;
    }

    div >>> h4 {
        @apply text-xl;
    }

    div >>> h5 {
        @apply text-lg;
    }

    div >>> p,
    div >>> li {
        @apply text-gray-700 leading-relaxed;
    }

    div >>> p,
    div >>> ul,
    div >>> ol,
    div >>> blockquote,
    div >>> pre {
        @apply mb-4;
    }

    div >>> ol,
    div >>> ul {
        @apply pl-4;
    }

    div >>> ul {
        @apply list-disc;
    }

    div >>> ol {
        @apply list-decimal;
    }

    div >>> a {
        @apply text-gray-900 underline;
    }

    div >>> pre {
        @apply p-8 bg-gray-100 rounded-md overflow-x-scroll;
    }
</style>
