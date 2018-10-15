import loadClientScripts from './load-client-scripts'

// Vue & axios
import Vue from 'vue'
import { axios } from '../axios-config'

import 'babel-polyfill'
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm'

import { createLocales } from '../vue-i18n-config'

import CommentComponent from './component/comment/Comment'
import CommentList from './component/comment/CommentList'
import CommentItem from './component/comment/CommentItem'
import { createStore } from './store'

window.axios = axios

// Bootstrap Vue
Vue.use(BootstrapVue)

Vue.component('comment-component', CommentComponent)
Vue.component('comment-list', CommentList)
Vue.component('comment-item', CommentItem)

export function createApp() {
  const i18n = createLocales(window.locale)
  const store = createStore()

  const app = new Vue({
    store,
    i18n
  })

  return { app }
}

// Load Client Scripts
loadClientScripts(createApp)
