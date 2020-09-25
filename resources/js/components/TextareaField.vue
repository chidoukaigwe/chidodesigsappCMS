<template>
    <div>
        <label :for="body" class="mt-3">{{label}}</label>
        <div class="form-group" id="editor">
            <textarea class="form-control" :id="body"  v-model="value" @textarea="updateTextarea()"></textarea>
        </div>
        <div>
            <p class="small text-danger" v-text="errorMessage(body)">Error</p>
        </div>

    </div>

</template>

<script>
export default {

    name: "TextareaField",

    props: [
        'body',
        'label',
        'placeholder',
        'errors'
    ],

    data: function () {
        return {
            value: '',
        }
    },

    methods: {

        updateTextarea: function () {
            this.emit('update:textarea', this.value)
        },

        errorMessage:  function (field) {
            if (this.errors && this.errors[field] && this.errors[field].length > 0){
                return this.errors[field][0];
            }
        }

    }

}
</script>

<style scoped>

</style>

