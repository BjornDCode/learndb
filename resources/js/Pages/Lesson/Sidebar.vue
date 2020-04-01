<template>
    <aside class="bg-gray-100 md:sticky md:top-0 md:h-screen">
        <button
            type="button"
            class="flex items-center w-full text-left px-4 py-2 focus:outline-none focus:shadow-outline"
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

        <ul v-if="open">
            <li>
                <SidebarItem
                    href="#"
                    title="What is a database?"
                    type="Video"
                    duration="01:24 min"
                    status="finished"
                />
                <SidebarItem
                    href="#"
                    title="Quiz: What is a database?"
                    type="Quiz"
                    duration="3 questions"
                    status="started"
                    :current="true"
                />
                <SidebarItem
                    href="#"
                    title="What is a table?"
                    type="Article"
                    duration="2 min"
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

        data() {
            return {
                open: true,
            }
        },

        methods: {
            toggle() {
                this.open = !this.open
            },
        },
    }
</script>
