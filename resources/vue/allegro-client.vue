<template>
<div>
    <p>Translation key <code>ALLEGRO_CLIENT_EXAMPLE</code> from <code>allegro-client/resources/lang/**/js.php</code>: {{$lang.ALLEGRO_CLIENT_EXAMPLE}}</p>
    <button class="form-builder__send btn" @click="testDebug">Test console log for debug</button>
    <p>From config JS file: {{this.example_data}}</p>
    <p>Example function: {{this.exampleFromFunction}}</p>
    <p>
        <button class="form-builder__send btn" @click="testLoading">Test loading</button>
        <span v-if="isLoading">is loading...</span>
    </p>
</div>
</template>

<script>
import allegroClientMixin from '../js/mixins/allegro-client'
import {consoleDebug} from '../js/modules/helpers'

let _uniqSectionId = 0;

export default {

    name: 'allegro-client',

    mixins: [ allegroClientMixin ],

    props: {
        name: {
            type: String,
            default() {
                return `allegro-client-${ _uniqSectionId++ }`
            }
        },

        default: Object,

        storeData: String,
    },


    computed: {
        allegroClient() {
            return this.$store.state.allegroClient[this.name]
        },

        isLoading() {
            return this.allegro-client && this.allegro-client.isLoading
        },
    },

    created() {

        let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {})

        this.$store.commit('allegro-client/create', {
            name: this.name,
            data
        })
    },

    mounted() {

    },

    methods: {
        testDebug(){
            consoleDebug('message', ['data1'], ['data2'])
        },

        testLoading(){
            if ( this.isLoading) return;

            AWEMA.emit(`allegro-client::${this.name}:before-test-loading`)

            this.$store.dispatch('allegro-client/testLoading', {
                name: this.name
            }).then( data => {
                consoleDebug('data', data);
                this.$emit('success', data.data)
                this.$store.$set(this.name, this.$get(data, 'data', {}))
            })
        }
    },


    beforeDestroy() {

    }
}
</script>
