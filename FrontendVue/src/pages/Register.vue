<template>
	<q-page class="flex q-pa-md">
		<q-card class="full-width">
			<q-separator />

			<q-tab-panels v-model="tab" animated>
				<q-tab-panel name="login">
					<q-form @submit="registerForm">
						<div class="form-group">
							<q-input v-model="register.name" class="q-mb-md form-control" outlined type="name" label="Name"></q-input>
						</div>
						<small class="form-text text-muted" style="color: red" v-if="errors.name"> {{ errors.name[0]}} </small>

						<div class="form-group">
							<q-input v-model="register.email" class="q-mb-md form-control" outlined type="email" label="Email"></q-input>
							<small class="form-text text-muted" style="color: red" v-if="errors.email">{{errors.email[0]}}</small>
						</div>

						<div class="form-group">
							<q-input v-model="register.password" class="q-mb-md form-control" outlined type="password" label="Password"></q-input>
							<small class="form-text text-muted" style="color: red" v-if="errors.password">
								{{errors.password[0]}}
							</small>
						</div>

						<div class="row">
							<q-space></q-space>
							<q-btn type="submit" class="left" color="primary">Register</q-btn>
							<q-space></q-space>
							<q-btn color="primary" to="/login">Login</q-btn>

						</div>
						<div class="row">
						</div>
					</q-form>
				</q-tab-panel>

				<q-tab-panel name="register">
					<LoginRegister :tab="tab"></LoginRegister>
				</q-tab-panel>

			</q-tab-panels>
		</q-card>
	</q-page>
</template>

<script>
	import axios from 'axios'
    import LoginRegister from '../components/LoginRegister'
    import User from "../store/Helpers/User";
    import Token from "../store/Helpers/Token";
    export default {
        components: {LoginRegister},
        data () {
            return {
                tab: 'login',
	            register: {
                    name: "",
		            email: "",
		            password: ""
	            },
	            errors: {}
            }
        },

        created() {
            const auth = this.$store.getters['store/authenticated']
            if (auth) {
                this.$router.replace('/dashboard')
            }

        },

	    methods: {
            registerForm() {
               axios.post('http://127.0.0.1:8000/api/auth/signUp', this.register)
	               .then( response => {
	                   User.responseAfterLogin(response)
                       window.location.href = "/dashboard"
	               })
	               .catch( error => {
		               this.errors = error.response.data.errors
	               })
            }
	    }
    }
</script>