<script>
    export default {
        props: {
            threshold: Number,
            default: 0.1,
        },

        data() {
            return {
                observer: null,
            }
        },

        mounted() {
            this.observer = new IntersectionObserver(this.callback, {
                threshold: this.threshold,
            })

            this.observer.observe(this.$el)
        },

        beforeDestroy() {
            this.observer.disconnect()
        },

        methods: {
            callback(entries) {
                entries.forEach(entry => {
                    this.$emit(entry.isIntersecting ? 'enter' : 'leave')
                })
            },
        },

        render() {
            return this.$scopedSlots.default()
        },
    }
</script>
