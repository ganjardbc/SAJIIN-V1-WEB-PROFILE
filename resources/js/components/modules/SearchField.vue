<template>
    <div id="App" class="mobile-hidden">
        <el-input 
            :placeholder="placeholder ? placeholder : 'Search..'"
            v-model="search" 
            class="subject-input-with-select"
            @input="onSearch"
            clearable>
            <el-button 
                slot="append" 
                icon="el-icon-search"
                @click="onSearch"></el-button>
        </el-input>
    </div>
</template>
<script>
export default {
    name: 'App',
    data () {
        return {
            search: ''
        }
    },
    mounted () {
        this.search = this.value ? this.value : ''
    },
    props: {
        disableBorder: {
            type: Boolean,
            required: false
        },
        value: {
            type: String,
            required: false
        },
        placeholder: {
            type: String,
            required: false
        },
    },
    methods: {
        onChange () {
            this.$emit('onSearch', this.search)
        },
        onSearch () {
            this.$emit('onSearch', this.search)
        }
    },
    watch: {
        maximumValue: function (props) {
            if (props) {
                this.search = parseInt(props)
            }
        }
    }
}
</script>