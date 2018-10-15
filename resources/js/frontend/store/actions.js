import axios from 'axios'

export function createActions() {
  return {
    SET_CURRENT_COMMENT_ID: ({ commit }, commentId) => {
      commit('SET_CURRENT_COMMENT_ID', commentId)
    },
    SET_CURRENT_COMMENT_BRANCH: ({ commit }, commentBranchId) => {
      commit('SET_CURRENT_COMMENT_BRANCH', commentBranchId)
    },
    UNSET_CURRENT_COMMENT_BRANCH: ({ commit }) => {
      commit('UNSET_CURRENT_COMMENT_BRANCH')
    },
    EDIT_COMMENT: ({ commit }, commentId) => {
      commit('EDIT_COMMENT', commentId)
    },
    CREATE_COMMENT: ({ commit }, comment) => {
      return axios.post('/comment/create/post', comment)
    },
    UPDATE_COMMENT: ({ commit }, comment) => {
      return axios.post('/comment/update', comment)
    }
  }
}
