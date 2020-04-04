<script>
    export default {
        props: {
            level: {
                type: Number,
                default: 1,
            },
        },

        computed: {
            element() {
                return `h${this.level}`
            },
        },

        render(createElement) {
            return createElement(this.element, this.$scopedSlots.default())
        },
    }
</script>

<style scoped>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        @apply font-display font-medium text-gray-900 leading-tight mb-4;
    }

    h1 {
        @apply text-4xl;
    }

    h2 {
        @apply text-3xl;
    }

    h3 {
        @apply text-2xl;
    }

    h4 {
        @apply text-xl;
    }

    h5 {
        @apply text-lg;
    }
</style>
