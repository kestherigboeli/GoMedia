<template>
	<q-form @submit="submitForm">
		<div class="form-group"  v-if="tab === 'register'">
			<q-input class="q-mb-md form-control" outlined v-model="formData.name" type="text" label="Name"></q-input>
			<small class="form-text text-muted">We'll never share your email with anyone else.</small>
		</div>

		<div class="form-group">
			<q-input class="q-mb-md" outlined v-model="formData.email" type="email" label="Email"></q-input>
			<small class="form-text text-muted">We'll never share your email with anyone else.</small>

		</div>

		<div class="form-group">
			<q-input class="q-mb-md" outlined v-model="formData.password" type="password" label="Password"></q-input>
			<small class="form-text text-muted">We'll never share your email with anyone else.</small>

		</div>

		<div class="row">
			<q-space></q-space>
			<q-btn type="submit" color="primary" :label="tab"></q-btn>

		</div>
	</q-form>
</template>

<script>
    import {mapActions} from 'vuex'
    export default {
        props: ['tab'],
        data() {
            return {
                formData: {
                    name: '',
                    email: '',
                    password: ''
                }
            }
        },

        methods: {
            ...mapActions('store', ['registerUser', 'loginUser']),
            submitForm() {
                if (this.tab === 'login') {
                    this.loginUser(this.formData)
                } else {
                    this.registerUser(this.formData)
                }
            }
        }
    }
</script>

<style scoped>

</style>