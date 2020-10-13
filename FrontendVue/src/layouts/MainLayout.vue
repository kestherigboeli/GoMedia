<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>

        <q-btn
                v-if="$route.fullPath.includes('/dashboard')"
                to="/dashboard"
                flat
                dense
                label="Dashboard"

        >

        </q-btn>

        <q-toolbar-title class="absoluet-center">
          {{ title}}
        </q-toolbar-title
        ><q-toolbar-title class="absoluet-center">
          <q-btn flat dense class="q-mr-lg" to="/">Home</q-btn>
        </q-toolbar-title>

        <q-btn flat dense class="q-mr-lg" to="/login" v-if="!authenticated">Login</q-btn>
        <q-btn flat dense class="q-mr-lg" v-if="authenticated" @click="logoutUser()">Logout</q-btn>
        <q-btn flat dense class="q-mr-lg" v-if="authenticated" to="/dashboard">Welcome: {{user.name}}</q-btn>

      </q-toolbar>

    </q-header>


    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
    export default {
        components: {  },
        computed: {
            ...mapGetters('store', ['authenticated', 'user']),
            title() {
                let currentPath = this.$route.fullPath
                if (currentPath === '/') {
                    return 'Go Media'
                } else if (currentPath === '/login') {
                    return "Please login"
                } else if (currentPath === '/register') {
                    return "Please Register"
                }
            },
        },


        methods: {
            ...mapActions('store', ['signOut']),

            logoutUser() {
              this.signOut(localStorage.getItem('token'))
                  .then( () => {
                      this.$router.replace({name: 'home'})
                  })
                  .catch( () => {
                      localStorage.clear();
                      window.location.reload()
                  })
            }

        }
    }
</script>
