export function createActions() {
  return {
    SET_CURRENT_COMMENT_ID: ({ commit }, commentId) => {
      commit('SET_CURRENT_COMMENT_ID', commentId)
    }
  }
}
