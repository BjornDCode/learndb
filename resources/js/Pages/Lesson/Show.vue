<template>
    <App>
        <div class="md:flex">
            <aside class="bg-gray-100 md:sticky md:top-0 md:h-screen">
                <button
                    type="button"
                    class="flex items-center w-full text-left px-4 py-2 focus:outline-none focus:shadow-outline"
                    @click="toggleSidebar"
                >
                    <Icon
                        :name="sidebarOpen ? 'cheveron-down' : 'cheveron-right'"
                        class="w-4 h-4 mr-2 text-gray-700"
                    />
                    <span
                        class="text-lg text-gray-800 font-display font-medium"
                    >
                        Content
                    </span>
                </button>

                <ul v-if="sidebarOpen">
                    <li>
                        <inertia-link href="#">
                            <div>
                                <span>What is a database?</span>
                                <div>
                                    <div>
                                        <span>Video</span>
                                    </div>
                                    <div>
                                        <span>1 min</span>
                                    </div>
                                </div>
                            </div>
                        </inertia-link>
                    </li>
                </ul>
            </aside>

            <main>
                // Content
            </main>
        </div>
    </App>
</template>

<script>
    import App from '@/Layouts/App'
    import Icon from '@/Components/Icon'

    export default {
        components: {
            App,
            Icon,
        },

        data() {
            return {
                sidebarOpen: false,
            }
        },

        methods: {
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen
            },
        },
    }
</script>
