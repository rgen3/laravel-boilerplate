import Vue from 'vue'
import Vuex from 'vuex'

import { createActions } from './actions'
import mutations from './mutations'

Vue.use(Vuex)

export function createStore() {
  const actions = createActions()

  return new Vuex.Store({
    state: {
      comments: {
        currentCommentId: null
      }
    },
    actions,
    mutations
  })
}
