<template>
    <button
        type="button"
        class="flex items-center justify-between w-full shadow text-left rounded-md p-6 mb-4 focus:outline-none"
        :class="{
            'bg-gray-100 cursor-not-allowed': disabled,
            'bg-white active:shadow-xs': !disabled,
        }"
        :disabled="disabled"
    >
        <span>
            {{ option.title }}
        </span>
        <StatusIndicator :status="status" />
    </button>
</template>

<script>
    import StatusIndicator from '@/Pages/Lesson/StatusIndicator'

    export default {
        components: {
            StatusIndicator,
        },

        props: {
            option: {
                type: Object,
                required: true,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
        },

        computed: {
            status() {
                if (!this.option.answered) {
                    return 'none'
                }

                return this.option.correct ? 'finished' : 'wrong'
            },
        },
    }
</script>
