<template>
	<div class="q-pa-md">
		<q-markup-table>
			<thead>
			<tr>
				<th class="text-left">Name</th>
				<th class="text-left">Description</th>
				<th class="text-left">Price</th>
				<th class="text-left">Stock</th>
				<th class="text-left">Created By</th>
				<th class="text-left">Created At</th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="product in getAll" :key="product.id">
				<td class="text-left">{{product.name}}</td>
				<td class="text-left">{{product.description}}</td>
				<td class="text-left">£{{product.price}}</td>
				<td class="text-left">{{product.stock}}</td>
				<td class="text-left">{{product.user.name}}</td>
				<td class="text-left">{{product.created_at}}</td>

			</tr>
			</tbody>
		</q-markup-table>
	</div>
</template>
<script>
    import axios from 'axios'
    import {mapActions, mapGetters} from 'vuex'

    export default {

        data () {
            return {
               products: {}
            }
        },

        created() {
            const auth = this.$store.getters['store/authenticated'];
            if (!auth) {
                 return this.$router.replace({name: 'home'})
            }

            this.$store.dispatch('store/getProducts')
        },


        computed: {
            getAll() {
                return this.$store.getters['store/products']
            },
        },

	    methods: {
		    ...mapActions('store', ['getProducts']),

            // getProductss() {
		     //   this.getProducts()
            //
            // }
	    }

    }
</script>

<style scoped>

</style>