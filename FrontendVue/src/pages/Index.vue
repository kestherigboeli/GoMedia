<template>
  <q-page class="flex flex-center">
    <div class="column">

      <h3>Welcome <strong>{{!authenticated ? "" : "Please login"}}</strong></h3>
    </div>

  </q-page>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
export default {
  name: 'PageIndex',

    methods: {
        ...mapGetters('store', ['authenticated', 'user']),
    }
}
</script>
