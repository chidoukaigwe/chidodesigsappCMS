<template>
     <div class="form-group mb-3">
            <label :for="title">{{label}}</label>
            <input type="text" :id="title" class="form-control" :placeholder="placeholder" v-model="value" @input="updateField()">

            <p class="small text-danger" v-text="errorMessage(title)"></p>
     </div>
</template>

<script>
export default {
    name: "InputField",

    props: [
        'title',
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
        updateField: function () {
            this.$emit('update:field', this.value)
        },

        errorMessage: function (field) {
            if (this.errors && this.errors[field] && this.errors[field].length > 0){
                return this.errors[field][0];
            }
        }

    }
}
</script>

<style scoped>

</style>
