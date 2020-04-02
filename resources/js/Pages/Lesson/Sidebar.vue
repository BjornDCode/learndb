<template>
    <aside class="bg-gray-100 md:sticky md:top-0 md:h-screen md:w-64 lg:w-80">
        <button
            type="button"
            class="flex items-center w-full text-left px-4 py-2 focus:outline-none focus:shadow-outline md:hidden"
            @click="toggle"
        >
            <Icon
                :name="open ? 'cheveron-down' : 'cheveron-right'"
                class="w-4 h-4 mr-2 text-gray-700"
            />
            <span class="text-lg text-gray-800 font-display font-medium">
                Content
            </span>
        </button>

        <ul :class="{ hidden: !open }" class="md:block">
            <li v-for="item in items">
                <SidebarItem
                    :href="
                        route('lesson.show', {
                            series: series.slug,
                            lesson: item.slug,
                        })
                    "
                    :title="item.title"
                    :type="item.content.type"
                    :duration="item.content.duration"
                    :current="isCurrent(item)"
                    status="none"
                />
            </li>
        </ul>
    </aside>
</template>

<script>
    import Icon from '@/Components/Icon'
    import SidebarItem from '@/Pages/Lesson/SidebarItem'

    export default {
        components: {
            Icon,
            SidebarItem,
        },

        props: {
            items: {
                type: Array,
                default: () => [],
            },
            series: {
                type: Object,
                default: () => [],
            },
            lesson: {
                type: Object,
                default: () => [],
            },
        },

        data() {
            return {
                open: false,
            }
        },

        methods: {
            toggle() {
                this.open = !this.open
            },

            isCurrent(item) {
                return (
                    window.location.href ===
                    route('lesson.show', {
                        series: this.series.slug,
                        lesson: item.slug,
                    }).url()
                )
            },
        },
    }
</script>
