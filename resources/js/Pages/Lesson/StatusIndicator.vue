<template>
    <div
        class="flex items-center justify-center w-6 h-6 rounded-full"
        :class="{
            'bg-green-300': is('finished'),
            'bg-blue-300': is('started'),
            'bg-red-300': is('wrong'),
            'bg-gray-300': is('none'),
        }"
    >
        <Icon
            v-if="is('finished')"
            name="checkmark"
            class="w-3 h-3 text-white"
        />
        <Icon v-if="is('started')" name="pause" class="w-3 h-3 text-white" />
        <Icon v-if="is('wrong')" name="close" class="w-3 h-3 text-white" />
    </div>
</template>

<script>
    import Icon from '@/Components/Icon'

    export default {
        components: {
            Icon,
        },

        props: {
            status: {
                type: String,
                default: 'none',
                validator: value =>
                    ['finished', 'wrong', 'started', 'none'].includes(value),
            },
        },

        methods: {
            is(status) {
                return this.status === status
            },
        },
    }
</script>
