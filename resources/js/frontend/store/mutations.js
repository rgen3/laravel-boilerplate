export default {
  SET_CURRENT_COMMENT_ID: (state, currentCommentId) => {
    state.comments.currentCommentId = currentCommentId
  },
  SET_CURRENT_COMMENT_BRANCH: (state, currentCommentBranchId) => {
    state.comments.currentCommentBranchId = currentCommentBranchId
  },
  UNSET_CURRENT_COMMENT_BRANCH: state => {
    state.comments.currentCommentBranchId = null
  },
  EDIT_COMMENT: (state, commentId) => {
    state.comments.editingCommentId = commentId
  }
}
