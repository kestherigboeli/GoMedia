import store from '../store/store'
import Router from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '',  name: 'home', component: () => import('pages/Index.vue') },
      { path: '/login', name: 'login', component: () => import('pages/Login.vue'),
      },
      { path: '/register', component: () => import('pages/Register.vue') },
      { path: '/dashboard', name: 'dashboard', component: () => import('pages/Dashboard.vue'),
      }
    ],
  },



  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]


export default routes
