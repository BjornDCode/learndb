<template>
    <inertia-link
        :href="href"
        class="flex items-center px-4 py-8 border-t border-gray-300 md:first:border-t-0 md:hover:bg-gray-200 md:hover:shadow"
        :class="{ 'bg-gray-200 shadow-md': current }"
    >
        <div class="flex-1">
            <span
                class="text-xl font-display font-medium"
                :class="{
                    'hover:text-gray-900': current,
                    'text-gray-700': !current,
                }"
            >
                {{ title }}
            </span>
            <div class="flex items-center">
                <div class="flex items-center mr-4">
                    <Icon :name="icon" class="w-4 h-4 text-gray-500 mr-2" />
                    <span class="text-sm text-gray-600">{{ type }}</span>
                </div>
                <div class="flex items-center">
                    <Icon name="time" class="w-4 h-4 text-gray-500 mr-2" />
                    <span class="text-sm text-gray-600">{{ duration }}</span>
                </div>
            </div>
        </div>
        <div>
            <StatusIndicator :status="status" />
        </div>
    </inertia-link>
</template>

<script>
    import Icon from '@/Components/Icon'
    import StatusIndicator from '@/Pages/Lesson/StatusIndicator'

    export default {
        components: {
            Icon,
            StatusIndicator,
        },

        props: {
            href: {
                type: String,
                required: true,
            },

            current: {
                type: Boolean,
                default: false,
            },

            title: {
                type: String,
                required: true,
            },

            type: {
                type: String,
                required: true,
                validator: value =>
                    ['Video', 'Quiz', 'Article'].includes(value),
            },

            duration: {
                type: String,
                required: true,
            },

            status: {
                type: String,
                default: 'none',
                validator: value =>
                    ['finished', 'started', 'none'].includes(value),
            },
        },

        computed: {
            icon() {
                if (this.type === 'Video') {
                    return 'video-camera'
                }

                if (this.type == 'Quiz') {
                    return 'badge'
                }

                return 'document'
            },
        },
    }
</script>
