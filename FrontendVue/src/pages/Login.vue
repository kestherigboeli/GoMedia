<template>
	<q-page class="flex q-pa-md">
		<q-card class="full-width">
			<q-separator />

			<q-tab-panels v-model="tab" animated>
				<q-tab-panel name="login">
					<q-form @submit="login">
						<div class="form-group">
							<small class="form-text text-muted" style="color: red;" v-if="error">{{error}}</small>
							<q-input class="q-mb-md form-control" v-model="form.email" outlined type="email" label="Email"></q-input>
						</div>

						<div class="form-group">
							<q-input class="q-mb-md form-control" v-model="form.password" outlined type="password" label="Password"></q-input>
						</div>

						<div class="row">
							<q-space></q-space>
							<q-btn type="submit" class="left" color="primary">Login</q-btn>
							<q-space></q-space>
							<q-btn color="primary" to="/register">Register</q-btn>

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

    import LoginRegister from '../components/LoginRegister'
    import {login} from "../store/auth";
    import {apiUrl} from "../store/config";
    import { mapActions } from 'vuex'
    import store from '../store'

    export default {
        components: {LoginRegister},
        data () {
            return {
                tab: 'login',
                form: {
                    email: "",
	                password: ""
                },
	            error: ''
            }
        },

	    created() {
            const auth = this.$store.getters['store/authenticated']
		    if (auth) {
                this.$router.replace('/dashboard')
		    }

	    },

        methods: {
	        ...mapActions('store', ['signIn']),

            login() {
	            this.error = ''
	            this.signIn(this.form)
		            .then( () => {
		                this.$router.replace('/dashboard')
		            })
		            .catch( ( error) => {
		                this.error = error.response.data.error
		            })
            },
        },

    }
</script>
