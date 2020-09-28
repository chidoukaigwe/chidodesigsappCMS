<template>
     <div class="form-group mb-3">
            <label :for="name">{{label}}</label>
            <input type="text" :id="name" class="form-control" :placeholder="placeholder" v-model="value" @input="updateField()">

            <p class="small text-danger" v-text="errorMessage(name)"></p>
     </div>
</template>

<script>
export default {
    name: "InputField",

    props: [
        'name',
        'label',
        'placeholder',
        'errors',
        'data'
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

    },

    watch: {
        data: function (val) {
            this.value = val;
        }
    }
}
</script>

<style scoped>

</style>
